@extends('layouts.app')
@section('title','Offices')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-building me-2" style="color:#6366f1"></i>Offices</h1>
        <p>All company office locations worldwide.</p>
    </div>
    @if(session('user_role') !== 'staff')
    <a href="{{ route('offices.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add Office</a>
    @endif
</div>

<div class="form-card mb-3">
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Search city, country, territory…" value="{{ $search }}">
        <button type="submit" class="btn btn-primary px-4">Search</button>
        @if($search)<a href="{{ route('offices.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
    </form>
</div>

<div class="bi-table">
    <table class="table table-hover">
        <thead><tr>
            <th>Code</th><th>City</th><th>Country</th><th>Territory</th><th>Phone</th><th>Actions</th>
        </tr></thead>
        <tbody>
        @forelse($offices as $o)
        <tr>
            <td><code>{{ $o->officeCode }}</code></td>
            <td><strong>{{ $o->city }}</strong></td>
            <td>{{ $o->country }}</td>
            <td><span class="badge" style="background:#eef2ff;color:#6366f1;font-size:.7rem">{{ $o->territory }}</span></td>
            <td>{{ $o->phone }}</td>
            <td>
                <div class="d-flex gap-1">
                    <a href="{{ route('offices.show',$o->officeCode) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                    @if(session('user_role') !== 'staff')
                    <a href="{{ route('offices.edit',$o->officeCode) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('offices.destroy',$o->officeCode) }}"
                          onsubmit="return confirm('Delete this office?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">No offices found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $offices->links() }}</div>
@endsection
