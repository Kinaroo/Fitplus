@extends('layouts.app')

@section('title', 'Kalori Harian - FitPlus')

@section('content')
    <h2>Total Kalori Hari Ini</h2>
    
    <div class="card">
        <div style="text-align: center;">
            <h1 style="color: #3498db; font-size: 3rem;">{{ $totalKalori ?? 0 }} kkal</h1>
            <p style="color: #666; margin-top: 0.5rem;">dari estimasi {{ $estimasi ?? 2000 }} kkal</p>
        </div>

        <div style="margin-top: 2rem; width: 100%; height: 20px; background: #e0e0e0; border-radius: 10px; overflow: hidden;">
            <div style="height: 100%; background: #3498db; width: {{ min(($totalKalori ?? 0) / max($estimasi ?? 2000, 1) * 100, 100) }}%;"></div>
        </div>
    </div>

    <!-- Macronutrients Section -->
    <div style="margin-top: 2rem;">
        <h3>Makronutrien Hari Ini</h3>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
            <!-- Protein -->
            <div class="card" style="background: #e8f8f5; border-left: 4px solid #16a085;">
                <p style="color: #117a65; margin: 0; font-size: 0.9rem; font-weight: 500;">Protein</p>
                <h2 style="color: #16a085; margin: 0.5rem 0;">{{ number_format($totalProtein ?? 0, 1) }} g</h2>
                <p style="color: #7f8c8d; font-size: 0.85rem; margin: 0;">{{ number_format(($totalProtein ?? 0) * 4, 0) }} kkal</p>
            </div>

            <!-- Karbohidrat -->
            <div class="card" style="background: #fef5e7; border-left: 4px solid #f39c12;">
                <p style="color: #d68910; margin: 0; font-size: 0.9rem; font-weight: 500;">Karbohidrat</p>
                <h2 style="color: #f39c12; margin: 0.5rem 0;">{{ number_format($totalKarbohidrat ?? 0, 1) }} g</h2>
                <p style="color: #7f8c8d; font-size: 0.85rem; margin: 0;">{{ number_format(($totalKarbohidrat ?? 0) * 4, 0) }} kkal</p>
            </div>

            <!-- Lemak -->
            <div class="card" style="background: #fde8e8; border-left: 4px solid #e74c3c;">
                <p style="color: #c0392b; margin: 0; font-size: 0.9rem; font-weight: 500;">Lemak</p>
                <h2 style="color: #e74c3c; margin: 0.5rem 0;">{{ number_format($totalLemak ?? 0, 1) }} g</h2>
                <p style="color: #7f8c8d; font-size: 0.85rem; margin: 0;">{{ number_format(($totalLemak ?? 0) * 9, 0) }} kkal</p>
            </div>
        </div>

        <!-- Macronutrient Breakdown Pie Chart Alternative (Simple) -->
        <div class="card" style="margin-top: 1.5rem;">
            <h4 style="margin-top: 0;">Distribusi Makronutrien</h4>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                @php
                    $totalMacroCalories = ($totalProtein * 4) + ($totalKarbohidrat * 4) + ($totalLemak * 9);
                    $proteinPercent = $totalMacroCalories > 0 ? (($totalProtein * 4) / $totalMacroCalories) * 100 : 0;
                    $karbohidratPercent = $totalMacroCalories > 0 ? (($totalKarbohidrat * 4) / $totalMacroCalories) * 100 : 0;
                    $lemakPercent = $totalMacroCalories > 0 ? (($totalLemak * 9) / $totalMacroCalories) * 100 : 0;
                @endphp
                
                <div style="flex: 1; min-width: 150px;">
                    <p style="margin: 0; color: #16a085; font-weight: 500;">Protein: {{ number_format($proteinPercent, 1) }}%</p>
                    <div style="height: 10px; background: #e0e0e0; border-radius: 5px; margin-top: 0.5rem; overflow: hidden;">
                        <div style="height: 100%; background: #16a085; width: {{ $proteinPercent }}%;"></div>
                    </div>
                </div>

                <div style="flex: 1; min-width: 150px;">
                    <p style="margin: 0; color: #f39c12; font-weight: 500;">Karbohidrat: {{ number_format($karbohidratPercent, 1) }}%</p>
                    <div style="height: 10px; background: #e0e0e0; border-radius: 5px; margin-top: 0.5rem; overflow: hidden;">
                        <div style="height: 100%; background: #f39c12; width: {{ $karbohidratPercent }}%;"></div>
                    </div>
                </div>

                <div style="flex: 1; min-width: 150px;">
                    <p style="margin: 0; color: #e74c3c; font-weight: 500;">Lemak: {{ number_format($lemakPercent, 1) }}%</p>
                    <div style="height: 10px; background: #e0e0e0; border-radius: 5px; margin-top: 0.5rem; overflow: hidden;">
                        <div style="height: 100%; background: #e74c3c; width: {{ $lemakPercent }}%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 2rem;">
        <a href="{{ route('makanan.form') }}" class="btn btn-primary">Tambah Makanan</a>
        <a href="{{ route('dashboard') }}" class="btn" style="background: #95a5a6; color: white; margin-left: 0.5rem;">Kembali</a>
    </div>
@endsection