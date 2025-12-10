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

        // Hitung total kalori dan makronutrien berdasarkan porsi
        $totalKalori = $info->kalori * $request->porsi;
        $totalProtein = ($info->protein ?? 0) * $request->porsi;
        $totalKarbohidrat = ($info->karbohidrat ?? 0) * $request->porsi;
        $totalLemak = ($info->lemak ?? 0) * $request->porsi;

        Log::info('MakananController::tambahMakanan calculated values', [
            'totalKalori' => $totalKalori,
            'totalProtein' => $totalProtein,
            'totalKarbohidrat' => $totalKarbohidrat,
            'totalLemak' => $totalLemak,
        ]);

        try {

            // Try direct DB insert instead of Eloquent
            $insertedId = \DB::table('makanan_user')->insertGetId([
                'user_id' => auth()->id(),
                'makanan_id' => $info->id,
                'tanggal' => now()->toDateString(),
                'porsi' => $request->porsi,
                'total_kalori' => $totalKalori,
                'protein' => $totalProtein,
                'karbohidrat' => $totalKarbohidrat,
                'lemak' => $totalLemak,
            ]);

            // Retrieve the created record for logging
            $created = \DB::table('makanan_user')->where('id', $insertedId)->first();

            Log::info('MakananController::tambahMakanan created successfully', [
                'created_id' => $created->id,
                'user_id' => $created->user_id,
                'makanan_id' => $created->makanan_id,
                'total_kalori' => $created->total_kalori,
                'protein' => $created->protein,
                'karbohidrat' => $created->karbohidrat,
                'lemak' => $created->lemak,
                'tanggal' => $created->tanggal,
            ]);
            Log::info('MakananController::tambahMakanan created successfully', [
                'created_id' => $created->id,
                'user_id' => $created->user_id,
                'makanan_id' => $created->makanan_id,
                'total_kalori' => $created->total_kalori,
                'protein' => $created->protein,
                'karbohidrat' => $created->karbohidrat,
                'lemak' => $created->lemak,
                'tanggal' => $created->tanggal,
            ]);
        } catch (\Exception $e) {
            Log::error('MakananController::tambahMakanan failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Gagal menyimpan makanan: ' . $e->getMessage()]);
        }

        return back()->with('success', 'Makanan berhasil ditambahkan!');
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
            ->whereDate('tanggal', now()->toDateString())  // Changed for consistency
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
}