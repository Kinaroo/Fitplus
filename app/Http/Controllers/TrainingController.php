<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MakananUser;
use App\Models\Exercise;

class TrainingController extends Controller
{
    /**
     * Calculate BMI and generate training plan based on user metrics
     */
    public function generateTrainingPlan()
    {
        $user = auth()->user();
        
        // Get today's calorie intake
        $totalKaloriHariIni = MakananUser::where('user_id', $user->id)
            ->whereDate('tanggal', now()->toDateString())
            ->sum('total_kalori');

        // Calculate metrics
        $bmi = $user->hitungIMT();
        $estimasiKaloriHarian = $user->hitungKaloriHarian() ?? 2000;
        $kaloriDefisit = $estimasiKaloriHarian - $totalKaloriHariIni;
        
        // Generate training plan
        $trainingPlan = $this->buatRencanaLatihan($user, $bmi, $kaloriDefisit, $totalKaloriHariIni);
        
        return view('training.plan', compact('trainingPlan', 'bmi', 'totalKaloriHariIni', 'estimasiKaloriHarian', 'kaloriDefisit'));
    }

    /**
     * Generate training plan based on metrics
     */
    private function buatRencanaLatihan($user, $bmi, $kaloriDefisit, $totalKaloriHariIni)
    {
        $plan = [
            'user_name' => $user->nama,
            'bmi' => round($bmi, 2),
            'kategori_bmi' => $this->kategoriBMI($bmi),
            'berat_badan' => $user->berat_badan,
            'tinggi_badan' => $user->tinggi_badan,
            'total_kalori_harian' => $totalKaloriHariIni,
            'estimasi_kalori_harian' => $user->hitungKaloriHarian() ?? 2000,
            'kalori_defisit' => $kaloriDefisit,
            'workouts' => [],
        ];

        // Generate workouts based on BMI category and calorie deficit
        if ($bmi < 18.5) {
            $plan['workouts'] = $this->workoutUnderweight();
            $plan['target'] = 'Menambah Berat Badan & Massa Otot';
        } elseif ($bmi < 25) {
            $plan['workouts'] = $this->workoutNormalWeight();
            $plan['target'] = 'Mempertahankan Berat & Meningkatkan Kebugaran';
        } elseif ($bmi < 30) {
            $plan['workouts'] = $this->workoutOverweight();
            $plan['target'] = 'Menurunkan Berat Badan';
        } else {
            $plan['workouts'] = $this->workoutObese();
            $plan['target'] = 'Menurunkan Berat Badan Secara Signifikan';
        }

        return $plan;
    }

    /**
     * Get exercises from database by muscle groups
     */
    private function getExercisesByMuscles($muscles, $limit = 3)
    {
        $exercises = [];
        foreach ($muscles as $muscle) {
            $exs = Exercise::byMuscle($muscle)->byLevel('beginner')->limit($limit)->get();
            if ($exs->count() > 0) {
                $exercises[$muscle] = $exs->map(fn($e) => $e->getName())->toArray();
            }
        }
        return $exercises;
    }

    /**
     * Get random exercise by muscle from database
     */
    private function getRandomExerciseByMuscle($muscle)
    {
        $exercise = Exercise::byMuscle($muscle)->inRandomOrder()->first();
        return $exercise ? $exercise->getName() : $muscle . ' Exercise';
    }

    /**
     * Determine BMI category
     */
    private function kategoriBMI($bmi)
    {
        if ($bmi < 18.5) return 'Kurus (Underweight)';
        if ($bmi < 25) return 'Normal';
        if ($bmi < 30) return 'Gemuk (Overweight)';
        return 'Obesitas';
    }

    /**
     * Workout plan for underweight users
     */
    private function workoutUnderweight()
    {
        return [
            [
                'hari' => 'Senin',
                'fokus' => 'Upper Body Strength',
                'durasi' => '60 menit',
                'kalori_terbakar' => 250,
                'exercises' => [
                    ['nama' => $this->getRandomExerciseByMuscle('chest'), 'sets' => 3, 'reps' => '8-10'],
                    ['nama' => $this->getRandomExerciseByMuscle('shoulders'), 'sets' => 4, 'reps' => '8-10'],
                    ['nama' => $this->getRandomExerciseByMuscle('lats'), 'sets' => 4, 'reps' => '8-10'],
                    ['nama' => $this->getRandomExerciseByMuscle('biceps'), 'sets' => 3, 'reps' => '8-10'],
                ]
            ],
            [
                'hari' => 'Rabu',
                'fokus' => 'Lower Body Strength',
                'durasi' => '60 menit',
                'kalori_terbakar' => 300,
                'exercises' => [
                    ['nama' => $this->getRandomExerciseByMuscle('quadriceps'), 'sets' => 4, 'reps' => '8-10'],
                    ['nama' => $this->getRandomExerciseByMuscle('hamstrings'), 'sets' => 3, 'reps' => '8-10'],
                    ['nama' => $this->getRandomExerciseByMuscle('glutes'), 'sets' => 3, 'reps' => '10-12'],
                    ['nama' => $this->getRandomExerciseByMuscle('calves'), 'sets' => 3, 'reps' => '10-12'],
                ]
            ],
            [
                'hari' => 'Jumat',
                'fokus' => 'Full Body',
                'durasi' => '50 menit',
                'kalori_terbakar' => 200,
                'exercises' => [
                    ['nama' => $this->getRandomExerciseByMuscle('chest'), 'sets' => 3, 'reps' => '10-12'],
                    ['nama' => $this->getRandomExerciseByMuscle('back'), 'sets' => 3, 'reps' => '10-12'],
                    ['nama' => $this->getRandomExerciseByMuscle('quadriceps'), 'sets' => 3, 'reps' => '10-12'],
                ]
            ],
        ];
    }

