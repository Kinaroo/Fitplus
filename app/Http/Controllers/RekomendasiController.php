<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workout;

class RekomendasiController extends Controller
{
    public function rekomendasiWorkout()
    {
        $user = auth()->user();

        $imt = $user->hitungIMT();
        $kategori = $user->kategoriIMT();

        // rekomendasi berdasarkan kategori IMT
        $workouts = match ($kategori) {
            'Kurus'    => Workout::where('kategori', 'strength')->get(),
            'Normal'   => Workout::all(),
            'Gemuk'    => Workout::where('kategori', 'cardio')->get(),
            'Obesitas' => Workout::where('kategori', 'low-impact')->get(),
            default    => collect(),
        };

        return view('rekomendasi.workout', compact('imt', 'kategori', 'workouts'));
    }
}
