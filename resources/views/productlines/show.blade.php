@extends('layouts.app')
@section('title','Product Line Detail')
@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-tags me-2" style="color:#6366f1"></i>{{ $line->productLine }}</h1>
        <p>${{ number_format($revenue,0) }} total revenue &mdash; {{ $products->count() }} products</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('product-lines.edit',$line->productLine) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
        <a href="{{ route('product-lines.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>
@if($line->textDescription)
<div class="form-card mb-4" style="max-width:720px">
    <p style="color:#475569;font-size:.9rem;line-height:1.7;margin:0">{{ $line->textDescription }}</p>
</div>
@endif
<div class="bi-table">
    <table class="table table-hover">
        <thead><tr><th>Code</th><th>Name</th><th>Scale</th><th>Stock</th><th>MSRP</th><th>Action</th></tr></thead>
        <tbody>
        @forelse($products as $p)
        <tr>
            <td><code>{{ $p->productCode }}</code></td>
            <td>{{ $p->productName }}</td>
            <td>{{ $p->productScale }}</td>
            <td>{{ number_format($p->quantityInStock) }}</td>
            <td>${{ number_format($p->MSRP,2) }}</td>
            <td><a href="{{ route('products.show',$p->productCode) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a></td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted">No products in this line.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
