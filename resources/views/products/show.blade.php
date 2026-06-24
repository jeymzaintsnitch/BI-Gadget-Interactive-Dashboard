@extends('layouts.app')
@section('title','Product Detail')
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-box-seam me-2" style="color:#6366f1"></i>{{ $product->productName }}</h1>
        <p><code>{{ $product->productCode }}</code> &mdash;
            <span class="badge" style="background:#eef2ff;color:#6366f1">{{ $product->productLine }}</span>
            &mdash; Scale {{ $product->productScale }}
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('products.edit',$product->productCode) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-sm-3">
        <div class="kpi-card" style="--accent:#6366f1;--accent-light:#eef2ff">
            <div class="kpi-value">${{ number_format($totalRevenue,0) }}</div>
            <div class="kpi-label">Total Revenue</div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="kpi-card" style="--accent:#10b981;--accent-light:#d1fae5">
            <div class="kpi-value">{{ number_format($totalSold) }}</div>
            <div class="kpi-label">Units Sold</div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="kpi-card" style="--accent:#f59e0b;--accent-light:#fef3c7">
            <div class="kpi-value">{{ number_format($product->quantityInStock) }}</div>
            <div class="kpi-label">In Stock</div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="kpi-card" style="--accent:#0ea5e9;--accent-light:#e0f2fe">
            <div class="kpi-value">${{ number_format($product->MSRP,2) }}</div>
            <div class="kpi-label">MSRP</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-4">
        <div class="form-card">
            <h6 class="fw-bold mb-3" style="font-size:.8rem;text-transform:uppercase;color:#94a3b8">Product Details</h6>
            <dl class="row" style="font-size:.875rem">
                <dt class="col-5 text-muted">Vendor</dt>    <dd class="col-7">{{ $product->productVendor }}</dd>
                <dt class="col-5 text-muted">Buy Price</dt> <dd class="col-7">${{ number_format($product->buyPrice,2) }}</dd>
                <dt class="col-5 text-muted">MSRP</dt>      <dd class="col-7">${{ number_format($product->MSRP,2) }}</dd>
                <dt class="col-5 text-muted">Margin</dt>
                <dd class="col-7">
                    @php $margin = $product->MSRP>0?round(($product->MSRP-$product->buyPrice)/$product->MSRP*100,1):0; @endphp
                    <span class="badge" style="background:#d1fae5;color:#065f46">{{ $margin }}%</span>
                </dd>
            </dl>
            @if($product->productDescription)
            <hr>
            <p style="font-size:.8rem;color:#64748b;line-height:1.6">{{ $product->productDescription }}</p>
            @endif
        </div>
    </div>
    <div class="col-xl-8">
        <div class="chart-card">
            <div class="card-header-custom">
                <div class="card-title">Monthly Sales History</div>
            </div>
            <canvas id="salesChart" height="220"></canvas>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
new Chart(document.getElementById('salesChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($salesHistory->pluck('period')) !!},
        datasets: [{
            label: 'Revenue ($)',
            data: {!! json_encode($salesHistory->pluck('revenue')->map(fn($v)=>round($v,2))) !!},
            backgroundColor: '#6366f1cc', borderRadius: 6
        },{
            label: 'Units',
            data: {!! json_encode($salesHistory->pluck('qty')) !!},
            backgroundColor: '#10b98188', borderRadius: 6, yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y:  { ticks: { callback: v => '$'+Intl.NumberFormat('en',{notation:'compact'}).format(v) } },
            y1: { position: 'right', grid: { drawOnChartArea: false } }
        }
    }
});
</script>
@endsection
