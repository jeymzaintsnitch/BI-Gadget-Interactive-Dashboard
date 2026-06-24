@extends('layouts.app')
@section('title','Add Office')
@section('content')
<div class="page-header"><h1><i class="bi bi-building-add me-2" style="color:#6366f1"></i>Add New Office</h1></div>
<div class="form-card" style="max-width:680px">
    <form method="POST" action="{{ route('offices.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Office Code *</label>
                <input type="text" name="officeCode" class="form-control" value="{{ old('officeCode') }}" required placeholder="8">
            </div>
            <div class="col-md-5">
                <label class="form-label">City *</label>
                <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Territory</label>
                <select name="territory" class="form-select">
                    <option value="">— Select Territory —</option>
                    @foreach(['NA','EMEA','APAC','Japan'] as $t)
                    <option value="{{ $t }}" {{ old('territory')==$t?'selected':'' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Country</label>
                <input type="text" name="country" class="form-control" value="{{ old('country') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">State</label>
                <input type="text" name="state" class="form-control" value="{{ old('state') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Postal Code</label>
                <input type="text" name="postalCode" class="form-control" value="{{ old('postalCode') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Address Line 1</label>
                <input type="text" name="addressLine1" class="form-control" value="{{ old('addressLine1') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Address Line 2</label>
                <input type="text" name="addressLine2" class="form-control" value="{{ old('addressLine2') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
        </div>
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Office</button>
            <a href="{{ route('offices.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
