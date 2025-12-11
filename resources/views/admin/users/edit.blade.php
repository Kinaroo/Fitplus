@extends('layouts.app')

@section('content')
<h1>Edit User #{{ $user->id }}</h1>
<form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf @method('PUT')
    <div><label>Name</label><input name="nama" value="{{ $user->nama }}"></div>
    <div><label>Email</label><input name="email" value="{{ $user->email }}"></div>
    <div><label>Height</label><input name="tinggi" value="{{ $user->tinggi }}"></div>
    <div><label>Weight</label><input name="berat" value="{{ $user->berat }}"></div>
    <div><label>Admin</label>
        <select name="is_admin">
            <option value="0" {{ $user->is_admin ? '' : 'selected' }}>No</option>
            <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Yes</option>
        </select>
    </div>
    <div><label>New password (optional)</label><input type="password" name="password"></div>
    <button type="submit">Save</button>
</form>
@endsection