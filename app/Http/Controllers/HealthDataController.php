<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AktivitasUser;
use App\Models\TidurUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HealthDataController extends Controller
{
    /**
     * Show form to add health data
     */
    public function showAddForm()
    {
        return view('data.add-health-data');
    }

    /**
     * Store health data
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'umur' => 'required|integer|min:1|max:120',
            'berat_badan' => 'required|numeric|min:20|max:300',
            'tinggi_badan' => 'required|numeric|min:100|max:250',
            'tidur' => 'required|numeric|min:0|max:24',
            'olahraga' => 'required|numeric|min:0|max:480',
        ]);

        $user = Auth::user();
        
        Log::info('=== STORE HEALTH DATA START ===', [
            'user_id' => $user->id,
            'email' => $user->email,
            'tanggal' => $validated['tanggal'],
        ]);

        try {
            // 0. Update user tinggi and berat if not set
            if (!$user->tinggi || !$user->berat) {
                $user->update([
                    'tinggi' => $validated['tinggi_badan'],
                    'berat' => $validated['berat_badan'],
                ]);
                Log::info('User profile updated with tinggi and berat', [
                    'user_id' => $user->id,
                    'tinggi' => $validated['tinggi_badan'],
                    'berat' => $validated['berat_badan'],
                ]);
            }
            
            // 1. Store health activity record
            Log::info('Creating AktivitasUser...', [
                'user_id' => $user->id,
                'jam_tidur' => $validated['tidur'],
            ]);
            
            $aktivitas = AktivitasUser::create([
                'user_id' => $user->id,
                'tanggal' => $validated['tanggal'],
                'umur' => $validated['umur'],
                'berat_badan' => $validated['berat_badan'],
                'tinggi_badan' => $validated['tinggi_badan'],
                'jam_tidur' => $validated['tidur'],
                'olahraga' => $validated['olahraga'],
            ]);

            Log::info('AktivitasUser created successfully', [
                'id' => $aktivitas->id,
                'user_id' => $user->id,
                'tanggal' => $validated['tanggal'],
                'jam_tidur' => $validated['tidur'],
            ]);

            // 2. Store sleep data to tidur_user table
            Log::info('Creating TidurUser...', [
                'user_id' => $user->id,
                'tanggal' => $validated['tanggal'],
                'durasi_jam' => (float) $validated['tidur'],
            ]);
            
            $tidur = TidurUser::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'tanggal' => $validated['tanggal'],
                ],
                [
                    'durasi_jam' => (float) $validated['tidur'],
                ]
            );

            Log::info('TidurUser created/updated successfully', [
                'id' => $tidur->id,
                'user_id' => $user->id,
                'tanggal' => $validated['tanggal'],
                'durasi_jam' => $tidur->durasi_jam,
                'wasRecentlyCreated' => $tidur->wasRecentlyCreated,
            ]);
            
            // 3. Update user's berat in akun_user for BMI calculations
            $user->berat = $validated['berat_badan'];
            $user->tinggi = $validated['tinggi_badan'];
            $user->save();
            
            Log::info('User weight/height updated', [
                'user_id' => $user->id,
                'berat' => $validated['berat_badan'],
                'tinggi' => $validated['tinggi_badan'],
            ]);
            
            Log::info('=== STORE HEALTH DATA COMPLETE ===');

            return redirect()->route('dashboard')
                ->with('success', 'Data kesehatan berhasil ditambahkan dan akan terupdate di Laporan Kesehatan!');
        } catch (\Exception $e) {
            Log::error('=== HEALTH DATA STORE ERROR ===', [
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'user_id' => $user->id,
                'tanggal' => $validated['tanggal'] ?? null,
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete health data
     */
    public function destroy($id)
    {
        $user = Auth::user();

        try {
            // Find and delete the aktivitas record
            $aktivitas = $user->aktivitas()->findOrFail($id);
            $aktivitas->delete();

            return redirect()->route('dashboard')
                ->with('success', 'Data kesehatan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
