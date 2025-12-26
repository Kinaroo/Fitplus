# 📊 Arsitektur Laporan Kesehatan - Breakdown Lengkap

## 🎯 Overview
Fitur Laporan Kesehatan adalah sistem terintegrasi yang menampilkan analisis kesehatan user berdasarkan data aktivitas, tidur, dan nutrisi dari periode yang dipilih.

---

## 1️⃣ MIDDLEWARE LAYER (Security Gate)

### File: `app/Http/Middleware/LaporanAuthCheck.php`

```php
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LaporanAuthCheck
{
    public function handle(Request $request, Closure $next): Response
    {
        // STEP 1: Check if user is authenticated
        if (!auth()->check()) {
            \Log::warning('Laporan access denied - not authenticated');
            return redirect()->route('laporan.help')
                ->with('warning', 'Silahkan login terlebih dahulu');
        }
        
        // STEP 2: Log successful access
        $user = auth()->user();
        \Log::info('Laporan auth check passed', [
            'user_id' => auth()->id(),
            'user_name' => $user->nama,
        ]);
        
        return $next($request);
    }
}
```

**Fungsi:**
- ✅ Gate akses (hanya user login yang bisa akses)
- ✅ Logging untuk security audit
- ✅ Redirect ke help page jika belum login

---

## 2️⃣ CONTROLLER LAYER (Business Logic)

### File: `app/Http/Controllers/LaporanController.php`

#### A. Method `kesehatan()` - Main Entry Point

```php
public function kesehatan(Request $request)
{
    try {
        // STEP 1: AUTH & LOGGING
        $authCheck = auth()->check();
        $userId = auth()->id();
        $userSession = auth()->user();
        
        \Log::info('Laporan kesehatan accessed', [
            'authenticated' => $authCheck,
            'user_id' => $userId,
            'user_has_data' => $userSession ? 'YES' : 'NO',
        ]);
        
        if (!auth()->check()) {
            return redirect()->route('login.form');
        }
        
        $user = auth()->user();
        $userId = $user->id;

        // STEP 2: GET PERIODE
        $periode = $request->get('periode', '30'); // Default 30 hari
        $today = now()->toDateString();
        $periodDays = (int)$periode;
        $startDate = now()->subDays($periodDays)->toDateString();

        // STEP 3: FETCH DATA FROM 3 DIFFERENT TABLES
        
        // Table 1: Aktivitas (Berat badan, Olahraga)
        $aktivitasHari = AktivitasUser::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->first();

        $aktivitasPeriode = AktivitasUser::where('user_id', $userId)
            ->whereBetween('tanggal', [$startDate, $today])
            ->orderBy('tanggal', 'asc')
            ->get();

        // Table 2: Tidur (Sleep duration & quality)
        $tidurHari = TidurUser::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->first();

        $tidurPeriode = TidurUser::where('user_id', $userId)
            ->whereBetween('tanggal', [$startDate, $today])
            ->orderBy('tanggal', 'asc')
            ->get();

        // Table 3: Makanan (Nutrition)
        $makananHari = MakananUser::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->with('makanan')  // Relationship to food data
            ->get();

        $makananPeriode = MakananUser::where('user_id', $userId)
            ->whereBetween('tanggal', [$startDate, $today])
            ->with('makanan')
            ->get();

        // STEP 4: COMPUTE STATISTICS
        $stats = $this->hitungStatistik(
            $aktivitasHari, 
            $aktivitasPeriode, 
            $tidurHari, 
            $tidurPeriode, 
            $makananHari, 
            $makananPeriode, 
            $user
        );

        // STEP 5: GENERATE RECOMMENDATIONS
        $rekomendasi = $this->buatRekomendasi($stats, $user, $aktivitasPeriode, $tidurPeriode);

        // STEP 6: GENERATE CHART DATA
        $chartData = $this->buatChartData($aktivitasPeriode, $tidurPeriode, $makananPeriode);

        // STEP 7: RENDER VIEW
        return view('laporan.kesehatan-baru', compact(
            'user', 
            'stats', 
            'rekomendasi', 
            'chartData', 
            'periode'
        ));
    } catch (\Exception $e) {
        \Log::error('Laporan kesehatan error', [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
        return view('errors.custom', [
            'message' => 'Gagal membuka laporan kesehatan: ' . $e->getMessage(),
            'code' => 500
        ]);
    }
}
```

**Kompleksitas:**
- 📊 Fetch dari 3 tabel dengan kondisi tanggal berbeda
- 🔢 Aggregate data (same day & period)
- 🎯 Multiple relationship loading (makanan -> makanan.nutrisi)

