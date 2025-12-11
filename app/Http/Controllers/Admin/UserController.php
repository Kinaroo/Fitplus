<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

    public function index()
    {
        $users = User::orderBy('id','asc')->paginate(25);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email',
            'tinggi' => 'nullable|integer',
            'berat' => 'nullable|integer',
            'is_admin' => 'nullable|in:0,1'
        ]);

        $data = $request->only(['nama','email','tinggi','berat','is_admin']);
        if ($request->filled('password')) {
            $data['password_hash'] = Hash::make($request->input('password'));
        }
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success','User updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted');
    }
}