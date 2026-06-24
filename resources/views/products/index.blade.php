@extends('layouts.app')
@section('title','Products')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-box-seam me-2" style="color:#6366f1"></i>Products</h1>
        <p>Manage your full product catalog.</p>
    </div>
    @if(session('user_role') !== 'staff')
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Product
    </a>
    @endif
</div>

<div class="form-card mb-3">
    <form method="GET" class="d-flex gap-2 flex-wrap">
        <input type="text" name="search" class="form-control" style="max-width:300px"
               placeholder="Search by name or code…" value="{{ $search }}">
        <select name="productLine" class="form-select" style="max-width:200px">
            <option value="">All Lines</option>
            @foreach($productLines as $line)
            <option value="{{ $line }}" {{ $filterLine==$line?'selected':'' }}>{{ $line }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary px-4">Search</button>
        @if($search || $filterLine)
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Clear</a>
        @endif
    </form>
</div>

<div class="bi-table">
    <table class="table table-hover">
        <thead><tr>
            <th>Code</th><th>Name</th><th>Line</th><th>Scale</th>
            <th>Stock</th><th>Buy Price</th><th>MSRP</th><th>Actions</th>
        </tr></thead>
        <tbody>
        @forelse($products as $p)
        <tr>
            <td><code>{{ $p->productCode }}</code></td>
            <td><strong>{{ $p->productName }}</strong></td>
            <td>
                <span class="badge" style="background:#eef2ff;color:#6366f1;font-size:.7rem">
                    {{ $p->productLine }}
                </span>
            </td>
            <td>{{ $p->productScale }}</td>
            <td>
                <span class="{{ $p->quantityInStock < 500 ? 'text-danger fw-bold' : '' }}">
                    {{ number_format($p->quantityInStock) }}
                </span>
            </td>
            <td>${{ number_format($p->buyPrice,2) }}</td>
            <td>${{ number_format($p->MSRP,2) }}</td>
            <td>
                <div class="d-flex gap-1">
                    <a href="{{ route('products.show',$p->productCode) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                    @if(session('user_role') !== 'staff')
                    <a href="{{ route('products.edit',$p->productCode) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('products.destroy',$p->productCode) }}"
                          onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center text-muted py-4">No products found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $products->links() }}</div>
@endsection