    /**
     * Workout plan for normal weight users
     */
    private function workoutNormalWeight()
    {
        return [
            [
                'hari' => 'Senin',
                'fokus' => 'Chest & Triceps',
                'durasi' => '45 menit',
                'kalori_terbakar' => 200,
                'exercises' => [
                    ['nama' => $this->getRandomExerciseByMuscle('chest'), 'sets' => 3, 'reps' => '10-12'],
                    ['nama' => $this->getRandomExerciseByMuscle('chest'), 'sets' => 3, 'reps' => '10-12'],
                    ['nama' => $this->getRandomExerciseByMuscle('chest'), 'sets' => 3, 'reps' => '12-15'],
                    ['nama' => $this->getRandomExerciseByMuscle('triceps'), 'sets' => 3, 'reps' => '10-12'],
                ]
            ],
            [
                'hari' => 'Selasa',
                'fokus' => 'Cardio',
                'durasi' => '30 menit',
                'kalori_terbakar' => 250,
                'exercises' => [
                    ['nama' => 'Jogging', 'sets' => 1, 'reps' => '30 menit steady pace'],
                ]
            ],
            [
                'hari' => 'Rabu',
                'fokus' => 'Back & Biceps',
                'durasi' => '45 menit',
                'kalori_terbakar' => 220,
                'exercises' => [
                    ['nama' => $this->getRandomExerciseByMuscle('lats'), 'sets' => 3, 'reps' => '10-12'],
                    ['nama' => $this->getRandomExerciseByMuscle('middle back'), 'sets' => 3, 'reps' => '8-10'],
                    ['nama' => $this->getRandomExerciseByMuscle('middle back'), 'sets' => 3, 'reps' => '15'],
                    ['nama' => $this->getRandomExerciseByMuscle('biceps'), 'sets' => 3, 'reps' => '10-12'],
                ]
            ],
            [
                'hari' => 'Kamis',
                'fokus' => 'HIIT Training',
                'durasi' => '30 menit',
                'kalori_terbakar' => 300,
                'exercises' => [
                    ['nama' => 'High Intensity Interval Training', 'sets' => 3, 'reps' => '1 menit'],
                    ['nama' => 'Jumping Exercises', 'sets' => 3, 'reps' => '30 detik'],
                ]
            ],
            [
                'hari' => 'Jumat',
                'fokus' => 'Legs',
                'durasi' => '45 menit',
                'kalori_terbakar' => 280,
                'exercises' => [
                    ['nama' => $this->getRandomExerciseByMuscle('quadriceps'), 'sets' => 3, 'reps' => '10-12'],
                    ['nama' => $this->getRandomExerciseByMuscle('quadriceps'), 'sets' => 3, 'reps' => '12-15'],
                    ['nama' => $this->getRandomExerciseByMuscle('hamstrings'), 'sets' => 3, 'reps' => '12-15'],
                    ['nama' => $this->getRandomExerciseByMuscle('calves'), 'sets' => 3, 'reps' => '15-20'],
                ]
            ],
            [
                'hari' => 'Sabtu',
                'fokus' => 'Active Recovery / Yoga',
                'durasi' => '45 menit',
                'kalori_terbakar' => 100,
                'exercises' => [
                    ['nama' => 'Stretching', 'sets' => 1, 'reps' => '15 menit'],
                    ['nama' => 'Light Yoga', 'sets' => 1, 'reps' => '30 menit'],
                ]
            ],
        ];
    }

