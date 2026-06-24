@extends('layouts.app')
@section('title','Customer Detail')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-person-circle me-2" style="color:#6366f1"></i>{{ $customer->customerName }}</h1>
        <p>Customer #{{ $customer->customerNumber }} &mdash; {{ $customer->city }}, {{ $customer->country }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('customers.edit',$customer->customerNumber) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-4">
        <div class="form-card h-100">
            <h6 class="fw-700 mb-3" style="font-size:.8rem;text-transform:uppercase;color:#94a3b8;letter-spacing:.06em">
                Customer Info
            </h6>
            <dl class="row" style="font-size:.875rem">
                <dt class="col-5 text-muted">Contact</dt>
                <dd class="col-7">{{ $customer->contactFirstName }} {{ $customer->contactLastName }}</dd>
                <dt class="col-5 text-muted">Phone</dt>
                <dd class="col-7">{{ $customer->phone ?? '—' }}</dd>
                <dt class="col-5 text-muted">Address</dt>
                <dd class="col-7">{{ $customer->addressLine1 }}{{ $customer->addressLine2 ? ', '.$customer->addressLine2 : '' }}</dd>
                <dt class="col-5 text-muted">City</dt>
                <dd class="col-7">{{ $customer->city }}</dd>
                <dt class="col-5 text-muted">State</dt>
                <dd class="col-7">{{ $customer->state ?? '—' }}</dd>
                <dt class="col-5 text-muted">Country</dt>
                <dd class="col-7">{{ $customer->country }}</dd>
                <dt class="col-5 text-muted">Postal</dt>
                <dd class="col-7">{{ $customer->postalCode ?? '—' }}</dd>
                <dt class="col-5 text-muted">Sales Rep</dt>
                <dd class="col-7">{{ $customer->rep_name ?? '—' }}</dd>
                <dt class="col-5 text-muted">Credit Limit</dt>
                <dd class="col-7"><strong>${{ number_format($customer->creditLimit,2) }}</strong></dd>
            </dl>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="row g-3 mb-3">
            <div class="col-sm-6">
                <div class="kpi-card" style="--accent:#6366f1;--accent-light:#eef2ff">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="kpi-value">${{ number_format($totalSpent,0) }}</div>
                            <div class="kpi-label">Total Spent (non-cancelled)</div>
                        </div>
                        <div class="kpi-icon"><i class="bi bi-cash-stack"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="kpi-card" style="--accent:#10b981;--accent-light:#d1fae5">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="kpi-value">{{ $orders->count() }}</div>
                            <div class="kpi-label">Total Orders</div>
                        </div>
                        <div class="kpi-icon"><i class="bi bi-cart3"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-card">
            <h6 class="fw-700 mb-3" style="font-size:.8rem;text-transform:uppercase;color:#94a3b8;letter-spacing:.06em">
                Order History
            </h6>
            <div class="bi-table">
                <table class="table table-hover" style="font-size:.85rem">
                    <thead><tr>
                        <th>Order #</th><th>Date</th><th>Required</th><th>Shipped</th><th>Status</th>
                    </tr></thead>
                    <tbody>
                    @forelse($orders as $o)
                    @php
                        $statusClass = match($o->status) {
                            'Shipped'    => 'status-shipped',
                            'Cancelled'  => 'status-cancelled',
                            'In Process' => 'status-inprocess',
                            'On Hold'    => 'status-onhold',
                            default      => 'status-resolved',
                        };
                    @endphp
                    <tr>
                        <td><a href="{{ route('orders.show',$o->orderNumber) }}" class="text-decoration-none">
                            <code>#{{ $o->orderNumber }}</code>
                        </a></td>
                        <td>{{ $o->orderDate }}</td>
                        <td>{{ $o->requiredDate }}</td>
                        <td>{{ $o->shippedDate ?? '—' }}</td>
                        <td><span class="status-badge {{ $statusClass }}">{{ $o->status }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">No orders found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
