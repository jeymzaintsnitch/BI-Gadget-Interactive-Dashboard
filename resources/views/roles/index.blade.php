@extends('layouts.app')
@section('title','Role Management')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-key me-2" style="color:#6366f1"></i>Role Management</h1>
        <p>Define and manage access control roles.</p>
    </div>
    <a href="{{ route('roles.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add Role</a>
</div>
<div class="bi-table">
    <table class="table table-hover">
        <thead><tr><th>ID</th><th>Role Name</th><th>Description</th><th>Users</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($roles as $r)
        <tr>
            <td>{{ $r->id }}</td>
            <td>
                @php $rc = match(strtolower($r->name)) { 'admin' => 'role-admin', default => 'role-staff' }; @endphp
                <span class="role-chip {{ $rc }}">{{ $r->name }}</span>
            </td>
            <td>{{ $r->description }}</td>
            <td><span class="badge" style="background:#eef2ff;color:#6366f1">{{ $r->user_count }} users</span></td>
            <td>
                <div class="d-flex gap-1">
                    <a href="{{ route('roles.show',$r->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('roles.edit',$r->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                    @if($r->user_count == 0)
                    <form method="POST" action="{{ route('roles.destroy',$r->id) }}" onsubmit="return confirm('Delete this role?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center text-muted py-4">No roles found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
