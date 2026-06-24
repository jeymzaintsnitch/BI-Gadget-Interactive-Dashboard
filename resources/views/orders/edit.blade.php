@extends('layouts.app')
@section('title','Edit Order')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-pencil-square me-2" style="color:#6366f1"></i>Edit Order #{{ $order->orderNumber }}</h1>
</div>
<div class="form-card" style="max-width:680px">
    <form method="POST" action="{{ route('orders.update',$order->orderNumber) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Order Number</label>
                <input type="text" class="form-control" value="#{{ $order->orderNumber }}" disabled>
            </div>
            <div class="col-md-8">
                <label class="form-label">Customer *</label>
                <select name="customerNumber" class="form-select" required>
                    @foreach($customers as $c)
                    <option value="{{ $c->customerNumber }}"
                        {{ old('customerNumber',$order->customerNumber)==$c->customerNumber?'selected':'' }}>
                        {{ $c->customerName }} (#{{ $c->customerNumber }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Status *</label>
                <select name="status" class="form-select" required>
                    @foreach(['In Process','Shipped','On Hold','Cancelled','Resolved','Disputed'] as $s)
                    <option value="{{ $s }}" {{ old('status',$order->status)==$s?'selected':'' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Order Date *</label>
                <input type="date" name="orderDate" class="form-control" value="{{ old('orderDate',$order->orderDate) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Required Date *</label>
                <input type="date" name="requiredDate" class="form-control" value="{{ old('requiredDate',$order->requiredDate) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Shipped Date</label>
                <input type="date" name="shippedDate" class="form-control" value="{{ old('shippedDate',$order->shippedDate) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Comments</label>
                <textarea name="comments" class="form-control" rows="3">{{ old('comments',$order->comments) }}</textarea>
            </div>
        </div>
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update Order</button>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
