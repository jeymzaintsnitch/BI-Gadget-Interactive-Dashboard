@extends('layouts.app')
@section('title','Add User')
@section('content')
<div class="page-header"><h1><i class="bi bi-person-plus me-2" style="color:#6366f1"></i>Add New User</h1></div>
<div class="form-card" style="max-width:560px">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Full Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="col-12">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Password *</label>
                <input type="password" name="password" class="form-control" required minlength="8">
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirm Password *</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Role *</label>
                <select name="role_id" class="form-select" required>
                    @foreach($roles as $r)
                    <option value="{{ $r->id }}" {{ old('role_id')==$r->id?'selected':'' }}>
                        {{ ucfirst($r->name) }} — {{ $r->description }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Create User</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
