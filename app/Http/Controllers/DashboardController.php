<?php

namespace App\Http\Controllers;

use App\Models\AktivitasUser;
use App\Models\MakananUser;
use App\Models\TidurUser;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // CLEAR CACHE untuk memastikan data fresh
        \Illuminate\Support\Facades\Cache::forget('dashboard_' . $user->id);
        
        // Get aktivitas data for weight statistics
        $aktivitas = AktivitasUser::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->limit(30)
            ->get();

        // Get tidur data for sleep statistics (7 days)
        $tidurData = TidurUser::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->limit(7)
            ->get();

        // Calculate statistics
        $rataBerat = $aktivitas->count() > 0 ? round($aktivitas->avg('berat_badan'), 1) : 0;
        
        // Calculate rata-rata tidur from tidur_user table
        $rataTidur = 0;
        if ($tidurData->count() > 0) {
            $totalTidur = $tidurData->sum('durasi_jam');
            $rataTidur = round($totalTidur / $tidurData->count(), 1);
        }
        
        $totalOlahraga = $aktivitas->count() > 0 ? $aktivitas->sum('olahraga') : 0;
        
        // Debug logging
        \Illuminate\Support\Facades\Log::info('Dashboard calculations', [
            'user_id' => $user->id,
            'aktivitas_count' => $aktivitas->count(),
            'avg_berat_badan' => $aktivitas->count() > 0 ? $aktivitas->avg('berat_badan') : null,
            'rata_berat' => $rataBerat,
            'tidur_count' => $tidurData->count(),
            'rata_tidur' => $rataTidur,
            'total_olahraga' => $totalOlahraga
        ]);

        // Get kategori/status untuk setiap metrik
        $statusBerat = $this->getStatusBerat($rataBerat, $user);
        $statusTidur = $this->getStatusTidur($rataTidur);
        $statusOlahraga = $this->getStatusOlahraga($totalOlahraga, $aktivitas->count());

        // Get today's calorie total
        $totalKalori = MakananUser::where('user_id', $user->id)
            ->whereDate('tanggal', now()->toDateString())
            ->sum('total_kalori') ?? 0;

        $estimasiKalori = $user->hitungKaloriHarian() ?? 2000;

        // Get today's health data - ALWAYS FRESH (no cache)
        $todayData = AktivitasUser::where('user_id', $user->id)
            ->whereDate('tanggal', now()->toDateString())
            ->first();
        
        // Get today's tidur data - ALWAYS FRESH
        $todayTidur = TidurUser::where('user_id', $user->id)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        // Debug logging with fresh data
        \Illuminate\Support\Facades\Log::info('Dashboard today data (FRESH)', [
            'user_id' => $user->id,
            'today_date' => now()->toDateString(),
            'todayData' => $todayData ? [
                'id' => $todayData->id,
                'umur' => $todayData->umur,
                'berat_badan' => $todayData->berat_badan,
                'olahraga' => $todayData->olahraga,
                'tanggal' => $todayData->tanggal,
            ] : 'NO DATA',
            'todayTidur' => $todayTidur ? [
                'id' => $todayTidur->id,
                'durasi_jam' => $todayTidur->durasi_jam,
                'tanggal' => $todayTidur->tanggal,
            ] : 'NO DATA',
        ]);

        return view('dashboard', compact(
            'aktivitas',
            'tidurData',
            'rataBerat',
            'rataTidur',
            'totalOlahraga',
            'statusBerat',
            'statusTidur',
            'statusOlahraga',
            'totalKalori',
            'estimasiKalori',
            'user',
            'todayData',
            'todayTidur'
        ));
    }

    /**
     * Menentukan status berat badan berdasarkan IMT
     */
    private function getStatusBerat($rataBerat, $user)
    {
        if ($rataBerat == 0) {
            return [
                'status' => 'Belum Ada Data',
                'color' => 'gray',
                'icon' => 'fa-circle-question',
                'deskripsi' => 'Silakan tambah data kesehatan'
            ];
        }

        if (!$user->tinggi) {
            return [
                'status' => 'Data Tidak Lengkap',
                'color' => 'gray',
                'icon' => 'fa-exclamation-triangle',
                'deskripsi' => 'Lengkapi profil Anda'
            ];
        }

        $imt = $rataBerat / pow($user->tinggi / 100, 2);

        if ($imt < 18.5) {
            return [
                'status' => 'Kurus',
                'color' => 'blue',
                'icon' => 'fa-arrow-down',
                'deskripsi' => 'Tingkatkan asupan nutrisi'
            ];
        } elseif ($imt < 25) {
            return [
                'status' => 'Ideal',
                'color' => 'green',
                'icon' => 'fa-check-circle',
                'deskripsi' => 'Berat badan sudah ideal'
            ];
        } elseif ($imt < 30) {
            return [
                'status' => 'Gemuk',
                'color' => 'orange',
                'icon' => 'fa-arrow-up',
                'deskripsi' => 'Tingkatkan aktivitas fisik'
            ];
        } else {
            return [
                'status' => 'Obesitas',
                'color' => 'red',
                'icon' => 'fa-exclamation-circle',
                'deskripsi' => 'Perlu perhatian khusus'
            ];
        }
    }

    /**
     * Menentukan status tidur
     */
    private function getStatusTidur($rataTidur)
    {
        if ($rataTidur == 0) {
            return [
                'status' => 'Belum Ada Data',
                'color' => 'gray',
                'icon' => 'fa-circle-question',
                'deskripsi' => 'Catat durasi tidur Anda'
            ];
        }

        if ($rataTidur < 6) {
            return [
                'status' => 'Kurang',
                'color' => 'red',
                'icon' => 'fa-arrow-down',
                'deskripsi' => 'Tingkatkan durasi tidur'
            ];
        } elseif ($rataTidur <= 8) {
            return [
                'status' => 'Normal',
                'color' => 'green',
                'icon' => 'fa-check-circle',
                'deskripsi' => 'Durasi tidur ideal'
            ];
        } else {
            return [
                'status' => 'Berlebihan',
                'color' => 'orange',
                'icon' => 'fa-arrow-up',
                'deskripsi' => 'Mungkin ada masalah tidur'
            ];
        }
    }

    /**
     * Menentukan status olahraga
     */
    private function getStatusOlahraga($totalOlahraga, $dataCount)
    {
        if ($dataCount == 0 || $totalOlahraga == 0) {
            return [
                'status' => 'Belum Ada',
                'color' => 'gray',
                'icon' => 'fa-circle-question',
                'deskripsi' => 'Mulai catat olahraga Anda'
            ];
        }

        $rataOlahraga = $dataCount > 0 ? $totalOlahraga / $dataCount : 0;

        if ($totalOlahraga < 150) {
            return [
                'status' => 'Kurang',
                'color' => 'red',
                'icon' => 'fa-arrow-down',
                'deskripsi' => 'Target 150 menit per minggu'
            ];
        } elseif ($totalOlahraga <= 300) {
            return [
                'status' => 'Baik',
                'color' => 'green',
                'icon' => 'fa-check-circle',
                'deskripsi' => 'Olahraga teratur'
            ];
        } else {
            return [
                'status' => 'Excellent',
                'color' => 'blue',
                'icon' => 'fa-trophy',
                'deskripsi' => 'Luar biasa!'
            ];
        }
    }
}
