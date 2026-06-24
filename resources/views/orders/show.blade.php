@extends('layouts.app')
@section('title','Order Detail')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-receipt me-2" style="color:#6366f1"></i>Order #{{ $order->orderNumber }}</h1>
        <p>{{ $order->customerName }} &mdash; {{ $order->city }}, {{ $order->country }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('orders.edit',$order->orderNumber) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-sm-3">
        <div class="kpi-card" style="--accent:#6366f1;--accent-light:#eef2ff">
            <div class="kpi-value">${{ number_format($orderTotal,2) }}</div>
            <div class="kpi-label">Order Total</div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="kpi-card" style="--accent:{{ $isLate?'#ef4444':'#10b981' }};--accent-light:{{ $isLate?'#fee2e2':'#d1fae5' }}">
            <div class="kpi-value">{{ $isLate ? '⚠ Late' : '✓ On Time' }}</div>
            <div class="kpi-label">Shipping Status</div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="kpi-card" style="--accent:#f59e0b;--accent-light:#fef3c7">
            <div class="kpi-value">{{ $details->count() }}</div>
            <div class="kpi-label">Line Items</div>
        </div>
    </div>
    <div class="col-sm-3">
        @php
            $sc = match($order->status) {
                'Shipped'=>'status-shipped','Cancelled'=>'status-cancelled',
                'In Process'=>'status-inprocess','On Hold'=>'status-onhold',
                default=>'status-resolved'
            };
        @endphp
        <div class="kpi-card" style="--accent:#0ea5e9;--accent-light:#e0f2fe">
            <div class="kpi-value"><span class="status-badge {{ $sc }}" style="font-size:1rem">{{ $order->status }}</span></div>
            <div class="kpi-label">Current Status</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-3">
        <div class="form-card">
            <h6 class="fw-bold mb-3" style="font-size:.8rem;text-transform:uppercase;color:#94a3b8">Order Info</h6>
            <dl class="row" style="font-size:.875rem">
                <dt class="col-6 text-muted">Order Date</dt>   <dd class="col-6">{{ $order->orderDate }}</dd>
                <dt class="col-6 text-muted">Required</dt>     <dd class="col-6">{{ $order->requiredDate }}</dd>
                <dt class="col-6 text-muted">Shipped</dt>      <dd class="col-6">{{ $order->shippedDate ?? '—' }}</dd>
                <dt class="col-6 text-muted">Customer</dt>     <dd class="col-6">{{ $order->customerName }}</dd>
            </dl>
            @if($order->comments)
            <hr>
            <p style="font-size:.8rem;color:#64748b">{{ $order->comments }}</p>
            @endif
        </div>
    </div>
    <div class="col-xl-9">
        <div class="form-card">
            <h6 class="fw-bold mb-3" style="font-size:.8rem;text-transform:uppercase;color:#94a3b8">Line Items</h6>
            <div class="bi-table">
                <table class="table table-hover">
                    <thead><tr>
                        <th>#</th><th>Product</th><th>Code</th>
                        <th>Qty</th><th>Unit Price</th><th>Line Total</th>
                    </tr></thead>
                    <tbody>
                    @foreach($details as $d)
                    <tr>
                        <td>{{ $d->orderLineNumber }}</td>
                        <td>{{ $d->productName }}</td>
                        <td><code>{{ $d->productCode }}</code></td>
                        <td>{{ $d->quantityOrdered }}</td>
                        <td>${{ number_format($d->priceEach,2) }}</td>
                        <td><strong>${{ number_format($d->line_total,2) }}</strong></td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background:#f8fafc">
                            <td colspan="5" class="text-end fw-bold">Order Total</td>
                            <td><strong style="color:#6366f1;font-size:1rem">${{ number_format($orderTotal,2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
