@extends('layouts.app')
@section('title','Record Payment')
@section('content')
<div class="page-header"><h1><i class="bi bi-plus-square me-2" style="color:#6366f1"></i>Record New Payment</h1></div>
<div class="form-card" style="max-width:560px">
    <form method="POST" action="{{ route('payments.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Customer *</label>
                <select name="customerNumber" class="form-select" required>
                    <option value="">— Select Customer —</option>
                    @foreach($customers as $c)
                    <option value="{{ $c->customerNumber }}" {{ old('customerNumber')==$c->customerNumber?'selected':'' }}>
                        {{ $c->customerName }} (#{{ $c->customerNumber }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Check Number *</label>
                <input type="text" name="checkNumber" class="form-control" value="{{ old('checkNumber') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Payment Date *</label>
                <input type="date" name="paymentDate" class="form-control" value="{{ old('paymentDate',date('Y-m-d')) }}" required>
            </div>
            <div class="col-12">
                <label class="form-label">Amount *</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" required min="0.01">
                </div>
            </div>
        </div>
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Record Payment</button>
            <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
