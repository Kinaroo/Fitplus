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

        // fetch today's entries for the user
        $makananItems = MakananUser::where('user_id', $user->id)
            ->whereDate('tanggal', now()->toDateString())
            ->get();

        // compute sum robustly (casts and fallback)
        $totalKalori = $makananItems->sum(function ($i) {
            return (float) ($i->total_kalori ?? 0);
        });

        // Sum macronutrients
        $totalProtein = $makananItems->sum(function ($i) {
            return (float) ($i->protein ?? 0);
        });

        $totalKarbohidrat = $makananItems->sum(function ($i) {
            return (float) ($i->karbohidrat ?? 0);
        });

        $totalLemak = $makananItems->sum(function ($i) {
            return (float) ($i->lemak ?? 0);
        });

        $estimasi = $user->hitungKaloriHarian() ?? 2000;

        return view('kalori.harian', compact('totalKalori', 'estimasi', 'totalProtein', 'totalKarbohidrat', 'totalLemak'));
    }
}