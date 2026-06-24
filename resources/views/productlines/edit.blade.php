@extends('layouts.app')
@section('title','Edit Product Line')
@section('content')
<div class="page-header"><h1><i class="bi bi-pencil-square me-2" style="color:#6366f1"></i>Edit — {{ $line->productLine }}</h1></div>
<div class="form-card" style="max-width:580px">
    <form method="POST" action="{{ route('product-lines.update',$line->productLine) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Product Line</label>
            <input type="text" class="form-control" value="{{ $line->productLine }}" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="textDescription" class="form-control" rows="4">{{ old('textDescription',$line->textDescription) }}</textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
            <a href="{{ route('product-lines.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