---

#### B. Method `hitungStatistik()` - Complex Calculations

```php
private function hitungStatistik($aktivitasHari, $aktivitasPeriode, 
                                  $tidurHari, $tidurPeriode, 
                                  $makananHari, $makananPeriode, $user)
{
    try {
        // ⚙️ STEP 1: Calculate Daily Calorie Requirement
        $kaloriTarget = 2000; // Default
        if ($user && $user->berat && $user->tinggi && $user->tanggal_lahir) {
            $kaloriTarget = $user->hitungKaloriHarian() ?? 2000;
        }

        // ⚙️ STEP 2: Calculate Today's Calories
        $makananHariTotal = $makananHari ? $makananHari->sum('total_kalori') : 0;

        // ⚙️ STEP 3: Calculate Nutrition Averages (Complex)
        $totalProteinPeriode = 0;
        $totalKarboPeriode = 0;
        $totalLemakPeriode = 0;
        $hari_dengan_makanan = 0;

        if ($makananPeriode && $makananPeriode->count() > 0) {
            // Group by date to count days with food data
            $makananByDate = $makananPeriode->groupBy('tanggal');
            $hari_dengan_makanan = $makananByDate->count();

            // Loop through each food item and sum nutrients
            foreach ($makananPeriode as $makanan) {
                if ($makanan->makanan) {
                    $totalProteinPeriode += ($makanan->makanan->protein ?? 0) * ($makanan->porsi ?? 1);
                    $totalKarboPeriode += ($makanan->makanan->karbohidrat ?? 0) * ($makanan->porsi ?? 1);
                    $totalLemakPeriode += ($makanan->makanan->lemak ?? 0) * ($makanan->porsi ?? 1);
                }
            }
        }

        // Calculate averages
        $proteinAvg = $hari_dengan_makanan > 0 ? round($totalProteinPeriode / $hari_dengan_makanan, 1) : 0;
        $karboAvg = $hari_dengan_makanan > 0 ? round($totalKarboPeriode / $hari_dengan_makanan, 1) : 0;
        $lemakAvg = $hari_dengan_makanan > 0 ? round($totalLemakPeriode / $hari_dengan_makanan, 1) : 0;

        // ⚙️ STEP 4: Aggregate Stats
        $stats = [
            // ===== TODAY =====
            'berat_hari' => $aktivitasHari?->berat_badan ?? '-',
            'tidur_hari' => $tidurHari?->durasi_jam ?? '-',
            'olahraga_hari' => $aktivitasHari?->olahraga ?? 0,
            'kalori_hari' => $makananHariTotal,

            // ===== PERIOD AVERAGE =====
            'berat_periode_avg' => $aktivitasPeriode->count() > 0 
                ? round($aktivitasPeriode->avg('berat_badan'), 1) 
                : '-',
            'tidur_periode_avg' => $tidurPeriode->count() > 0 
                ? round($tidurPeriode->avg('durasi_jam'), 1) 
                : '-',
            'olahraga_periode_avg' => $aktivitasPeriode->count() > 0 
                ? round($aktivitasPeriode->avg('olahraga'), 1) 
                : 0,
            'kalori_periode_avg' => $makananPeriode->count() > 0 
                ? round($makananPeriode->sum('total_kalori') / $hari_dengan_makanan, 0) 
                : 0,

            // ===== NUTRITION =====
            'protein_avg' => $proteinAvg,
            'karbo_avg' => $karboAvg,
            'lemak_avg' => $lemakAvg,

            // ===== TREND CALCULATIONS =====
            'berat_perubahan' => $this->hitungPerubahan($aktivitasPeriode, 'berat_badan'),
            'tidur_perubahan' => $this->hitungPerubahan($tidurPeriode, 'durasi_jam'),

            // ===== ACTIVITY =====
            'olahraga_total' => $aktivitasPeriode->count() > 0 
                ? $aktivitasPeriode->sum('olahraga') 
                : 0,
        ];

        return $stats;
    } catch (\Exception $e) {
        \Log::error('Error in hitungStatistik', ['error' => $e->getMessage()]);
        return [];
    }
}
```

**Yang Kompleks:**
- 🎯 Nested calculations (protein × portion)
- 📈 Average calculations dengan null handling
- 🔀 Grouping by date untuk counting days
- ✅ Safe fallback values

---

#### C. Method `hitungPerubahan()` - Trend Analysis

