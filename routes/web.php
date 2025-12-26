<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaloriController;
use App\Http\Controllers\MakananController;
use App\Http\Controllers\TantanganController;
use App\Http\Controllers\TidurController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\AdminTantanganController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

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
        $user = auth()->user();

        // Get today's calorie total
        $totalKalori = \App\Models\MakananUser::where('user_id', $user->id)
            ->whereDate('tanggal', now()->toDateString())
            ->sum('total_kalori') ?? 0;

        $estimasiKalori = $user->hitungKaloriHarian() ?? 2000;

        \Illuminate\Support\Facades\Log::info('Dashboard calorie calc', [
            'user_id' => $user->id,
            'totalKalori' => $totalKalori,
            'estimasiKalori' => $estimasiKalori,
            'today' => now()->toDateString(),
        ]);

        return view('dashboard', compact('totalKalori', 'estimasiKalori'));
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

    /*
    |--------------------------------------------------------------------------
    | Laporan
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan/mingguan', [LaporanController::class, 'mingguan'])
        ->name('laporan.mingguan');

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/tantangan', [AdminTantanganController::class, 'index'])->name('tantangan.index');
        Route::get('/tantangan/create', [AdminTantanganController::class, 'create'])->name('tantangan.create');
        Route::post('/tantangan', [AdminTantanganController::class, 'store'])->name('tantangan.store');
        Route::get('/tantangan/{tantangan}/edit', [AdminTantanganController::class, 'edit'])->name('tantangan.edit');
        Route::put('/tantangan/{tantangan}', [AdminTantanganController::class, 'update'])->name('tantangan.update');
        Route::delete('/tantangan/{tantangan}', [AdminTantanganController::class, 'destroy'])->name('tantangan.destroy');

        // user management
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/tantangan/{tantangan}', [TantanganController::class, 'show'])->name('tantangan.show');
        Route::post('/tantangan/{tantangan}/increment', [TantanganController::class, 'incrementProgress'])->name('tantangan.increment');
    });

    Route::get('/admin-test', function () {
        return 'admin ok';
    })->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
});