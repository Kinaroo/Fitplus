<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoMakanan;
use App\Models\MakananUser;

class MakananController extends Controller
{
    // Menampilkan form dan daftar makanan
    public function showForm()
    {
        $makanan = InfoMakanan::all();
        return view('makanan.tambah', compact('makanan'));
    }

    // Menyimpan makanan yang dimakan user berdasarkan jumlah porsi
    public function tambahMakanan(Request $request)
    {
        $request->validate([
            'makanan_id' => 'required|exists:info_makanan,id',
            'porsi' => 'required|integer|min:1|max:10'
        ]);

        $info = InfoMakanan::find($request->makanan_id);

        // Hitung total kalori berdasarkan porsi
        $totalKalori = $info->kalori * $request->porsi;

        MakananUser::create([
            'user_id' => auth()->id(),
            'makanan_id' => $info->id,
            'tanggal' => now()->toDateString(),
            'porsi' => $request->porsi,
            'total_kalori' => $totalKalori
        ]);

        return back()->with('success', 'Makanan berhasil ditambahkan!');
    }

    // Menampilkan detail gizi makanan berdasarkan porsi
    public function detailGizi(Request $request)
    {
        $request->validate([
            'makanan_id' => 'required|exists:info_makanan,id',
            'porsi' => 'nullable|integer|min:1|max:10'
        ]);

        $info = InfoMakanan::find($request->makanan_id);
        $porsi = $request->porsi ?? 1;

        $gizi = [
            'nama_makanan' => $info->nama_makanan,
            'porsi' => $porsi,
            'kalori' => $info->kalori * $porsi,
            'protein' => $info->protein * $porsi,
            'karbohidrat' => $info->karbohidrat * $porsi,
            'lemak' => $info->lemak * $porsi,
        ];

        return view('makanan.gizi', compact('gizi', 'info', 'porsi'));
    }

    // Menampilkan makanan yang dimakan user hari ini
public function makananHariIni()
{
    $makananHariIni = MakananUser::where('user_id', auth()->id())
        ->whereDate('tanggal', now()->toDateString())  // Changed for consistency
        ->with('makanan')
        ->get();

    return view('makanan.harian', compact('makananHariIni'));
}
}