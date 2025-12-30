<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TantanganUser;
use App\Models\Tantangan;
use App\Models\AktivitasUser;

class TantanganController extends Controller
{
    public function buat(Request $request)
    {
        $request->validate([
            'nama_tantangan' => 'required|string|max:255',
            'target_harian' => 'required|numeric|min:1',
            'durasi_hari' => 'required|numeric|min:1',
            'reward' => 'nullable|string'
        ]);

        TantanganUser::create([
            'user_id' => auth()->id(),
            'nama_tantangan' => $request->nama_tantangan,
            'status' => 'proses',
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays($request->durasi_hari)->toDateString(),
        ]);

        return back()->with('success', 'Tantangan berhasil dibuat dan akan terupdate di Laporan Kesehatan!');
    }

    public function progres()
    {
        $userId = auth()->id();

        // Ambil tantangan terbaru user yang sedang aktif
        $tantangan = TantanganUser::where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->first();

        // Ambil tantangan dari admin yang belum diikuti user
        $availableChallenges = Tantangan::whereDoesntHave('assignments', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('tanggal_selesai', '>=', now()->toDateString())
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        // Hitung progres kalori keluar hari ini
        $kaloriHariIni = AktivitasUser::where('user_id', $userId)
            ->whereDate('tanggal', now())
            ->sum('kalori_terbakar');

        $selesai = false;
        if ($tantangan && $tantangan->target_value && $tantangan->progress_value >= $tantangan->target_value) {
            $selesai = true;
        }

        return view('tantangan.progres', compact('tantangan', 'kaloriHariIni', 'selesai', 'availableChallenges'));
    }

    public function ikutTantangan(Request $request, $id)
    {
        $tantangan = Tantangan::findOrFail($id);
        $userId = auth()->id();

        // Check if user already joined
        $existing = TantanganUser::where('user_id', $userId)
            ->where('tantangan_id', $id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah mengikuti tantangan ini!');
        }

        TantanganUser::create([
            'user_id' => $userId,
            'nama_tantangan' => $tantangan->nama,
            'status' => 'proses',
            'tanggal_mulai' => $tantangan->tanggal_mulai,
            'tanggal_selesai' => $tantangan->tanggal_selesai,
            'tantangan_id' => $tantangan->id,
            'target_value' => $tantangan->target_value,
            'progress_value' => 0,
            'unit' => $tantangan->unit,
        ]);

        return back()->with('success', 'Berhasil bergabung dengan tantangan: ' . $tantangan->nama);
    }

    public function tambahProgress(Request $request, $id)
    {
        $request->validate(['amount' => 'required|numeric|min:0.1']);
        $challenge = TantanganUser::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $challenge->addProgress($request->amount);
        return back()->with('success', 'Progress diupdate');
    }

}
