<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TidurUser;

class TidurController extends Controller
{
    public function simpan(Request $request)
    {
        $request->validate([
            'durasi_tidur' => 'required|numeric|min:1',
            'kualitas_tidur' => 'nullable|numeric',
            'fase_tidur' => 'nullable|string'
        ]);

        TidurUser::create([
            'user_id' => auth()->id(),
            'durasi_tidur' => $request->durasi_tidur,
            'kualitas_tidur' => $request->kualitas_tidur,
            'fase_tidur' => $request->fase_tidur,
            'tanggal' => now()
        ]);

        return back()->with('success', 'Data tidur tersimpan');
    }

    public function analisis()
    {
        $tidur = TidurUser::where('user_id', auth()->id())
            ->latest('tanggal')
            ->first();

        $hasil = $tidur
            ? $tidur->analisis()
            : "Belum ada data tidur";

        return view('tidur.analisis', compact('hasil'));
    }
}
