@extends('layouts.app')
@section('title','Add Product')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-plus-square me-2" style="color:#6366f1"></i>Add New Product</h1>
</div>
<div class="form-card" style="max-width:720px">
    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Product Code *</label>
                <input type="text" name="productCode" class="form-control" value="{{ old('productCode') }}" required placeholder="e.g. S10_1234">
            </div>
            <div class="col-md-8">
                <label class="form-label">Product Name *</label>
                <input type="text" name="productName" class="form-control" value="{{ old('productName') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Product Line *</label>
                <select name="productLine" class="form-select" required>
                    <option value="">— Select —</option>
                    @foreach($productLines as $line)
                    <option value="{{ $line }}" {{ old('productLine')==$line?'selected':'' }}>{{ $line }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Scale</label>
                <input type="text" name="productScale" class="form-control" value="{{ old('productScale') }}" placeholder="1:18">
            </div>
            <div class="col-md-3">
                <label class="form-label">Stock Qty *</label>
                <input type="number" name="quantityInStock" class="form-control" value="{{ old('quantityInStock',0) }}" min="0" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Vendor</label>
                <input type="text" name="productVendor" class="form-control" value="{{ old('productVendor') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Buy Price *</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" name="buyPrice" class="form-control" value="{{ old('buyPrice') }}" required>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">MSRP *</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" name="MSRP" class="form-control" value="{{ old('MSRP') }}" required>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="productDescription" class="form-control" rows="3">{{ old('productDescription') }}</textarea>
            </div>
        </div>
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
