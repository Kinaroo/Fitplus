@extends('layouts.app')

@section('content')
<h1>Users</h1>
<table>
<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Admin</th><th>Actions</th></tr></thead>
<tbody>
@foreach($users as $u)
<tr>
<td>{{ $u->id }}</td>
<td>{{ $u->nama }}</td>
<td>{{ $u->email }}</td>
<td>{{ $u->is_admin ? 'Yes' : 'No' }}</td>
<td>
    <a href="{{ route('admin.users.edit', $u) }}">Edit</a>
    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" style="display:inline;">
        @csrf @method('DELETE')
        <button onclick="return confirm('Delete user?')">Delete</button>
    </form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $users->links() }}
@endsection