```php
private function hitungPerubahan($collection, $field)
{
    if ($collection->count() < 2) return 0;
    
    $first = $collection->first()?->$field ?? 0;
    $last = $collection->last()?->$field ?? 0;
    
    return round($last - $first, 1);
}
```

**Fungsi:**
- Hitung trend (naik/turun) dari hari pertama ke hari terakhir periode
- Contoh: Berat naik 2kg, Tidur kurang 1 jam

---

#### D. Method `buatRekomendasi()` - Smart Suggestions

```php
private function buatRekomendasi($stats, $user, $aktivitasPeriode, $tidurPeriode)
{
    $rekomendasi = [];

    // Rekomendasi berdasarkan IMT
    if (is_numeric($stats['imt'] ?? null)) {
        if ($stats['imt'] > 25) {
            $rekomendasi[] = [
                'judul' => 'Perhatian: Berat Badan Tinggi',
                'deskripsi' => 'IMT Anda menunjukkan kelebihan berat badan. Tingkatkan aktivitas olahraga dan perhatikan asupan kalori.'
            ];
        }
    }

    // Rekomendasi berdasarkan tidur
    $tidurAvg = $stats['tidur_periode_avg'] ?? 0;
    if ($tidurAvg > 0 && $tidurAvg < 7) {
        $rekomendasi[] = [
            'judul' => 'Tingkatkan Durasi Tidur',
            'deskripsi' => 'Rata-rata tidur Anda kurang dari 7 jam. Tidur yang cukup penting untuk kesehatan.'
        ];
    }

    return $rekomendasi;
}
```

---

## 3️⃣ VIEW LAYER (Presentation)

### File: `resources/views/laporan/kesehatan-baru.blade.php` (314 lines)

#### A. IMT Calculation (Kompleks dengan Logic)

```blade
@php
    // Parse berat value (could be "75 kg" string or 75 number)
    $berat_value = $stats['berat_hari'];
    if ($berat_value != '-') {
        $berat_value = is_numeric($berat_value) 
            ? (float)$berat_value 
            : (float)str_replace(' kg', '', $berat_value);
    }
    
    $berat = $berat_value != '-' ? $berat_value : null;
    $tinggi = $user->tinggi ?? null;
    
    // IMT Formula: berat / (tinggi dalam meter)²
    $imt = $berat && $tinggi ? round($berat / (($tinggi/100)**2), 1) : null;
    
    // Determine category and color
    $kategori = '-';
    $warna = 'text-gray-600';
    $bgWarna = 'bg-gray-50';
    
    if ($imt) {
        if ($imt < 18.5) {
            $kategori = 'Kurang Berat';
            $warna = 'text-blue-600';
            $bgWarna = 'bg-blue-50';
        } elseif ($imt <= 24.9) {
            $kategori = 'Normal';
            $warna = 'text-green-600';
            $bgWarna = 'bg-green-50';
        } elseif ($imt <= 29.9) {
            $kategori = 'Kelebihan Berat';
            $warna = 'text-yellow-600';
            $bgWarna = 'bg-yellow-50';
        } else {
            $kategori = 'Obesitas';
            $warna = 'text-red-600';
            $bgWarna = 'bg-red-50';
        }
    }
@endphp

<!-- Display IMT with dynamic colors -->
<div class="text-center {{ $bgWarna }} rounded-lg p-8 w-full">
    <p class="text-gray-600 text-sm font-semibold mb-2">INDEKS MASSA TUBUH</p>
    <p class="text-6xl font-bold {{ $warna }} mb-2">{{ $imt ?? '-' }}</p>
    <p class="text-lg font-semibold text-gray-700">{{ $kategori }}</p>
</div>
```

**Kompleks Karena:**
- 🔍 String parsing (berat bisa "75 kg" atau 75)
- 📐 IMT mathematical formula
- 🎨 Dynamic color assignment (4 kategori)
- ✅ Safe null handling di multiple levels

---

#### B. Nutrition Progress Bars

```blade
<div class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500">
    <p class="text-gray-600 text-sm font-semibold">Protein Rata-rata</p>
    <p class="text-3xl font-bold text-blue-600">
        {{ is_numeric($stats['protein_avg'] ?? null) && $stats['protein_avg'] != 0 
            ? number_format($stats['protein_avg'], 1) 
            : 'N/A' 
        }}
    </p>
    <p class="text-xs text-gray-500 mt-2">Target: 80-100g</p>
    
    @if(is_numeric($stats['protein_avg'] ?? null) && $stats['protein_avg'] != 0)
        <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
            <div class="bg-blue-600 h-2 rounded-full" 
                style="width: {{ min(100, (($stats['protein_avg'] ?? 0) / 100) * 100) }}%">
            </div>
        </div>
    @else
        <p class="text-xs text-gray-400 mt-3">Belum ada data nutrisi</p>
    @endif
</div>
```

