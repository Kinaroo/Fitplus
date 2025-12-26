<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaloriController;
use App\Http\Controllers\MakananController;
use App\Http\Controllers\TantanganController;
use App\Http\Controllers\TidurController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\HealthDataController;
use App\Http\Controllers\BMIController;

// Route Homepage
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('homepage_new'); // Serve the new homepage view
})->name('home');

// Test route - status page
Route::get('/laporan/test-status', function () {
    return view('laporan.test-status');
})->name('laporan.test-status');

// Test route - laporan debug
Route::get('/test-laporan', function () {
    return view('test-laporan');
})->name('test-laporan');

// Test route - login & laporan
Route::get('/test-login-laporan', function () {
    return view('test-login-laporan');
})->name('test-login-laporan');

// Test route - laporan access test
Route::get('/test-laporan-access', function () {
    return view('test-laporan-access');
})->name('test-laporan-access');

// Check login status
Route::get('/check-login', function () {
    return view('check-login');
})->name('check-login');

// Debug access route
Route::get('/laporan/debug', function () {
    return view('laporan.debug-access');
})->name('laporan.debug');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profil', [AuthController::class, 'showProfil'])->name('profil');
    Route::post('/profil/update', [AuthController::class, 'updateProfil'])->name('profil.update');
});

// Password reset (placeholder to avoid undefined route errors in views)
Route::get('/password/reset', [AuthController::class, 'showPasswordReset'])->name('password.request')->middleware('guest');
Route::post('/password/reset', [AuthController::class, 'sendPasswordReset'])->name('password.reset.send')->middleware('guest');
Route::get('/password/reset/form', [AuthController::class, 'showPasswordResetForm'])->name('password.reset.form')->middleware('guest');
Route::post('/password/reset/confirm', [AuthController::class, 'confirmPasswordReset'])->name('password.reset.confirm')->middleware('guest');

/*
|--------------------------------------------------------------------------
| Protected Routes (Login wajib)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Makanan & Kalori
    |--------------------------------------------------------------------------
    */
    Route::get('/kalori/estimasi', [KaloriController::class, 'estimasiKalori'])->name('kalori.estimasi');
    Route::get('/kalori/harian', [KaloriController::class, 'totalKaloriHarian'])->name('kalori.harian');
    Route::get('/kalori/bmi', [BMIController::class, 'index'])->name('kalori.bmi');
    Route::post('/kalori/bmi/hitung', [BMIController::class, 'hitung'])->name('kalori.bmi.hitung');
    Route::get('/kalori/bmi/reset', [BMIController::class, 'reset'])->name('kalori.bmi.reset');
    Route::post('/makanan/tambah', [MakananController::class, 'tambahMakanan'])->name('makanan.tambah');
    Route::get('/makanan/search', [MakananController::class, 'search'])->name('makanan.search');
    Route::get('/makanan/gizi', [MakananController::class, 'detailGizi'])->name('makanan.gizi');
    Route::get('/makanan/tambah-form', [MakananController::class, 'showForm'])->name('makanan.form');
    Route::get('/makanan/harian', [MakananController::class, 'makananHariIni'])->name('makanan.harian');
    Route::delete('/makanan/{id}', [MakananController::class, 'deleteMakanan'])->name('makanan.delete');

    /*
    |--------------------------------------------------------------------------
    | Tantangan
    |--------------------------------------------------------------------------
    */
    Route::post('/tantangan/buat', [TantanganController::class, 'buat'])->name('tantangan.buat');
    Route::get('/tantangan/progres', [TantanganController::class, 'progres'])->name('tantangan.progres');
    Route::post('/tantangan/{id}/progress', [TantanganController::class, 'tambahProgress'])->name('tantangan.progress.add');

    /*
    |--------------------------------------------------------------------------
    | Rekomendasi & Training
    |--------------------------------------------------------------------------
    */
    Route::get('/rekomendasi/workout', [RekomendasiController::class, 'rekomendasiWorkout'])->name('rekomendasi.workout');
    Route::get('/training/plan', [TrainingController::class, 'generateTrainingPlan'])->name('training.plan');
    Route::post('/training/accept', [TrainingController::class, 'acceptPlan'])->name('training.accept');

    /*
    |--------------------------------------------------------------------------
    | Tidur
    |--------------------------------------------------------------------------
    */
    Route::post('/tidur/simpan', [TidurController::class, 'simpan'])->name('tidur.simpan');
    Route::get('/tidur/analisis', [TidurController::class, 'analisis'])->name('tidur.analisis');

    /*
    |--------------------------------------------------------------------------
    | Health Data
    |--------------------------------------------------------------------------
    */
    Route::get('/data/tambah', [HealthDataController::class, 'showAddForm'])->name('health-data.form');
    Route::post('/data/tambah', [HealthDataController::class, 'store'])->name('health-data.store');
    Route::delete('/data/{id}', [HealthDataController::class, 'destroy'])->name('health-data.destroy');

    /*
    |--------------------------------------------------------------------------
    | Laporan
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan/mingguan', [LaporanController::class, 'mingguan'])
        ->name('laporan.mingguan');

    /*
    |--------------------------------------------------------------------------
    | Laporan Kesehatan
    |--------------------------------------------------------------------------
    */
    Route::get('/laporan', function () {
        return view('laporan-intro');
    })->name('laporan');
    
    Route::get('/laporan/help', function () {
        return view('laporan-help');
    })->name('laporan.help');
    
    Route::get('/laporan/kesehatan', [LaporanController::class, 'kesehatan'])->name('laporan.kesehatan')->middleware('laporan.auth');
    Route::get('/laporan/kesehatan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.kesehatan.pdf')->middleware('laporan.auth');
    Route::get('/laporan/simple-test', function () {
        $user = auth()->user();
        $stats = ['berat_hari' => '75 kg'];
        return view('laporan.simple-test', compact('user', 'stats'));
    })->name('laporan.simple-test');
});

