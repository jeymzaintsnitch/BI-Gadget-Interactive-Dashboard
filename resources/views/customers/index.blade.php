@extends('layouts.app')
@section('title','Customers')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-people me-2" style="color:#6366f1"></i>Customers</h1>
        <p>Manage all customer accounts and profiles.</p>
    </div>
    @if(session('user_role') !== 'staff')
    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Customer
    </a>
    @endif
</div>

<div class="form-card mb-3">
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Search by name, city, country…" value="{{ $search }}">
        <button type="submit" class="btn btn-primary px-4">Search</button>
        @if($search)<a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
    </form>
</div>

<div class="bi-table">
    <table class="table table-hover">
        <thead><tr>
            <th>ID</th><th>Customer</th><th>Contact</th><th>City</th><th>Country</th>
            <th>Credit Limit</th><th>Sales Rep</th><th>Actions</th>
        </tr></thead>
        <tbody>
        @forelse($customers as $c)
        <tr>
            <td><code>{{ $c->customerNumber }}</code></td>
            <td><strong>{{ $c->customerName }}</strong></td>
            <td>{{ $c->contactFirstName }} {{ $c->contactLastName }}</td>
            <td>{{ $c->city }}</td>
            <td>{{ $c->country }}</td>
            <td>${{ number_format($c->creditLimit,0) }}</td>
            <td>{{ $c->rep_name ?? '—' }}</td>
            <td>
                <div class="d-flex gap-1">
                    <a href="{{ route('customers.show',$c->customerNumber) }}" class="btn btn-sm btn-outline-secondary" title="View"><i class="bi bi-eye"></i></a>
                    @if(session('user_role') !== 'staff')
                    <a href="{{ route('customers.edit',$c->customerNumber) }}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('customers.destroy',$c->customerNumber) }}" onsubmit="return confirm('Delete this customer?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center text-muted py-4">No customers found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $customers->links() }}</div>
@endsection
