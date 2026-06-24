@extends('layouts.app')
@section('title','Role Detail')
@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-key me-2" style="color:#6366f1"></i>Role: {{ $role->name }}</h1>
        <p>{{ $role->description }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('roles.edit',$role->id) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>
<div class="form-card">
    <h6 class="fw-bold mb-3" style="font-size:.8rem;text-transform:uppercase;color:#94a3b8">Users with this role ({{ count($users) }})</h6>
    <div class="bi-table">
        <table class="table table-hover" style="font-size:.875rem">
            <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Created</th></tr></thead>
            <tbody>
            @forelse($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->created_at }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted">No users assigned to this role.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
