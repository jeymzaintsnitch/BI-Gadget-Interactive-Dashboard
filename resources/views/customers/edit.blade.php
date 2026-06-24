@extends('layouts.app')
@section('title','Edit Customer')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-pencil-square me-2" style="color:#6366f1"></i>Edit Customer</h1>
    <p>Update customer #{{ $customer->customerNumber }} — {{ $customer->customerName }}</p>
</div>
<div class="form-card" style="max-width:760px">
    <form method="POST" action="{{ route('customers.update', $customer->customerNumber) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Customer Number</label>
                <input type="text" class="form-control" value="{{ $customer->customerNumber }}" disabled>
            </div>
            <div class="col-md-8">
                <label class="form-label">Customer Name *</label>
                <input type="text" name="customerName" class="form-control" value="{{ old('customerName',$customer->customerName) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact First Name</label>
                <input type="text" name="contactFirstName" class="form-control" value="{{ old('contactFirstName',$customer->contactFirstName) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact Last Name</label>
                <input type="text" name="contactLastName" class="form-control" value="{{ old('contactLastName',$customer->contactLastName) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone',$customer->phone) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Address Line 1</label>
                <input type="text" name="addressLine1" class="form-control" value="{{ old('addressLine1',$customer->addressLine1) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Address Line 2</label>
                <input type="text" name="addressLine2" class="form-control" value="{{ old('addressLine2',$customer->addressLine2) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" value="{{ old('city',$customer->city) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">State</label>
                <input type="text" name="state" class="form-control" value="{{ old('state',$customer->state) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Postal Code</label>
                <input type="text" name="postalCode" class="form-control" value="{{ old('postalCode',$customer->postalCode) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Country</label>
                <input type="text" name="country" class="form-control" value="{{ old('country',$customer->country) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Sales Rep</label>
                <select name="salesRepEmployeeNumber" class="form-select">
                    <option value="">— None —</option>
                    @foreach($employees as $e)
                    <option value="{{ $e->employeeNumber }}"
                        {{ old('salesRepEmployeeNumber',$customer->salesRepEmployeeNumber)==$e->employeeNumber?'selected':'' }}>
                        {{ $e->firstName }} {{ $e->lastName }} ({{ $e->jobTitle }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Credit Limit ($)</label>
                <input type="number" step="0.01" name="creditLimit" class="form-control" value="{{ old('creditLimit',$customer->creditLimit) }}">
            </div>
        </div>
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update Customer</button>
            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
