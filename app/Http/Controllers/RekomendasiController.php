<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workout;

class RekomendasiController extends Controller
{
    // Define available body parts
    private $bodyParts = [
        'chest' => 'Dada',
        'back' => 'Punggung',
        'shoulders' => 'Bahu',
        'biceps' => 'Biceps',
        'triceps' => 'Triceps',
        'quadriceps' => 'Paha Depan',
        'hamstrings' => 'Paha Belakang',
        'glutes' => 'Bokong',
        'calves' => 'Betis',
        'abdominals' => 'Perut',
    ];

    public function rekomendasiWorkout(Request $request)
    {
        $user = auth()->user();

        $imt = $user->hitungIMT();
        $kategori = $user->kategoriIMT();

        // Define available body parts
        $bodyParts = [
            'chest' => 'Dada',
            'back' => 'Punggung',
            'shoulders' => 'Bahu',
            'biceps' => 'Biceps',
            'triceps' => 'Triceps',
            'quadriceps' => 'Paha Depan',
            'hamstrings' => 'Paha Belakang',
            'glutes' => 'Bokong',
            'calves' => 'Betis',
            'abdominals' => 'Perut',
        ];

        // Get user's workout experience level (from request or default to beginner)
        $experience = $request->input('experience', 'beginner');

        // Get selected body parts (from request or all)
        $selectedBodyParts = $request->input('body_parts', array_keys($bodyParts));
        if (is_string($selectedBodyParts)) {
            $selectedBodyParts = explode(',', $selectedBodyParts);
        }

        // Rekomendasi berdasarkan kategori IMT
        $query = match ($kategori) {
            'Kurus' => Workout::where(function ($q) {
                    $q->where('COL 2', 'push')->orWhere('COL 2', 'pull');
                })->limit(15),
            'Normal' => Workout::query(),
            'Gemuk' => Workout::where('COL 2', 'push')->limit(12),
            'Obesitas' => Workout::where('COL 2', 'push')->limit(10),
            default => Workout::query(),
        };

        // Filter by experience level if not 'all'
        if ($experience !== 'all') {
            $query = $query->where('COL 3', $experience);
        }

        // Filter by selected body parts
        if (!empty($selectedBodyParts)) {
            $query = $query->whereIn('COL 6', $selectedBodyParts);
        }

        // Get the workouts
        $workouts = $query->get();

        // Group by muscle (COL 6)
        $workoutsByMuscle = $workouts->groupBy(function ($w) {
            return $w->getMuscle();
        });

        return view('rekomendasi.workout', compact(
            'imt',
            'kategori',
            'workoutsByMuscle',
            'experience',
            'selectedBodyParts',
            'bodyParts'
        ));
    }
}