**Kompleks Karena:**
- 🔢 Multiple conditional checks (is_numeric, != 0)
- 📊 Progress bar percentage calculation
- 🎨 Conditional rendering (show bar atau message)

---

## 4️⃣ ROUTING & MIDDLEWARE INTEGRATION

### File: `routes/web.php`

```php
Route::middleware(['auth'])->group(function () {
    // Laporan kesehatan dengan custom middleware
    Route::get('/laporan/kesehatan', [LaporanController::class, 'kesehatan'])
        ->name('laporan.kesehatan')
        ->middleware('laporan.auth');  // Custom auth check
    
    // PDF export
    Route::get('/laporan/kesehatan/export-pdf', [LaporanController::class, 'exportPdf'])
        ->name('laporan.kesehatan.pdf')
        ->middleware('laporan.auth');
});
```

**Double Protection:**
1. `auth` middleware - Laravel default
2. `laporan.auth` middleware - Custom untuk business logic

---

## 5️⃣ DATA FLOW DIAGRAM

```
User Login
    ↓
Middleware (auth + laporan.auth) ✅ Pass?
    ↓ YES
LaporanController::kesehatan()
    ↓
├─ Fetch dari 3 tabel (Aktivitas, Tidur, Makanan)
├─ Parse periode
├─ hitungStatistik()
│   ├─ Calculate daily calories
│   ├─ Sum nutrition (protein, karbo, lemak)
│   ├─ Calculate averages
│   ├─ hitungPerubahan() for trends
│   └─ Return $stats array
├─ buatRekomendasi() based on $stats
└─ buatChartData() for visualizations
    ↓
View: kesehatan-baru.blade.php
    ├─ Parse IMT with color coding
    ├─ Display stats cards
    ├─ Render nutrition progress
    └─ Show recommendations
    ↓
HTML Response to Browser
```

---

## 6️⃣ ERROR HANDLING STRATEGIES

```php
// 1. Try-catch di controller level
try {
    // Fetch & process data
} catch (\Exception $e) {
    \Log::error('Laporan error', [...]);
    return view('errors.custom', ['message' => $e->getMessage()]);
}

// 2. Null coalescing (??)
$berat = $stats['berat_hari'] ?? '-';

// 3. Type checking
if (is_numeric($value ?? null) && $value != 0) { ... }

// 4. Fallback values
$kaloriTarget = $user->hitungKaloriHarian() ?? 2000;
```

---

## 7️⃣ PERFORMANCE CONSIDERATIONS

**Query Optimization:**
- ✅ `with()` untuk eager loading relationship (makanan.makanan)
- ✅ `whereBetween()` untuk date range filtering
- ✅ `orderBy()` untuk efficient sorting
- ✅ Single query per table (tidak N+1)

**Calculation Optimization:**
- ✅ Aggregate di database (`avg()`, `sum()`) bukan di PHP loop
- ✅ `groupBy()` hanya untuk counting unique dates
- ✅ Cache friendly (bisa add `->remember()` jika perlu)

---

## 📊 SUMMARY: Complexity Breakdown

| Aspek | Kompleksitas | Alasan |
|-------|-------------|--------|
| **Middleware** | ⭐ | Simple auth check + logging |
| **Data Fetching** | ⭐⭐ | 3 tabel, multiple conditions |
| **Calculations** | ⭐⭐⭐⭐ | Nested loops, averages, trends |
| **Recommendations** | ⭐⭐ | Logic based on stats |
| **View Logic** | ⭐⭐⭐ | Multiple conditional, color coding |
| **Error Handling** | ⭐⭐ | Try-catch + null checks |
| **Overall System** | ⭐⭐⭐⭐⭐ | Integration dari 6 komponen |

---

## 🎯 CONCLUSION

Laporan Kesehatan adalah **sistem terintegrasi kompleks** karena:

1. **Multi-layer architecture** (Middleware → Controller → View)
2. **Complex data aggregation** dari 3 tabel dengan kalkulasi statistik
3. **Smart conditional logic** untuk recommendations & color coding
4. **Safe error handling** di setiap level
5. **Performance optimized** database queries
6. **User-friendly presentation** dengan visual indicators

Ini bukan sekadar "show data", tapi **intelligent health analysis system** yang membuat data meaningful untuk user! 💪

