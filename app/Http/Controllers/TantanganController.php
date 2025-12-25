<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TantanganUser;
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

        // ✅ CLEAR CACHE AGAR LAPORAN SELALU FRESH
        \Illuminate\Support\Facades\Cache::forget('laporan_' . auth()->id());
        \Illuminate\Support\Facades\Cache::forget('stats_' . auth()->id());

        return back()->with('success', 'Tantangan berhasil dibuat dan akan terupdate di Laporan Kesehatan!');
    }

    public function progres()
    {
        $userId = auth()->id();

        // Ambil tantangan terbaru user
        $tantangan = TantanganUser::where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->first();

        if (!$tantangan) {
            return view('tantangan.progres', [
                'pesan' => 'Belum ada tantangan aktif'
            ]);
        }

        // Hitung progres kalori keluar hari ini
        $kaloriHariIni = AktivitasUser::where('user_id', $userId)
            ->whereDate('tanggal', now())
            ->sum('kalori_terbakar');

        $selesai = false; // placeholder since target columns don't exist

        return view('tantangan.progres', compact('tantangan', 'kaloriHariIni', 'selesai'));
    }

    public function acceptPlan(Request $request)
    {
        $user = auth()->user();
        // validate request input (plan JSON or derive it again)
        $request->validate([
            'plan' => 'required|array',
            'name' => 'nullable|string|max:255',
            'target_type' => 'nullable|string',
            'target_value' => 'nullable|numeric'
        ]);

        $plan = $request->input('plan');

        $challenge = \App\Models\TantanganUser::create([
            'creator_user_id' => null, // system
            'user_id' => $user->id,
            'nama_tantangan' => $request->input('name') ?? 'Rencana Latihan Personalisasi',
            'status' => 'active',
            'target_type' => $request->input('target_type') ?? 'sessions',
            'target_value' => $request->input('target_value') ?? 12,
            'progress_value' => 0,
            'workout_plan' => $plan,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addWeeks(4),
            'reward' => $request->input('reward') ?? null,
        ]);

        // ✅ CLEAR CACHE AGAR LAPORAN SELALU FRESH
        \Illuminate\Support\Facades\Cache::forget('laporan_' . $user->id);
        \Illuminate\Support\Facades\Cache::forget('stats_' . $user->id);

        return redirect()->route('tantangan.progres')->with('success', 'Rencana disimpan sebagai tantangan dan akan terupdate di Laporan Kesehatan!');
    }

    public function tambahProgress(Request $request, $id)
    {
        $request->validate(['amount' => 'required|numeric|min:0.1']);
        $challenge = TantanganUser::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $challenge->addProgress($request->amount);
        return back()->with('success', 'Progress diupdate');
    }

}
