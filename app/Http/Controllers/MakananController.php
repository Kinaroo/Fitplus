<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
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
        Log::info('MakananController::tambahMakanan input', $request->all());
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
        return back()->with('success', 'Makanan berhasil ditambahkan dan akan terupdate di Laporan Kesehatan!');
    }

    // Menampilkan detail gizi makanan berdasarkan porsi
    public function detailGizi(Request $request)
    {
        // If someone visits /makanan/gizi directly without parameters,
        // redirect them to the add-food form with a friendly message.
        $makananId = $request->query('makanan_id') ?? $request->input('makanan_id');

        if (!$makananId) {
            return redirect()->route('makanan.form')
                ->withErrors(['makanan_id' => 'Pilih makanan terlebih dahulu.']);
        }

        $request->validate([
            'makanan_id' => 'exists:info_makanan,id',
            'porsi' => 'nullable|integer|min:1|max:10'
        ]);

        $info = InfoMakanan::find($makananId);
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
            ->whereDate('tanggal', now()->toDateString())
            ->with('makanan')
            ->get();

        return view('makanan.harian', compact('makananHariIni'));
    }

    public function search(Request $request)
    {
        $q = $request->query('q', '');
        // Log incoming search requests for debugging
        \Illuminate\Support\Facades\Log::info('MakananController::search', [
            'q' => $q,
            'auth_id' => auth()->id(),
            'ip' => $request->ip(),
        ]);

        if (trim($q) === '') {
            return response()->json([]);
        }

        $results = InfoMakanan::where('nama_makanan', 'like', '%' . $q . '%')
            ->limit(10)
            ->get(['id', 'nama_makanan', 'kalori']);

        return response()->json($results);
    }

    // Delete makanan
    public function deleteMakanan($id)
    {
        try {
            $makanan = MakananUser::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
            
            $makanan->delete();
            
            return redirect()->route('makanan.harian')
                ->with('success', 'Makanan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus makanan: ' . $e->getMessage());
        }
    }
}