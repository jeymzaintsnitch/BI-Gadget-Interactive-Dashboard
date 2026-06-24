@extends('layouts.app')
@section('title','Orders')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-cart3 me-2" style="color:#6366f1"></i>Orders</h1>
        <p>View and manage all customer orders.</p>
    </div>
    @if(session('user_role') !== 'staff')
    <a href="{{ route('orders.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>New Order</a>
    @endif
</div>

<div class="form-card mb-3">
    <form method="GET" class="d-flex gap-2 flex-wrap">
        <input type="text" name="search" class="form-control" style="max-width:280px"
               placeholder="Order # or customer…" value="{{ $search }}">
        <select name="status" class="form-select" style="max-width:180px">
            <option value="">All Statuses</option>
            @foreach($statuses as $s)
            <option value="{{ $s }}" {{ $status==$s?'selected':'' }}>{{ $s }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary px-4">Filter</button>
        @if($search||$status)<a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
    </form>
</div>

<div class="bi-table">
    <table class="table table-hover">
        <thead><tr>
            <th>Order #</th><th>Customer</th><th>Order Date</th>
            <th>Required</th><th>Shipped</th><th>Status</th><th>Total</th><th>Actions</th>
        </tr></thead>
        <tbody>
        @forelse($orders as $o)
        @php
            $sc = match($o->status) {
                'Shipped'=>'status-shipped','Cancelled'=>'status-cancelled',
                'In Process'=>'status-inprocess','On Hold'=>'status-onhold',
                default=>'status-resolved'
            };
            $late = $o->shippedDate && $o->shippedDate > $o->requiredDate;
        @endphp
        <tr>
            <td><a href="{{ route('orders.show',$o->orderNumber) }}" class="text-decoration-none">
                <code>#{{ $o->orderNumber }}</code>
            </a></td>
            <td>{{ $o->customerName }}</td>
            <td>{{ $o->orderDate }}</td>
            <td>{{ $o->requiredDate }}</td>
            <td>
                {{ $o->shippedDate ?? '—' }}
                @if($late)<span class="ms-1 badge" style="background:#fee2e2;color:#dc2626;font-size:.6rem">LATE</span>@endif
            </td>
            <td><span class="status-badge {{ $sc }}">{{ $o->status }}</span></td>
            <td>${{ number_format($o->order_total,0) }}</td>
            <td>
                <div class="d-flex gap-1">
                    <a href="{{ route('orders.show',$o->orderNumber) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                    @if(session('user_role') !== 'staff')
                    <a href="{{ route('orders.edit',$o->orderNumber) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('orders.destroy',$o->orderNumber) }}"
                          onsubmit="return confirm('Delete order #{{ $o->orderNumber }}?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center text-muted py-4">No orders found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
