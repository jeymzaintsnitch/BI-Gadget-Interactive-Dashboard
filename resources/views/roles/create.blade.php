@extends('layouts.app')
@section('title','Add Role')
@section('content')
<div class="page-header"><h1><i class="bi bi-plus-square me-2" style="color:#6366f1"></i>Add New Role</h1></div>
<div class="form-card" style="max-width:520px">
    <form method="POST" action="{{ route('roles.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Role Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="e.g. viewer">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Role</button>
            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
