@extends('layouts.app')
@section('title','Employees')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-person-badge me-2" style="color:#6366f1"></i>Employees</h1>
        <p>Manage sales staff across all offices.</p>
    </div>
    @if(session('user_role') !== 'staff')
    <a href="{{ route('employees.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add Employee</a>
    @endif
</div>

<div class="form-card mb-3">
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Search by name, email, title…" value="{{ $search }}">
        <button type="submit" class="btn btn-primary px-4">Search</button>
        @if($search)<a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
    </form>
</div>

<div class="bi-table">
    <table class="table table-hover">
        <thead><tr>
            <th>ID</th><th>Name</th><th>Title</th><th>Email</th>
            <th>Office</th><th>Manager</th><th>Actions</th>
        </tr></thead>
        <tbody>
        @forelse($employees as $e)
        <tr>
            <td><code>{{ $e->employeeNumber }}</code></td>
            <td><strong>{{ $e->firstName }} {{ $e->lastName }}</strong></td>
            <td><span class="badge" style="background:#eef2ff;color:#6366f1;font-size:.7rem">{{ $e->jobTitle }}</span></td>
            <td><a href="mailto:{{ $e->email }}">{{ $e->email }}</a></td>
            <td>{{ $e->officeName }}</td>
            <td>{{ $e->manager_name ?? '—' }}</td>
            <td>
                <div class="d-flex gap-1">
                    <a href="{{ route('employees.show',$e->employeeNumber) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                    @if(session('user_role') !== 'staff')
                    <a href="{{ route('employees.edit',$e->employeeNumber) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('employees.destroy',$e->employeeNumber) }}"
                          onsubmit="return confirm('Delete this employee?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">No employees found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $employees->links() }}</div>
@endsection
