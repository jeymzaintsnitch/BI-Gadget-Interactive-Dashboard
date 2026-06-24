@extends('layouts.app')
@section('title','Add Customer')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-person-plus me-2" style="color:#6366f1"></i>Add New Customer</h1>
    <p>Fill in the customer details below.</p>
</div>
<div class="form-card" style="max-width:760px">
    <form method="POST" action="{{ route('customers.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Customer Number *</label>
                <input type="number" name="customerNumber" class="form-control" value="{{ old('customerNumber') }}" required>
            </div>
            <div class="col-md-8">
                <label class="form-label">Customer Name *</label>
                <input type="text" name="customerName" class="form-control" value="{{ old('customerName') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact First Name</label>
                <input type="text" name="contactFirstName" class="form-control" value="{{ old('contactFirstName') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact Last Name</label>
                <input type="text" name="contactLastName" class="form-control" value="{{ old('contactLastName') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Address Line 1</label>
                <input type="text" name="addressLine1" class="form-control" value="{{ old('addressLine1') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Address Line 2</label>
                <input type="text" name="addressLine2" class="form-control" value="{{ old('addressLine2') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" value="{{ old('city') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">State</label>
                <input type="text" name="state" class="form-control" value="{{ old('state') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Postal Code</label>
                <input type="text" name="postalCode" class="form-control" value="{{ old('postalCode') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Country</label>
                <input type="text" name="country" class="form-control" value="{{ old('country') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Sales Rep</label>
                <select name="salesRepEmployeeNumber" class="form-select">
                    <option value="">— None —</option>
                    @foreach($employees as $e)
                    <option value="{{ $e->employeeNumber }}" {{ old('salesRepEmployeeNumber')==$e->employeeNumber?'selected':'' }}>
                        {{ $e->firstName }} {{ $e->lastName }} ({{ $e->jobTitle }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Credit Limit ($)</label>
                <input type="number" step="0.01" name="creditLimit" class="form-control" value="{{ old('creditLimit',0) }}">
            </div>
        </div>
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Customer</button>
            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
