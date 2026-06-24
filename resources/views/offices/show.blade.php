@extends('layouts.app')
@section('title','Office Detail')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-building me-2" style="color:#6366f1"></i>{{ $office->city }} Office</h1>
        <p>{{ $office->country }} &mdash; Territory: {{ $office->territory }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('offices.edit',$office->officeCode) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
        <a href="{{ route('offices.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-4">
        <div class="form-card mb-4">
            <h6 class="fw-bold mb-3" style="font-size:.8rem;text-transform:uppercase;color:#94a3b8">Office Info</h6>
            <dl class="row" style="font-size:.875rem">
                <dt class="col-5 text-muted">Code</dt>     <dd class="col-7"><code>{{ $office->officeCode }}</code></dd>
                <dt class="col-5 text-muted">Phone</dt>    <dd class="col-7">{{ $office->phone }}</dd>
                <dt class="col-5 text-muted">Address</dt>  <dd class="col-7">{{ $office->addressLine1 }}</dd>
                <dt class="col-5 text-muted">State</dt>    <dd class="col-7">{{ $office->state ?? '—' }}</dd>
                <dt class="col-5 text-muted">Postal</dt>   <dd class="col-7">{{ $office->postalCode }}</dd>
            </dl>
        </div>
        <div class="kpi-card" style="--accent:#6366f1;--accent-light:#eef2ff">
            <div class="kpi-value">${{ number_format($revenue/1000,0) }}K</div>
            <div class="kpi-label">Total Revenue Supported</div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="form-card">
            <h6 class="fw-bold mb-3" style="font-size:.8rem;text-transform:uppercase;color:#94a3b8">
                Staff ({{ $employees->count() }})
            </h6>
            <div class="bi-table">
                <table class="table table-hover" style="font-size:.85rem">
                    <thead><tr><th>ID</th><th>Name</th><th>Title</th><th>Email</th></tr></thead>
                    <tbody>
                    @forelse($employees as $e)
                    <tr>
                        <td><code>{{ $e->employeeNumber }}</code></td>
                        <td><a href="{{ route('employees.show',$e->employeeNumber) }}">{{ $e->firstName }} {{ $e->lastName }}</a></td>
                        <td>{{ $e->jobTitle }}</td>
                        <td>{{ $e->email }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">No employees.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
