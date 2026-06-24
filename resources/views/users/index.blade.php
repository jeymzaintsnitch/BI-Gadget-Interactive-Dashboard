@extends('layouts.app')
@section('title','User Management')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-shield-person me-2" style="color:#6366f1"></i>User Management</h1>
        <p>Manage system access and user accounts. <span class="badge" style="background:#fee2e2;color:#dc2626">Admin Only</span></p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add User</a>
</div>
<div class="bi-table">
    <table class="table table-hover">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Created</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($users as $u)
        <tr>
            <td>{{ $u->id }}</td>
            <td><strong>{{ $u->name }}</strong></td>
            <td>{{ $u->email }}</td>
            <td>
                @php $rc = match($u->role_name) { 'admin'=>'role-admin','manager'=>'role-manager','analyst'=>'role-analyst',default=>'role-staff' }; @endphp
                <span class="role-chip {{ $rc }}">{{ $u->role_name }}</span>
            </td>
            <td>{{ $u->created_at }}</td>
            <td>
                <div class="d-flex gap-1">
                    <a href="{{ route('users.show',$u->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('users.edit',$u->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                    @if($u->id != session('user_id'))
                    <form method="POST" action="{{ route('users.destroy',$u->id) }}" onsubmit="return confirm('Delete this user?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">No users found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
