<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\MakananUser;

class KaloriController extends Controller
{
    // Hitung estimasi kalori harian user
    public function estimasiKalori()
    {
        $user = auth()->user();
        $estimasi = $user->hitungKaloriHarian();

        return view('kalori.estimasi', compact('estimasi'));
    }

    // Hitung total kalori harian dari makanan yang dimakan user

    public function totalKaloriHarian()
    {
        $user = auth()->user();

        // Debug: fetch ALL entries for the user to see what dates are stored
        $allItems = MakananUser::where('user_id', $user->id)->get();

        Log::info('KaloriController::totalKaloriHarian - ALL items', [
            'user_id' => $user->id,
            'all_count' => $allItems->count(),
            'all_items' => $allItems->map(function ($i) {
                return [
                    'id' => $i->id,
                    'tanggal' => $i->tanggal,
                    'total_kalori' => $i->total_kalori,
                ];
            })->toArray(),
            'today' => now()->toDateString(),
            'today_class' => now()->toDateString() . ' (type: ' . gettype(now()->toDateString()) . ')',
        ]);

        // fetch today's entries for the user
        $makananItems = MakananUser::where('user_id', $user->id)
            ->whereDate('tanggal', now()->toDateString())
            ->get();

        Log::info('KaloriController::totalKaloriHarian - TODAY items', [
            'user_id' => $user->id,
            'count' => $makananItems->count(),
            'items' => $makananItems->map(function ($i) {
                return [
                    'id' => $i->id,
                    'makanan_id' => $i->makanan_id,
                    'porsi' => $i->porsi,
                    'total_kalori' => $i->total_kalori,
                    'tanggal' => $i->tanggal,
                ];
            })->toArray(),
        ]);

        // compute sum robustly (casts and fallback)
        $totalKalori = $makananItems->sum(function ($i) {
            return (float) ($i->total_kalori ?? 0);
        });

        $estimasi = $user->hitungKaloriHarian() ?? 2000;

        return view('kalori.harian', compact('totalKalori', 'estimasi'));
    }
}