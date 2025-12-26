<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TidurUser;

class TidurController extends Controller
{
    public function simpan(Request $request)
    {
        $request->validate([
            'durasi_tidur' => 'required|numeric|min:0.25',
            'kualitas_tidur' => 'nullable|numeric',
            'fase_tidur' => 'nullable|string'
        ]);

        // store into the model's durasi_jam field so analisis() uses it
        \App\Models\TidurUser::create([
            'user_id' => auth()->id(),
            'durasi_jam' => $request->durasi_tidur,
            'kualitas_tidur' => $request->kualitas_tidur ?? null,
            'fase_tidur' => $request->fase_tidur ?? null,
            'tanggal' => now()->toDateString()
        ]);

        // ✅ CLEAR CACHE AGAR LAPORAN SELALU FRESH
        \Illuminate\Support\Facades\Cache::forget('laporan_' . auth()->id());
        \Illuminate\Support\Facades\Cache::forget('stats_' . auth()->id());

        return back()->with('success', 'Data tidur tersimpan dan akan terupdate di Laporan Kesehatan');
    }

    public function analisis()
    {
        $userId = auth()->id();
        $today = now()->toDateString();

        // Data tidur hari ini (ambil yang paling terbaru)
        $tidurHariIni = TidurUser::where('user_id', $userId)
            ->where('tanggal', $today)
            ->orderBy('id', 'desc')
            ->first();

        // Riwayat tidur 7 hari terakhir (diurutkan dari terbaru)
        $riwayatTidur = TidurUser::where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->limit(7)
            ->get();

        // Total tidur bulan ini
        $totalTidurBulanIni = TidurUser::where('user_id', $userId)
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->sum('durasi_jam');

        // Rata-rata tidur 7 hari (hanya dari data yang ada)
        $rataRataTidur = 0;
        if ($riwayatTidur->count() > 0) {
            $totalJam = $riwayatTidur->sum('durasi_jam');
            $rataRataTidur = $totalJam / $riwayatTidur->count();
        }

        // Analisis hasil
        $hasil = $tidurHariIni
            ? $tidurHariIni->analisis()
            : "Belum ada data tidur hari ini";

        return view('tidur.analisis', compact(
            'tidurHariIni',
            'riwayatTidur',
            'totalTidurBulanIni',
            'rataRataTidur',
            'hasil'
        ));
    }
}
