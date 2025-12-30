<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MakananUser;
use App\Models\Workout;

class TrainingController extends Controller
{
    /**
     * Display list of workouts categorized by difficulty
     */
    public function workouts(Request $request)
    {
        $query = Workout::query();

        // Filter by level
        if ($request->filled('level')) {
            $query->byLevel($request->level);
        }

        // Filter by muscle
        if ($request->filled('muscle')) {
            $query->byMuscle($request->muscle);
        }

        // Filter by force type
        if ($request->filled('force')) {
            $query->byType($request->force);
        }

        $workouts = $query->paginate(20);

        // Get all unique muscles for filter dropdown
        $muscles = Workout::select('COL 6')->distinct()->whereNotNull('COL 6')->where('COL 6', '!=', '')->pluck('COL 6')->sort();

        // Count by levels
        $levelCounts = [
            'beginner' => Workout::byLevel('beginner')->count(),
            'intermediate' => Workout::byLevel('intermediate')->count(),
            'expert' => Workout::byLevel('expert')->count(),
        ];

        return view('training.workouts', compact('workouts', 'muscles', 'levelCounts'));
    }

    /**
     * Display personalized workout schedule based on BMI
     */
    public function schedule()
    {
        $user = auth()->user();
        $bmi = $user->hitungIMT() ?? 22;
        $bmiCategory = $this->kategoriBMI($bmi);
        $recommendedLevel = $this->getRecommendedLevel($bmi);
        $schedule = $this->generateWeeklySchedule($bmi, $recommendedLevel);
        $tips = $this->getTipsForBMI($bmi);

        return view('training.schedule', compact('user', 'bmi', 'bmiCategory', 'recommendedLevel', 'schedule', 'tips'));
    }

    /**
     * Generate new randomized schedule
     */
    public function generateSchedule()
    {
        // Schedule is regenerated on each visit (randomized)
        return redirect()->route('training.schedule')->with('success', 'Jadwal latihan baru telah dibuat!');
    }

    /**
     * Get recommended exercise level based on BMI
     */
    private function getRecommendedLevel($bmi)
    {
        if ($bmi < 18.5) return 'beginner';
        if ($bmi < 25) return 'intermediate';
        if ($bmi < 30) return 'beginner';
        return 'beginner';
    }

    /**
     * Generate weekly workout schedule based on BMI
     */
    private function generateWeeklySchedule($bmi, $level)
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $schedule = [];

