@extends('layouts.app')
@section('title','Product Lines')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-tags me-2" style="color:#6366f1"></i>Product Lines</h1>
        <p>Manage product categories and lines.</p>
    </div>
    @if(session('user_role') !== 'staff')
    <a href="{{ route('product-lines.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add Line</a>
    @endif
</div>
<div class="bi-table">
    <table class="table table-hover">
        <thead><tr><th>Product Line</th><th>Products</th><th>Description</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($lines as $l)
        <tr>
            <td><strong>{{ $l->productLine }}</strong></td>
            <td><span class="badge" style="background:#eef2ff;color:#6366f1">{{ $l->product_count }}</span></td>
            <td>{{ Str::limit($l->textDescription, 80) }}</td>
            <td>
                <div class="d-flex gap-1">
                    <a href="{{ route('product-lines.show',$l->productLine) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                    @if(session('user_role') !== 'staff')
                    <a href="{{ route('product-lines.edit',$l->productLine) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('product-lines.destroy',$l->productLine) }}"
                          onsubmit="return confirm('Delete this product line?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center text-muted py-4">No product lines found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
