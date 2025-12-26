<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktivitasUser;
use App\Models\MakananUser;
use App\Models\TidurUser;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function kesehatan(Request $request)
    {
        try {
            // ✅ PASTIKAN CACHE FRESH (clear cache saat user akses laporan)
            $tempUserId = auth()->id();
            if ($tempUserId) {
                \Illuminate\Support\Facades\Cache::forget('laporan_' . $tempUserId);
                \Illuminate\Support\Facades\Cache::forget('stats_' . $tempUserId);
            }

            // Debug auth - detailed logging
            $authCheck = auth()->check();
            $userId = auth()->id();
            $userSession = auth()->user();
            
            \Log::info('Laporan kesehatan accessed', [
                'authenticated' => $authCheck,
                'user_id' => $userId,
                'user_has_data' => $userSession ? 'YES' : 'NO',
                'user_name' => $userSession?->nama ?? 'NONE',
                'ip' => $request->ip(),
                'session_id' => session()->getId(),
            ]);
            
            if (!auth()->check()) {
                \Log::warning('Laporan kesehatan access denied - not authenticated');
                return redirect()->route('login.form')->with('error', 'Silahkan login terlebih dahulu');
            }
            
            $user = auth()->user();
            
            $userId = $user->id;

        // Get periode dari request atau default
        $periode = $request->get('periode', '30');
        
        // Get data dari berbagai periode
        $today = now()->toDateString();
        $periodDays = (int)$periode;
        $startDate = now()->subDays($periodDays)->toDateString();

        // Data Aktivitas (Berat, Olahraga)
        $aktivitasHari = AktivitasUser::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->first();

        $aktivitasPeriode = AktivitasUser::where('user_id', $userId)
            ->whereBetween('tanggal', [$startDate, $today])
            ->orderBy('tanggal', 'asc')
            ->get();

        // Data Tidur
        $tidurHari = TidurUser::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->first();

        $tidurPeriode = TidurUser::where('user_id', $userId)
            ->whereBetween('tanggal', [$startDate, $today])
            ->orderBy('tanggal', 'asc')
            ->get();

        // Data Makanan
        $makananHari = MakananUser::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->with('makanan')
            ->get();

        $makananPeriode = MakananUser::where('user_id', $userId)
            ->whereBetween('tanggal', [$startDate, $today])
            ->with('makanan')
            ->get();

        // Perhitungan Statistik
        $stats = $this->hitungStatistik($aktivitasHari, $aktivitasPeriode, $tidurHari, $tidurPeriode, $makananHari, $makananPeriode, $user);

        // Rekomendasi
        $rekomendasi = $this->buatRekomendasi($stats, $user, $aktivitasPeriode, $tidurPeriode);

        // Data untuk chart
        try {
            $chartData = $this->buatChartData($aktivitasPeriode, $tidurPeriode, $makananPeriode);
        } catch (\Exception $e) {
            \Log::error('Chart data error', ['error' => $e->getMessage()]);
            $chartData = [];
        }

            // Render laporan lengkap
            \Log::info('Rendering laporan view', ['user' => $user->nama, 'stats_count' => count($stats)]);
            return view('laporan.kesehatan-baru', compact('user', 'stats', 'rekomendasi', 'chartData', 'periode', 'aktivitasPeriode', 'tidurPeriode', 'makananPeriode'));
        } catch (\Exception $e) {
            \Log::error('Laporan kesehatan error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return view('errors.custom', [
                'message' => 'Gagal membuka laporan kesehatan: ' . $e->getMessage(),
                'code' => 500
            ]);
        }
    }

    private function hitungStatistik($aktivitasHari, $aktivitasPeriode, $tidurHari, $tidurPeriode, $makananHari, $makananPeriode, $user)
    {
        try {
            // Try to calculate calories safely
            $kaloriTarget = 2000;
            if ($user && $user->berat && $user->tinggi && $user->tanggal_lahir) {
                $kaloriTarget = $user->hitungKaloriHarian() ?? 2000;
            }
            
            $makananHariTotal = $makananHari ? $makananHari->sum('total_kalori') : 0;
            
            // Calculate nutrition averages from makanan relationships
            $totalProteinPeriode = 0;
            $totalKarboPeriode = 0;
            $totalLemakPeriode = 0;
            $hari_dengan_makanan = 0;
            
            if ($makananPeriode && $makananPeriode->count() > 0) {
                $makananByDate = $makananPeriode->groupBy('tanggal');
                $hari_dengan_makanan = $makananByDate->count();
                
                foreach ($makananPeriode as $makanan) {
                    if ($makanan->makanan) {
                        $totalProteinPeriode += ($makanan->makanan->protein ?? 0) * ($makanan->porsi ?? 1);
                        $totalKarboPeriode += ($makanan->makanan->karbohidrat ?? 0) * ($makanan->porsi ?? 1);
                        $totalLemakPeriode += ($makanan->makanan->lemak ?? 0) * ($makanan->porsi ?? 1);
                    }
                }
            }
            
            $proteinAvg = $hari_dengan_makanan > 0 ? round($totalProteinPeriode / $hari_dengan_makanan, 1) : 0;
            $karboAvg = $hari_dengan_makanan > 0 ? round($totalKarboPeriode / $hari_dengan_makanan, 1) : 0;
            $lemakAvg = $hari_dengan_makanan > 0 ? round($totalLemakPeriode / $hari_dengan_makanan, 1) : 0;
            
            $stats = [
                // Hari ini
                'berat_hari' => $aktivitasHari?->berat_badan ?? '-',
                'tidur_hari' => $tidurHari?->durasi_jam ?? '-',
                'olahraga_hari' => $aktivitasHari?->olahraga ?? 0,
                'kalori_hari' => $makananHariTotal,

                // Periode
                'berat_periode_avg' => $aktivitasPeriode->count() > 0 ? round($aktivitasPeriode->avg('berat_badan'), 1) : '-',
                'tidur_periode_avg' => $tidurPeriode->count() > 0 ? round($tidurPeriode->avg('durasi_jam'), 1) : '-',
                'olahraga_periode_avg' => $aktivitasPeriode->count() > 0 ? round($aktivitasPeriode->avg('olahraga'), 1) : 0,
                'olahraga_periode_total' => $aktivitasPeriode->sum('olahraga') ?? 0,
                'kalori_periode_avg' => $makananPeriode->count() > 0 ? round($makananPeriode->sum('total_kalori') / $hari_dengan_makanan, 1) : 0,
                'kalori_periode_total' => $makananPeriode->sum('total_kalori') ?? 0,
                'tidur_periode_total' => $tidurPeriode->sum('durasi_jam') ?? 0,

                // Nutrition averages (calculated from related makanan data)
                'protein_avg' => $proteinAvg,
                'karbo_avg' => $karboAvg,
                'lemak_avg' => $lemakAvg,

                // Perubahan
                'berat_perubahan' => $this->hitungPerubahan($aktivitasPeriode, 'berat_badan'),
                'tidur_perubahan' => $this->hitungPerubahan($tidurPeriode, 'durasi_jam'),

                // Data counts
                'aktivitas_periode_count' => $aktivitasPeriode->count(),
                'tidur_periode_count' => $tidurPeriode->count(),
                'makanan_periode_count' => $makananPeriode->count(),

                // Target
                'kalori_target' => $kaloriTarget,
                'kalori_persen' => $makananHariTotal > 0 ? round(($makananHariTotal / $kaloriTarget) * 100, 1) : 0,
                'tidur_target' => 8,
            ];

            return $stats;
        } catch (\Exception $e) {
            \Log::error('Error in hitungStatistik', ['error' => $e->getMessage()]);
            return [
                'berat_hari' => '-',
                'tidur_hari' => '-',
                'olahraga_hari' => 0,
                'kalori_hari' => 0,
                'berat_periode_avg' => '-',
                'tidur_periode_avg' => '-',
                'olahraga_periode_avg' => 0,
                'olahraga_periode_total' => 0,
                'kalori_periode_avg' => 0,
                'kalori_periode_total' => 0,
                'tidur_periode_total' => 0,
                'protein_avg' => 0,
                'karbo_avg' => 0,
                'lemak_avg' => 0,
                'berat_perubahan' => 0,
                'tidur_perubahan' => 0,
                'aktivitas_periode_count' => 0,
                'tidur_periode_count' => 0,
                'makanan_periode_count' => 0,
                'kalori_target' => 2000,
                'kalori_persen' => 0,
                'tidur_target' => 8,
            ];
        }
    }

    private function hitungPerubahan($collection, $field)
    {
        if ($collection->count() < 2) return 0;
        
        $nilai_awal = $collection->first()?->{$field} ?? 0;
        $nilai_akhir = $collection->last()?->{$field} ?? 0;
        
        if ($nilai_awal == 0) return 0;
        return round((($nilai_akhir - $nilai_awal) / $nilai_awal) * 100, 1);
    }

    private function buatChartData($aktivitas, $tidur, $makanan)
    {
        $labels = [];
        $beratData = [];
        $tidurData = [];
        $olahragaData = [];

        foreach ($aktivitas as $a) {
            $labels[] = Carbon::parse($a->tanggal)->format('d M');
            $beratData[] = (float)$a->berat_badan;
            $olahragaData[] = (int)$a->olahraga;
        }

        foreach ($tidur as $t) {
            $tidurData[Carbon::parse($t->tanggal)->format('d M')] = (float)$t->durasi_jam;
        }

        return [
            'labels' => json_encode($labels),
            'berat' => json_encode($beratData),
            'tidur' => json_encode(array_values($tidurData)),
            'olahraga' => json_encode($olahragaData),
        ];
    }

    private function buatRekomendasi($stats, $user, $aktivitasPeriode, $tidurPeriode)
    {
        $saran = [];

        // Cek Tidur
        if ($stats['tidur_periode_avg'] !== '-' && $stats['tidur_periode_avg'] < 6) {
            $saran[] = [
                'type' => 'warning',
                'icon' => 'fas fa-moon',
                'color' => 'yellow',
                'title' => 'Istirahat Kurang',
                'message' => 'Rata-rata tidur Anda ' . $stats['tidur_periode_avg'] . ' jam/hari. Target optimal adalah 7-8 jam. Tingkatkan durasi tidur untuk kesehatan optimal.'
            ];
        }

        // Cek Olahraga
        if ($stats['olahraga_periode_total'] < 150) {
            $saran[] = [
                'type' => 'warning',
                'icon' => 'fas fa-fire',
                'color' => 'orange',
                'title' => 'Aktivitas Fisik Kurang',
                'message' => 'Total olahraga Anda ' . $stats['olahraga_periode_total'] . ' menit. Target WHO adalah 150 menit per minggu. Tingkatkan aktivitas fisik Anda.'
            ];
        }

        // Cek Kalori
        if ($stats['kalori_persen'] > 120) {
            $saran[] = [
                'type' => 'info',
                'icon' => 'fas fa-apple-alt',
                'color' => 'blue',
                'title' => 'Kalori Berlebih',
                'message' => 'Asupan kalori Anda ' . round($stats['kalori_persen']) . '% dari target. Perhatikan porsi makanan untuk keseimbangan nutrisi.'
            ];
        }

        // Cek Berat
        if ($stats['berat_periode_avg'] !== '-') {
            $imt = $this->hitungIMT($stats['berat_periode_avg'], $user->tinggi ?? 170);
            if ($imt !== null && $imt > 25) {
                $saran[] = [
                    'type' => 'warning',
                    'icon' => 'fas fa-weight',
                    'color' => 'red',
                    'title' => 'IMT Tinggi',
                    'message' => 'Indeks Massa Tubuh Anda ' . $imt . ' (Gemuk). Pertimbangkan konsultasi dengan ahli gizi dan tingkatkan aktivitas fisik.'
                ];
            } elseif ($imt !== null && $imt < 18.5) {
                $saran[] = [
                    'type' => 'info',
                    'icon' => 'fas fa-weight',
                    'color' => 'blue',
                    'title' => 'IMT Rendah',
                    'message' => 'Indeks Massa Tubuh Anda ' . $imt . ' (Kurus). Pertimbangkan konsultasi dengan ahli gizi untuk asupan nutrisi yang tepat.'
                ];
            }
        }

        // Cek Progress Positif
        if ($stats['tidur_periode_avg'] !== '-' && $stats['tidur_periode_avg'] >= 7) {
            $saran[] = [
                'type' => 'success',
                'icon' => 'fas fa-check-circle',
                'color' => 'green',
                'title' => 'Tidur Berkualitas',
                'message' => 'Rata-rata tidur Anda ' . $stats['tidur_periode_avg'] . ' jam/hari. Pertahankan pola tidur yang sehat!'
            ];
        }

        // Motivasi
        if (empty($saran)) {
            $saran[] = [
                'type' => 'success',
                'icon' => 'fas fa-star',
                'color' => 'green',
                'title' => 'Gaya Hidup Sehat!',
                'message' => 'Kesehatan Anda dalam kondisi baik. Terus pertahankan rutinitas kesehatan yang sudah Anda jalankan!'
            ];
        }

        return $saran;
    }

    private function hitungIMT($berat, $tinggi)
    {
        if (!$tinggi || $tinggi == 0) return null;
        return round($berat / (($tinggi / 100) ** 2), 1);
    }

    public function exportPdf(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login.form');
        }

        $user = auth()->user();
        $userId = $user->id;
        $periode = $request->get('periode', '30');
        
        // Get data dari berbagai periode
        $today = now()->toDateString();
        $periodDays = (int)$periode;
        $startDate = now()->subDays($periodDays)->toDateString();

        // Data Aktivitas (Berat, Olahraga)
        $aktivitasHari = AktivitasUser::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->first();

        $aktivitasPeriode = AktivitasUser::where('user_id', $userId)
            ->whereBetween('tanggal', [$startDate, $today])
            ->get();

        // Data Tidur
        $tidurHari = TidurUser::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->first();

        $tidurPeriode = TidurUser::where('user_id', $userId)
            ->whereBetween('tanggal', [$startDate, $today])
            ->get();

        // Data Makanan
        $makananHari = MakananUser::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->get();

        $makananPeriode = MakananUser::where('user_id', $userId)
            ->whereBetween('tanggal', [$startDate, $today])
            ->get();

        // Hitung statistik
        $stats = $this->hitungStatistik($aktivitasHari, $aktivitasPeriode, $tidurHari, $tidurPeriode, $makananHari, $makananPeriode, $user);

        // Generate HTML for PDF
        $html = view('laporan.kesehatan-pdf', [
            'user' => $user,
            'stats' => $stats,
            'periode' => $periode,
            'aktivitasPeriode' => $aktivitasPeriode,
            'tidurPeriode' => $tidurPeriode,
            'makananPeriode' => $makananPeriode,
        ])->render();

        // Save to file and download
        $fileName = 'Laporan-Kesehatan-' . $user->nama . '-' . now()->format('Y-m-d') . '.pdf';
        
        // Simple method: Create HTML and let browser download
        return response($html)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
