<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BMIController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Inisialisasi nilai default - gunakan old() untuk form resubmit atau data user
        $beratBadan = old('berat_badan', $user->berat ?? '');
        $tinggiBadan = old('tinggi_badan', $user->tinggi ?? '');
        $umur = $user->umur ?? 0;
        
        $bmi = 0;
        $kategori = '';
        $rekomendasi = '';
        $warnaBg = 'from-gray-50 to-gray-100';
        $warnaBorder = 'border-gray-400';
        $warnaText = 'text-gray-600';
        $warnaBadge = 'bg-gray-100 text-gray-700';
        
        // Kalkulasi jika ada input dari form
        if ($beratBadan && $tinggiBadan) {
            $tinggiBadanM = $tinggiBadan / 100;
            $bmi = round($beratBadan / ($tinggiBadanM ** 2), 1);
            
            if ($bmi < 18.5) {
                $kategori = 'Berat Badan Kurang';
                $rekomendasi = 'Tingkatkan asupan kalori dan nutrisi. Lakukan olahraga ringan untuk membangun massa otot.';
                $warnaBg = 'from-blue-50 to-cyan-50';
                $warnaBorder = 'border-blue-500';
                $warnaText = 'text-blue-600';
                $warnaBadge = 'bg-blue-100 text-blue-700';
            } elseif ($bmi >= 18.5 && $bmi < 25) {
                $kategori = 'Berat Badan Normal';
                $rekomendasi = 'Pertahankan pola makan sehat dan olahraga teratur 3-5 kali per minggu.';
                $warnaBg = 'from-green-50 to-lime-50';
                $warnaBorder = 'border-green-500';
                $warnaText = 'text-green-600';
                $warnaBadge = 'bg-green-100 text-green-700';
            } elseif ($bmi >= 25 && $bmi < 30) {
                $kategori = 'Berat Badan Berlebih';
                $rekomendasi = 'Kurangi asupan kalori dan tingkatkan aktivitas fisik. Konsultasi dengan ahli gizi.';
                $warnaBg = 'from-yellow-50 to-amber-50';
                $warnaBorder = 'border-yellow-500';
                $warnaText = 'text-yellow-600';
                $warnaBadge = 'bg-yellow-100 text-yellow-700';
            } else {
                $kategori = 'Obesitas';
                $rekomendasi = 'Segera konsultasi dengan dokter dan ahli gizi untuk program penurunan berat badan.';
                $warnaBg = 'from-red-50 to-orange-50';
                $warnaBorder = 'border-red-500';
                $warnaText = 'text-red-600';
                $warnaBadge = 'bg-red-100 text-red-700';
            }
        }
        
        return view('kalori.bmi', compact(
            'bmi',
            'kategori',
            'rekomendasi',
            'beratBadan',
            'tinggiBadan',
            'umur',
            'warnaBg',
            'warnaBorder',
            'warnaText',
            'warnaBadge'
        ));
    }

    public function hitung(Request $request)
    {
        $validated = $request->validate([
            'berat_badan' => 'required|numeric|min:20|max:300',
            'tinggi_badan' => 'required|numeric|min:100|max:250',
        ]);

        $user = auth()->user();

        // ✅ SIMPAN DATA KE DATABASE akun_user
        $user->berat = $validated['berat_badan'];
        $user->tinggi = $validated['tinggi_badan'];
        $user->save();

        return redirect()->route('kalori.bmi')
            ->withInput($validated)
            ->with('success', 'BMI berhasil dihitung dan disimpan! Data akan langsung terupdate di Laporan Kesehatan.');
    }

    /**
     * Reset form BMI calculator
     */
    public function reset()
    {
        return redirect()->route('kalori.bmi')
            ->with('success', 'Form berhasil direset');
    }
}
