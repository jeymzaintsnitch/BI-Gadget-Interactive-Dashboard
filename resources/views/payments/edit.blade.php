@extends('layouts.app')
@section('title','Edit Payment')
@section('content')
<div class="page-header"><h1><i class="bi bi-pencil-square me-2" style="color:#6366f1"></i>Edit Payment</h1></div>
<div class="form-card" style="max-width:560px">
    <form method="POST" action="{{ route('payments.update', $payment->customerNumber.'_'.$payment->checkNumber) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Customer</label>
                <input type="text" class="form-control" value="{{ $payment->customerName }}" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">Check Number</label>
                <input type="text" class="form-control" value="{{ $payment->checkNumber }}" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">Payment Date *</label>
                <input type="date" name="paymentDate" class="form-control" value="{{ old('paymentDate',$payment->paymentDate) }}" required>
            </div>
            <div class="col-12">
                <label class="form-label">Amount *</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount',$payment->amount) }}" required>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
            <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
