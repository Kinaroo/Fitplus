@extends('layouts.app')

@section('content')
<h1>Create Challenge</h1>
<form method="POST" action="{{ route('admin.tantangan.store') }}">
    @csrf
    <div><label>Name</label><input name="nama" required></div>
    <div><label>Description</label><textarea name="deskripsi"></textarea></div>
    <div><label>Target Value</label><input type="number" step="0.01" name="target_value" required></div>
    <div><label>Unit</label><input name="unit"></div>
    <div><label>Start</label><input type="date" name="tanggal_mulai" required></div>
    <div><label>End</label><input type="date" name="tanggal_selesai" required></div>
    <div><label><input type="checkbox" name="assign_all"> Assign to all users</label></div>
    <button type="submit">Create</button>
</form>
@endsection