        // Define workout focus for each BMI category
        if ($bmi < 18.5) {
            // Underweight: Focus on muscle building
            $focuses = [
                'Senin' => ['focus' => 'Upper Body', 'muscles' => ['chest', 'shoulders', 'triceps'], 'duration' => 45],
                'Selasa' => ['focus' => 'Istirahat', 'isRestDay' => true],
                'Rabu' => ['focus' => 'Lower Body', 'muscles' => ['quadriceps', 'hamstrings', 'glutes'], 'duration' => 45],
                'Kamis' => ['focus' => 'Istirahat', 'isRestDay' => true],
                'Jumat' => ['focus' => 'Back & Biceps', 'muscles' => ['lats', 'middle back', 'biceps'], 'duration' => 45],
                'Sabtu' => ['focus' => 'Full Body', 'muscles' => ['chest', 'quadriceps', 'abdominals'], 'duration' => 40],
                'Minggu' => ['focus' => 'Istirahat', 'isRestDay' => true],
            ];
        } elseif ($bmi < 25) {
            // Normal: Balanced routine
            $focuses = [
                'Senin' => ['focus' => 'Push Day', 'muscles' => ['chest', 'shoulders', 'triceps'], 'duration' => 50],
                'Selasa' => ['focus' => 'Pull Day', 'muscles' => ['lats', 'middle back', 'biceps'], 'duration' => 50],
                'Rabu' => ['focus' => 'Legs', 'muscles' => ['quadriceps', 'hamstrings', 'calves'], 'duration' => 50],
                'Kamis' => ['focus' => 'Istirahat Aktif', 'isRestDay' => true],
                'Jumat' => ['focus' => 'Upper Body', 'muscles' => ['chest', 'shoulders', 'lats'], 'duration' => 45],
                'Sabtu' => ['focus' => 'Lower Body & Core', 'muscles' => ['quadriceps', 'glutes', 'abdominals'], 'duration' => 45],
                'Minggu' => ['focus' => 'Istirahat', 'isRestDay' => true],
            ];
        } elseif ($bmi < 30) {
            // Overweight: Focus on fat burning
            $focuses = [
                'Senin' => ['focus' => 'Cardio & Legs', 'muscles' => ['quadriceps', 'glutes'], 'duration' => 40],
                'Selasa' => ['focus' => 'Upper Body Light', 'muscles' => ['chest', 'shoulders'], 'duration' => 35],
                'Rabu' => ['focus' => 'Istirahat Aktif', 'isRestDay' => true],
                'Kamis' => ['focus' => 'Full Body Circuit', 'muscles' => ['quadriceps', 'chest', 'abdominals'], 'duration' => 40],
                'Jumat' => ['focus' => 'Cardio & Core', 'muscles' => ['abdominals', 'lower back'], 'duration' => 35],
                'Sabtu' => ['focus' => 'Light Activity', 'muscles' => ['quadriceps'], 'duration' => 30],
                'Minggu' => ['focus' => 'Istirahat', 'isRestDay' => true],
            ];
        } else {
            // Obese: Low impact, gentle start
            $focuses = [
                'Senin' => ['focus' => 'Low Impact Cardio', 'muscles' => ['quadriceps'], 'duration' => 25],
                'Selasa' => ['focus' => 'Istirahat', 'isRestDay' => true],
                'Rabu' => ['focus' => 'Gentle Strength', 'muscles' => ['chest', 'middle back'], 'duration' => 25],
                'Kamis' => ['focus' => 'Istirahat', 'isRestDay' => true],
                'Jumat' => ['focus' => 'Light Movement', 'muscles' => ['quadriceps', 'abdominals'], 'duration' => 25],
                'Sabtu' => ['focus' => 'Istirahat Aktif', 'isRestDay' => true],
                'Minggu' => ['focus' => 'Istirahat', 'isRestDay' => true],
            ];
        }

        foreach ($days as $day) {
            $dayData = $focuses[$day];
            
            if (isset($dayData['isRestDay']) && $dayData['isRestDay']) {
                $schedule[$day] = [
                    'focus' => $dayData['focus'],
                    'isRestDay' => true,
                    'exercises' => [],
                    'duration' => 0
                ];
            } else {
                $exercises = [];
                foreach ($dayData['muscles'] as $muscle) {
                    $exercise = Workout::byMuscle($muscle)->byLevel($level)->inRandomOrder()->first();
                    if (!$exercise) {
                        $exercise = Workout::byMuscle($muscle)->inRandomOrder()->first();
                    }
                    
                    if ($exercise) {
                        $exercises[] = [
                            'name' => $exercise->getName(),
                            'muscle' => $muscle,
                            'sets' => $this->getSetsForBMI($bmi),
                            'reps' => $this->getRepsForBMI($bmi),
                        ];
                    }
                }

                $schedule[$day] = [
                    'focus' => $dayData['focus'],
                    'isRestDay' => false,
                    'exercises' => $exercises,
                    'duration' => $dayData['duration']
                ];
            }
        }

