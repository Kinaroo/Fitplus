<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TantanganUser;

class TantanganController extends Controller
{
    public function show(TantanganUser $tantangan)
    {
        // ensure this belongs to auth user or is public
        if ($tantangan->user_id !== auth()->id()) {
            abort(403);
        }
        return view('tantangan.progres', compact('tantangan'));
    }

    // increment progress by numeric amount (POST)
    public function incrementProgress(Request $request, TantanganUser $tantangan)
    {
        if ($tantangan->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.001'
        ]);

        $amount = (float) $request->input('amount');

        $tantangan->addProgress($amount);

        return back()->with('success','Progress updated.');
    }

    // show current user's latest challenge progress (for route /tantangan/progres)
    public function progres()
    {
        $user = auth()->user();

        $tantangan = TantanganUser::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->first();

        if (!$tantangan) {
            return view('tantangan.progres')->with('pesan', 'Belum ada tantangan aktif');
        }

        return view('tantangan.progres', compact('tantangan'));
    }
}