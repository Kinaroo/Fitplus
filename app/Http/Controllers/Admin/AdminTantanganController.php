<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tantangan;
use App\Models\TantanganUser;
use App\Models\User;

class AdminTantanganController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

public function index()
{
    // avoid model table mismatch: read directly from DB
    $tantangan = \DB::table('tantangan')->orderBy('tanggal_mulai','desc')->get();
    return view('admin.tantangan.index', compact('tantangan'));
}

    public function create()
    {
        return view('admin.tantangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'target_value' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $t = Tantangan::create(array_merge($request->only(['nama','deskripsi','target_value','unit','tanggal_mulai','tanggal_selesai']), [
            'created_by' => auth()->id()
        ]));

        if ($request->input('assign_all')) {
            $users = User::all();
            foreach ($users as $u) {
                TantanganUser::create([
                    'user_id' => $u->id,
                    'nama_tantangan' => $t->nama,
                    'status' => 'belum',
                    'tanggal_mulai' => $t->tanggal_mulai,
                    'tanggal_selesai' => $t->tanggal_selesai,
                    'tantangan_id' => $t->id,
                    'target_value' => $t->target_value,
                    'progress_value' => 0,
                    'unit' => $t->unit,
                ]);
            }
        }

        return redirect()->route('admin.tantangan.index')->with('success','Tantangan dibuat');
    }

    public function edit(Tantangan $tantangan)
    {
        return view('admin.tantangan.edit', compact('tantangan'));
    }

    public function update(Request $request, Tantangan $tantangan)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'target_value' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $tantangan->update($request->only(['nama','deskripsi','target_value','unit','tanggal_mulai','tanggal_selesai']));

        if ($request->input('propagate')) {
            TantanganUser::where('tantangan_id', $tantangan->id)
                ->update([
                    'target_value' => $tantangan->target_value,
                    'unit' => $tantangan->unit,
                    'tanggal_mulai' => $tantangan->tanggal_mulai,
                    'tanggal_selesai' => $tantangan->tanggal_selesai,
                ]);
        }

        return redirect()->route('admin.tantangan.index')->with('success','Tantangan diperbarui');
    }

    public function destroy(Tantangan $tantangan)
    {
        TantanganUser::where('tantangan_id', $tantangan->id)->delete();
        $tantangan->delete();

        return redirect()->route('admin.tantangan.index')->with('success','Tantangan dihapus');
    }
}