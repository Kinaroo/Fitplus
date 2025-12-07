<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        $totalKalori = MakananUser::where('user_id', $user->id)
            ->whereDate('tanggal', now()->toDateString())
            ->sum('total_kalori');

        $estimasi = $user->hitungKaloriHarian() ?? 2000;

        return view('kalori.harian', compact('totalKalori', 'estimasi'));
    }
}