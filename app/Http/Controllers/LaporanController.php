<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MakananUser;
use App\Models\TidurUser;
use App\Models\AktivitasUser;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function mingguan()
    {
        $userId = auth()->id();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        // Get daily data for the week
        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $days[] = [
                'date' => $date,
                'day_name' => $date->translatedFormat('l'),
                'formatted_date' => $date->format('d M'),
            ];
        }

        // --- DIET DATA ---
        $makananData = MakananUser::where('user_id', $userId)
            ->whereBetween('tanggal', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->get();

        $dietPerDay = [];
        $totalKaloriWeek = 0;
        $totalProteinWeek = 0;
        $totalKarbohidratWeek = 0;
        $totalLemakWeek = 0;

        foreach ($days as $day) {
            $dateString = $day['date']->toDateString();
            $dayMakanan = $makananData->where('tanggal', $dateString);
            
            $kalori = $dayMakanan->sum('total_kalori');
            $protein = $dayMakanan->sum('protein');
            $karbohidrat = $dayMakanan->sum('karbohidrat');
            $lemak = $dayMakanan->sum('lemak');

            $dietPerDay[] = [
                'day' => $day['day_name'],
                'date' => $day['formatted_date'],
                'kalori' => $kalori,
                'protein' => $protein,
                'karbohidrat' => $karbohidrat,
                'lemak' => $lemak,
            ];

            $totalKaloriWeek += $kalori;
            $totalProteinWeek += $protein;
            $totalKarbohidratWeek += $karbohidrat;
            $totalLemakWeek += $lemak;
        }

        $avgKalori = round($totalKaloriWeek / 7, 1);
        $avgProtein = round($totalProteinWeek / 7, 1);
        $avgKarbohidrat = round($totalKarbohidratWeek / 7, 1);
        $avgLemak = round($totalLemakWeek / 7, 1);

        // --- SLEEP DATA ---
        $tidurData = TidurUser::where('user_id', $userId)
            ->whereBetween('tanggal', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->get();

        $sleepPerDay = [];
        $totalDurasiWeek = 0;
        $daysWithSleep = 0;

        foreach ($days as $day) {
            $dateString = $day['date']->toDateString();
            $dayTidur = $tidurData->where('tanggal', $dateString)->first();
            
            $durasi = $dayTidur ? $dayTidur->durasi_jam : 0;
            $analisis = $dayTidur ? $dayTidur->analisis() : '-';

            $sleepPerDay[] = [
                'day' => $day['day_name'],
                'date' => $day['formatted_date'],
                'durasi' => $durasi,
                'analisis' => $analisis,
            ];

            if ($durasi > 0) {
                $totalDurasiWeek += $durasi;
                $daysWithSleep++;
            }
        }

        $avgSleep = $daysWithSleep > 0 ? round($totalDurasiWeek / $daysWithSleep, 1) : 0;
        $sleepQuality = $this->getSleepQualityLabel($avgSleep);

        // --- WORKOUT DATA ---
        $workoutData = AktivitasUser::where('user_id', $userId)
            ->whereBetween('tanggal', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->get();

        $workoutPerDay = [];
        $totalDurasiWorkout = 0;
        $totalKaloriTerbakar = 0;
        $daysWithWorkout = 0;

        foreach ($days as $day) {
            $dateString = $day['date']->toDateString();
            $dayWorkouts = $workoutData->where('tanggal', $dateString);
            
            $durasi = $dayWorkouts->sum('durasi_menit');
            $kaloriTerbakar = $dayWorkouts->sum('kalori_terbakar');
            $aktivitas = $dayWorkouts->pluck('nama_aktivitas')->toArray();

            $workoutPerDay[] = [
                'day' => $day['day_name'],
                'date' => $day['formatted_date'],
                'durasi' => $durasi,
                'kalori_terbakar' => $kaloriTerbakar,
                'aktivitas' => $aktivitas,
            ];

            if ($durasi > 0) {
                $totalDurasiWorkout += $durasi;
                $totalKaloriTerbakar += $kaloriTerbakar;
                $daysWithWorkout++;
            }
        }

        $avgWorkoutDuration = $daysWithWorkout > 0 ? round($totalDurasiWorkout / $daysWithWorkout, 1) : 0;

        // Calculate weekly summary scores
        $user = auth()->user();
        $estimasiKalori = $user->hitungKaloriHarian() ?? 2000;
        $targetKaloriWeek = $estimasiKalori * 7;
        $dietScore = $targetKaloriWeek > 0 ? min(100, round(($totalKaloriWeek / $targetKaloriWeek) * 100)) : 0;
        $sleepScore = min(100, round(($avgSleep / 8) * 100));
        $workoutScore = min(100, round(($daysWithWorkout / 5) * 100)); // Target: 5 days/week
        $overallScore = round(($dietScore + $sleepScore + $workoutScore) / 3);

        return view('laporan.mingguan', compact(
            'dietPerDay',
            'sleepPerDay',
            'workoutPerDay',
            'totalKaloriWeek',
            'avgKalori',
            'avgProtein',
            'avgKarbohidrat',
            'avgLemak',
            'totalDurasiWeek',
            'avgSleep',
            'sleepQuality',
            'totalDurasiWorkout',
            'totalKaloriTerbakar',
            'daysWithWorkout',
            'avgWorkoutDuration',
            'dietScore',
            'sleepScore',
            'workoutScore',
            'overallScore',
            'startOfWeek',
            'endOfWeek',
            'estimasiKalori'
        ));
    }

    private function getSleepQualityLabel($avgHours)
    {
        if ($avgHours < 6) {
            return 'Kurang';
        } elseif ($avgHours <= 8) {
            return 'Baik';
        } else {
            return 'Berlebihan';
        }
    }
}
