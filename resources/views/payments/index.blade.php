@extends('layouts.app')
@section('title','Payments')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-credit-card me-2" style="color:#6366f1"></i>Payments</h1>
        <p>Customer payment records and check history.</p>
    </div>
    @if(session('user_role') !== 'staff')
    <a href="{{ route('payments.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Record Payment</a>
    @endif
</div>

<div class="form-card mb-3">
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Customer name or check #…" value="{{ $search }}">
        <button type="submit" class="btn btn-primary px-4">Search</button>
        @if($search)<a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
    </form>
</div>

<div class="bi-table">
    <table class="table table-hover">
        <thead><tr><th>Customer</th><th>Check #</th><th>Payment Date</th><th>Amount</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($payments as $p)
        <tr>
            <td>{{ $p->customerName }}</td>
            <td><code>{{ $p->checkNumber }}</code></td>
            <td>{{ $p->paymentDate }}</td>
            <td><strong>${{ number_format($p->amount,2) }}</strong></td>
            <td>
                <div class="d-flex gap-1">
                    @if(session('user_role') !== 'staff')
                    <a href="{{ route('payments.edit', $p->customerNumber.'_'.$p->checkNumber) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('payments.destroy', $p->customerNumber.'_'.$p->checkNumber) }}"
                          onsubmit="return confirm('Delete this payment?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                    @else
                    <span class="text-muted" style="font-size:.75rem">View only</span>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center text-muted py-4">No payments found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $payments->links() }}</div>
@endsection
