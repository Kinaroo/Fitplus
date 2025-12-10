<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TidurUser;

class TidurController extends Controller
{
    public function simpan(Request $request)
    {
        $request->validate([
            'durasi_tidur' => 'required|numeric|min:0.25',
            'kualitas_tidur' => 'nullable|numeric',
            'fase_tidur' => 'nullable|string'
        ]);

        // store into the model's durasi_jam field so analisis() uses it
        \App\Models\TidurUser::create([
            'user_id' => auth()->id(),
            'durasi_jam' => $request->durasi_tidur,
            'kualitas_tidur' => $request->kualitas_tidur ?? null,
            'fase_tidur' => $request->fase_tidur ?? null,
            'tanggal' => now()->toDateString()
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
