@extends('layouts.app')
@section('title','Add Employee')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-person-plus me-2" style="color:#6366f1"></i>Add New Employee</h1>
</div>
<div class="form-card" style="max-width:680px">
    <form method="POST" action="{{ route('employees.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Employee Number *</label>
                <input type="number" name="employeeNumber" class="form-control" value="{{ old('employeeNumber') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">First Name *</label>
                <input type="text" name="firstName" class="form-control" value="{{ old('firstName') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Last Name *</label>
                <input type="text" name="lastName" class="form-control" value="{{ old('lastName') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Extension</label>
                <input type="text" name="extension" class="form-control" value="{{ old('extension') }}" placeholder="x1234">
            </div>
            <div class="col-md-3">
                <label class="form-label">Job Title</label>
                <input type="text" name="jobTitle" class="form-control" value="{{ old('jobTitle') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Office *</label>
                <select name="officeCode" class="form-select" required>
                    <option value="">— Select Office —</option>
                    @foreach($offices as $o)
                    <option value="{{ $o->officeCode }}" {{ old('officeCode')==$o->officeCode?'selected':'' }}>
                        {{ $o->city }}, {{ $o->country }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Reports To</label>
                <select name="reportsTo" class="form-select">
                    <option value="">— None —</option>
                    @foreach($managers as $m)
                    <option value="{{ $m->employeeNumber }}" {{ old('reportsTo')==$m->employeeNumber?'selected':'' }}>
                        {{ $m->firstName }} {{ $m->lastName }} ({{ $m->jobTitle }})
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Employee</button>
            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
