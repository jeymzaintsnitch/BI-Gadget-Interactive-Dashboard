@extends('layouts.app')
@section('title','Add Product Line')
@section('content')
<div class="page-header"><h1><i class="bi bi-plus-square me-2" style="color:#6366f1"></i>Add Product Line</h1></div>
<div class="form-card" style="max-width:580px">
    <form method="POST" action="{{ route('product-lines.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Product Line Name *</label>
            <input type="text" name="productLine" class="form-control" value="{{ old('productLine') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="textDescription" class="form-control" rows="4">{{ old('textDescription') }}</textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save</button>
            <a href="{{ route('product-lines.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