        return $schedule;
    }

    /**
     * Get sets based on BMI
     */
    private function getSetsForBMI($bmi)
    {
        if ($bmi < 18.5) return 4;
        if ($bmi < 25) return 3;
        if ($bmi < 30) return 3;
        return 2;
    }

    /**
     * Get reps based on BMI
     */
    private function getRepsForBMI($bmi)
    {
        if ($bmi < 18.5) return '8-10';
        if ($bmi < 25) return '10-12';
        if ($bmi < 30) return '12-15';
        return '10-12';
    }

    /**
     * Get tips based on BMI
     */
    private function getTipsForBMI($bmi)
    {
        if ($bmi < 18.5) {
            return [
                'Fokus pada latihan kekuatan untuk membangun massa otot',
                'Makan lebih banyak protein (1.6-2.2g per kg berat badan)',
                'Istirahat cukup antara sesi latihan (48 jam per grup otot)',
                'Hindari kardio berlebihan yang membakar terlalu banyak kalori',
                'Konsumsi kalori surplus 300-500 kalori per hari',
            ];
        } elseif ($bmi < 25) {
            return [
                'Pertahankan rutinitas latihan yang seimbang',
                'Kombinasikan latihan kekuatan dan kardio',
                'Fokus pada progressive overload untuk meningkatkan kekuatan',
                'Jaga pola makan seimbang dengan protein yang cukup',
                'Lakukan variasi latihan untuk menghindari plateau',
            ];
        } elseif ($bmi < 30) {
            return [
                'Kombinasikan kardio dan latihan kekuatan',
                'Mulai dengan intensitas rendah dan tingkatkan bertahap',
                'Fokus pada defisit kalori 300-500 kalori per hari',
                'Pilih latihan low-impact untuk melindungi sendi',
                'Konsistensi lebih penting dari intensitas tinggi',
            ];
        } else {
            return [
                'Mulai dengan aktivitas ringan seperti jalan kaki',
                'Konsultasi dengan dokter sebelum memulai program latihan',
                'Fokus pada latihan low-impact untuk melindungi sendi',
                'Tingkatkan durasi dan intensitas secara bertahap',
                'Utamakan konsistensi daripada intensitas',
                'Pertimbangkan latihan di air untuk mengurangi tekanan pada sendi',
            ];
        }
    }

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
        $bmi = $user->hitungIMT() ?? 22;
        $estimasiKaloriHarian = $user->hitungKaloriHarian() ?? 2000;
        $kaloriDefisit = $estimasiKaloriHarian - $totalKaloriHariIni;
        
        // Generate training plan using the schedule generator
        $recommendedLevel = $this->getRecommendedLevel($bmi);
        $schedule = $this->generateWeeklySchedule($bmi, $recommendedLevel);
        
        // Convert schedule to training plan format
        $workouts = [];
        $dayCalories = ['Senin' => 250, 'Selasa' => 200, 'Rabu' => 280, 'Kamis' => 150, 'Jumat' => 250, 'Sabtu' => 200, 'Minggu' => 100];
        
        foreach ($schedule as $day => $daySchedule) {
            if (!$daySchedule['isRestDay']) {
                $exercises = [];
                foreach ($daySchedule['exercises'] as $ex) {
                    $exercises[] = [
                        'nama' => $ex['name'],
                        'sets' => $ex['sets'],
                        'reps' => $ex['reps'],
                    ];
                }
                $workouts[] = [
                    'hari' => $day,
                    'fokus' => $daySchedule['focus'],
                    'durasi' => $daySchedule['duration'] . ' menit',
                    'kalori_terbakar' => $dayCalories[$day] ?? 200,
                    'exercises' => $exercises,
                ];
            }
        }

        $trainingPlan = [
            'user_name' => $user->nama,
            'bmi' => round($bmi, 2),
            'kategori_bmi' => $this->kategoriBMI($bmi),
            'berat_badan' => $user->berat,
            'tinggi_badan' => $user->tinggi,
            'total_kalori_harian' => $totalKaloriHariIni,
            'estimasi_kalori_harian' => $estimasiKaloriHarian,
            'kalori_defisit' => $kaloriDefisit,
            'workouts' => $workouts,
            'target' => $this->getTargetForBMI($bmi),
        ];
        
        return view('training.plan', compact('trainingPlan', 'bmi', 'totalKaloriHariIni', 'estimasiKaloriHarian', 'kaloriDefisit'));
    }

    /**
     * Get target based on BMI
     */
    private function getTargetForBMI($bmi)
    {
        if ($bmi < 18.5) return 'Menambah Berat Badan & Massa Otot';
        if ($bmi < 25) return 'Mempertahankan Berat & Meningkatkan Kebugaran';
        if ($bmi < 30) return 'Menurunkan Berat Badan';
        return 'Menurunkan Berat Badan Secara Signifikan';
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
}