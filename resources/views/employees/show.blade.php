@extends('layouts.app')
@section('title','Employee Detail')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-person-badge me-2" style="color:#6366f1"></i>{{ $employee->firstName }} {{ $employee->lastName }}</h1>
        <p>{{ $employee->jobTitle }} &mdash; {{ $employee->officeName }}, {{ $employee->country }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('employees.edit',$employee->employeeNumber) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-4">
        <div class="form-card mb-4">
            <h6 class="fw-bold mb-3" style="font-size:.8rem;text-transform:uppercase;color:#94a3b8">Profile</h6>
            <dl class="row" style="font-size:.875rem">
                <dt class="col-5 text-muted">ID</dt>        <dd class="col-7"><code>{{ $employee->employeeNumber }}</code></dd>
                <dt class="col-5 text-muted">Email</dt>     <dd class="col-7">{{ $employee->email }}</dd>
                <dt class="col-5 text-muted">Extension</dt> <dd class="col-7">{{ $employee->extension }}</dd>
                <dt class="col-5 text-muted">Office</dt>    <dd class="col-7">{{ $employee->officeName }}</dd>
            </dl>
        </div>
        <div class="kpi-card" style="--accent:#6366f1;--accent-light:#eef2ff">
            <div class="kpi-value">${{ number_format($revenue,0) }}</div>
            <div class="kpi-label">Total Revenue Generated</div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="form-card">
            <h6 class="fw-bold mb-3" style="font-size:.8rem;text-transform:uppercase;color:#94a3b8">
                Assigned Customers ({{ $customers->count() }})
            </h6>
            <div class="bi-table">
                <table class="table table-hover" style="font-size:.85rem">
                    <thead><tr><th>ID</th><th>Name</th><th>City</th><th>Country</th><th>Credit Limit</th></tr></thead>
                    <tbody>
                    @forelse($customers as $c)
                    <tr>
                        <td><code>{{ $c->customerNumber }}</code></td>
                        <td><a href="{{ route('customers.show',$c->customerNumber) }}">{{ $c->customerName }}</a></td>
                        <td>{{ $c->city }}</td>
                        <td>{{ $c->country }}</td>
                        <td>${{ number_format($c->creditLimit,0) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted">No customers assigned.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
