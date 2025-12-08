<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaloriController;
use App\Http\Controllers\MakananController;
use App\Http\Controllers\TantanganController;
use App\Http\Controllers\TidurController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\TrainingController;

Route::get('/', function () {
    return view('welcome'); // or redirect()->route('login.form');
})->name('home');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profil', [AuthController::class, 'showProfil'])->name('profil');
Route::post('/profil/update', [AuthController::class, 'updateProfil'])->name('profil.update');


/*
|--------------------------------------------------------------------------
| Protected Routes (Login wajib)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard utama
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Makanan & Kalori
    |--------------------------------------------------------------------------
    */

    Route::get('/kalori/estimasi', [KaloriController::class, 'estimasiKalori'])
        ->name('kalori.estimasi');

    Route::get('/kalori/harian', [KaloriController::class, 'totalKaloriHarian'])
        ->name('kalori.harian');

    Route::post('/makanan/tambah', [MakananController::class, 'tambahMakanan'])
        ->name('makanan.tambah');

    Route::get('/makanan/search', [MakananController::class, 'search'])
        ->name('makanan.search');

    Route::get('/makanan/gizi', [MakananController::class, 'detailGizi'])
        ->name('makanan.gizi');

    Route::get('/makanan/tambah-form', [MakananController::class, 'showForm'])
        ->name('makanan.form');

    Route::get('/makanan/harian', [MakananController::class, 'makananHariIni'])
        ->name('makanan.harian');

    /*
    |--------------------------------------------------------------------------
    | Tantangan
    |--------------------------------------------------------------------------
    */

    Route::post('/tantangan/buat', [TantanganController::class, 'buat'])
        ->name('tantangan.buat');

    Route::get('/tantangan/progres', [TantanganController::class, 'progres'])
        ->name('tantangan.progres');

    Route::get('/rekomendasi/workout', [RekomendasiController::class, 'rekomendasiWorkout'])
        ->name('rekomendasi.workout');

    Route::get('/training/plan', [TrainingController::class, 'generateTrainingPlan'])
        ->name('training.plan');

    Route::post('/training/accept', [TrainingController::class, 'acceptPlan'])->name('training.accept');

    Route::get('/tantangan/progres', [TantanganController::class, 'progres'])->name('tantangan.progres');

    Route::post('/tantangan/{id}/progress', [TantanganController::class, 'tambahProgress'])->name('tantangan.progress.add');
    /*
    |--------------------------------------------------------------------------
    | Tidur
    |--------------------------------------------------------------------------
    */

    Route::post('/tidur/simpan', [TidurController::class, 'simpan'])
        ->name('tidur.simpan');

    Route::get('/tidur/analisis', [TidurController::class, 'analisis'])
        ->name('tidur.analisis');

});