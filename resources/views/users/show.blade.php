@extends('layouts.app')
@section('title','User Detail')
@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-person-circle me-2" style="color:#6366f1"></i>{{ $user->name }}</h1>
        <p>{{ $user->email }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('users.edit',$user->id) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>
<div class="form-card" style="max-width:480px">
    <dl class="row" style="font-size:.9rem">
        <dt class="col-4 text-muted">ID</dt>      <dd class="col-8">{{ $user->id }}</dd>
        <dt class="col-4 text-muted">Name</dt>    <dd class="col-8">{{ $user->name }}</dd>
        <dt class="col-4 text-muted">Email</dt>   <dd class="col-8">{{ $user->email }}</dd>
        <dt class="col-4 text-muted">Role</dt>
        <dd class="col-8">
            @php $rc = match($user->role_name) { 'admin'=>'role-admin','manager'=>'role-manager','analyst'=>'role-analyst',default=>'role-staff' }; @endphp
            <span class="role-chip {{ $rc }}">{{ $user->role_name }}</span>
        </dd>
        <dt class="col-4 text-muted">Created</dt> <dd class="col-8">{{ $user->created_at }}</dd>
    </dl>
</div>
@endsection