    /**
     * Workout plan for overweight users
     */
    private function workoutOverweight()
    {
        return [
            [
                'hari' => 'Senin',
                'fokus' => 'Lower Body Cardio',
                'durasi' => '40 menit',
                'kalori_terbakar' => 300,
                'exercises' => [
                    ['nama' => 'Warm-up', 'sets' => 1, 'reps' => '5 menit'],
                    ['nama' => $this->getRandomExerciseByMuscle('quadriceps'), 'sets' => 3, 'reps' => '15'],
                    ['nama' => 'Cool-down', 'sets' => 1, 'reps' => '5 menit'],
                ]
            ],
            [
                'hari' => 'Selasa',
                'fokus' => 'Strength Training Ringan',
                'durasi' => '45 menit',
                'kalori_terbakar' => 250,
                'exercises' => [
                    ['nama' => $this->getRandomExerciseByMuscle('quadriceps'), 'sets' => 3, 'reps' => '12-15'],
                    ['nama' => $this->getRandomExerciseByMuscle('chest'), 'sets' => 3, 'reps' => '12-15'],
                    ['nama' => $this->getRandomExerciseByMuscle('lats'), 'sets' => 3, 'reps' => '12-15'],
                    ['nama' => $this->getRandomExerciseByMuscle('middle back'), 'sets' => 3, 'reps' => '12-15'],
                ]
            ],
            [
                'hari' => 'Rabu',
                'fokus' => 'Cardio',
                'durasi' => '40 menit',
                'kalori_terbakar' => 280,
                'exercises' => [
                    ['nama' => 'Warm-up', 'sets' => 1, 'reps' => '5 menit'],
                    ['nama' => 'Cycling / Elliptical', 'sets' => 1, 'reps' => '30 menit'],
                    ['nama' => 'Cool-down', 'sets' => 1, 'reps' => '5 menit'],
                ]
            ],
            [
                'hari' => 'Kamis',
                'fokus' => 'Low Impact Cardio',
                'durasi' => '45 menit',
                'kalori_terbakar' => 220,
                'exercises' => [
                    ['nama' => 'Brisk Walking', 'sets' => 1, 'reps' => '45 menit'],
                ]
            ],
            [
                'hari' => 'Jumat',
                'fokus' => 'Full Body Light Strength',
                'durasi' => '45 menit',
                'kalori_terbakar' => 200,
                'exercises' => [
                    ['nama' => $this->getRandomExerciseByMuscle('chest'), 'sets' => 3, 'reps' => '10-12'],
                    ['nama' => $this->getRandomExerciseByMuscle('back'), 'sets' => 3, 'reps' => '8-10'],
                    ['nama' => $this->getRandomExerciseByMuscle('abdominals'), 'sets' => 3, 'reps' => '30-45 detik'],
                    ['nama' => $this->getRandomExerciseByMuscle('glutes'), 'sets' => 3, 'reps' => '15'],
                ]
            ],
            [
                'hari' => 'Sabtu & Minggu',
                'fokus' => 'Rest or Light Walking',
                'durasi' => '30 menit',
                'kalori_terbakar' => 100,
                'exercises' => [
                    ['nama' => 'Light Walk', 'sets' => 1, 'reps' => '30 menit'],
                ]
            ],
        ];
    }

    /**
     * Workout plan for obese users
     */
    private function workoutObese()
    {
        return [
            [
                'hari' => 'Senin',
                'fokus' => 'Low Impact Cardio',
                'durasi' => '30 menit',
                'kalori_terbakar' => 200,
                'exercises' => [
                    ['nama' => 'Brisk Walking', 'sets' => 1, 'reps' => '30 menit'],
                ]
            ],
            [
                'hari' => 'Selasa',
                'fokus' => 'Basic Strength',
                'durasi' => '30 menit',
                'kalori_terbakar' => 150,
                'exercises' => [
                    ['nama' => $this->getRandomExerciseByMuscle('chest'), 'sets' => 2, 'reps' => '10-12'],
                    ['nama' => $this->getRandomExerciseByMuscle('chest'), 'sets' => 2, 'reps' => '12-15'],
                    ['nama' => $this->getRandomExerciseByMuscle('middle back'), 'sets' => 2, 'reps' => '12-15'],
                    ['nama' => $this->getRandomExerciseByMuscle('quadriceps'), 'sets' => 2, 'reps' => '12-15'],
                ]
            ],
            [
                'hari' => 'Rabu',
                'fokus' => 'Water Activity',
                'durasi' => '30 menit',
                'kalori_terbakar' => 180,
                'exercises' => [
                    ['nama' => 'Water Walking', 'sets' => 1, 'reps' => '30 menit'],
                ]
            ],
            [
                'hari' => 'Kamis',
                'fokus' => 'Stretching & Flexibility',
                'durasi' => '30 menit',
                'kalori_terbakar' => 80,
                'exercises' => [
                    ['nama' => 'Gentle Stretching', 'sets' => 1, 'reps' => '20 menit'],
                    ['nama' => 'Breathing Exercises', 'sets' => 1, 'reps' => '10 menit'],
                ]
            ],
            [
                'hari' => 'Jumat',
                'fokus' => 'Low Impact Cardio',
                'durasi' => '30 menit',
                'kalori_terbakar' => 200,
                'exercises' => [
                    ['nama' => 'Elliptical Machine', 'sets' => 1, 'reps' => '30 menit'],
                ]
            ],
            [
                'hari' => 'Sabtu & Minggu',
                'fokus' => 'Rest & Recovery',
                'durasi' => '20 menit',
                'kalori_terbakar' => 50,
                'exercises' => [
                    ['nama' => 'Light Walk', 'sets' => 1, 'reps' => '20 menit'],
                ]
            ],
        ];
    }
}