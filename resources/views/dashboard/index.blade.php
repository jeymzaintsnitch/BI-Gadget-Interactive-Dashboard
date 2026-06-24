@extends('layouts.app')
@section('title', 'Dashboard')
@section('head')
<style>
    .bi-section-title {
        font-size: .7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .08em; color: #94a3b8; margin: 36px 0 18px;
        display: flex; align-items: center; gap: 10px;
    }
    .bi-section-title::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
    .winner-row { background: linear-gradient(90deg,#fffbeb,#fff) !important; }
    .chart-card { border-radius: 16px; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04); padding: 20px 22px 18px; height: 100%; }
    .card-header-custom { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 16px; }
    .card-title { font-size: .92rem; font-weight: 700; color: #1e293b; }
    .card-badge { font-size: .68rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; background: #eef2ff; color: #6366f1; white-space: nowrap; }
    .mini-stat { text-align:center; padding: 10px 6px; }
    .mini-stat .val { font-size: 1.3rem; font-weight: 800; color: #1e293b; }
    .mini-stat .lbl { font-size: .68rem; color: #64748b; margin-top: 2px; }
</style>
@endsection

@section('content')

{{-- ── PAGE HEADER ──────────────────────────────── --}}
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-speedometer2 me-2" style="color:#6366f1"></i>Sales Intelligence Dashboard</h1>
        <p>Sales intelligence insights from your Gadget Store data.</p>
    </div>
    <span class="badge" style="background:#eef2ff;color:#6366f1;font-size:.75rem;padding:6px 14px;border-radius:20px;">
        <i class="bi bi-calendar3 me-1"></i>All-time data
    </span>
</div>

{{-- ── KPI CARDS ── --}}
<div class="row g-3 mb-2">
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-card" style="--accent:#6366f1;--accent-light:#eef2ff">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="kpi-value">${{ number_format($totalRevenue/1000000,2) }}M</div>
                    <div class="kpi-label">Total Revenue</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-cash-stack"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-card" style="--accent:#0ea5e9;--accent-light:#e0f2fe">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="kpi-value">{{ number_format($totalOrders) }}</div>
                    <div class="kpi-label">Total Orders</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-cart3"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-card" style="--accent:#10b981;--accent-light:#d1fae5">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="kpi-value">{{ number_format($totalCustomers) }}</div>
                    <div class="kpi-label">Total Customers</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-card" style="--accent:#f59e0b;--accent-light:#fef3c7">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="kpi-value">{{ number_format($totalProducts) }}</div>
                    <div class="kpi-label">Products in Catalog</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-box-seam"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- ── SECTION 1: Market & Product ── --}}
<div class="bi-section-title">🏙️ Market &amp; Product Performance</div>
<div class="row g-4 mb-4">
    {{-- Best City - Vertical Bar --}}
    <div class="col-xl-6">
        <div class="chart-card">
            <div class="card-header-custom">
                <div>
                    <div class="card-title">Best City for Sales</div>
                    <div style="font-size:.75rem;color:#64748b">Top 10 cities ranked by total revenue</div>
                </div>
                <span class="card-badge">Revenue</span>
            </div>
            <canvas id="cityChart" height="240"></canvas>
        </div>
    </div>

    {{-- Top Products - Horizontal Bar --}}
    <div class="col-xl-6">
        <div class="chart-card">
            <div class="card-header-custom">
                <div>
                    <div class="card-title">Highest-Selling Products</div>
                    <div style="font-size:.75rem;color:#64748b">Top 10 products by revenue generated</div>
                </div>
                <span class="card-badge">Revenue</span>
            </div>
            <canvas id="productChart" height="240"></canvas>
        </div>
    </div>
</div>

{{-- ── SECTION 2: Office & Product Line ── --}}
<div class="bi-section-title">🏢 Office &amp; Product Line Intelligence</div>
<div class="row g-4 mb-4">
    {{-- Best Office - Doughnut --}}
    <div class="col-xl-4">
        <div class="chart-card">
            <div class="card-header-custom">
                <div class="card-title">Best Sales Support Office</div>
            </div>
            <canvas id="officeChart" height="260"></canvas>
        </div>
    </div>

    {{-- Product Line Revenue - Polar Area --}}
    <div class="col-xl-4">
        <div class="chart-card">
            <div class="card-header-custom">
                <div class="card-title">Product Line Revenue Share</div>
            </div>
            <canvas id="lineChart" height="260"></canvas>
        </div>
    </div>

    {{-- Office × Product Line - Stacked Bar --}}
    <div class="col-xl-4">
        <div class="chart-card">
            <div class="card-header-custom">
                <div>
                    <div class="card-title">Office × Product Line</div>
                    <div style="font-size:.75rem;color:#64748b">Which office drives which category</div>
                </div>
            </div>
            <canvas id="officeLineChart" height="260"></canvas>
        </div>
    </div>
</div>

{{-- ── SECTION 3: Shipping & Geography ── --}}
<div class="bi-section-title">⚠️ Shipping Issues &amp; Geographic Spread</div>
<div class="row g-4 mb-4">
    {{-- Late Shipments - Horizontal Bar --}}
    <div class="col-xl-6">
        <div class="chart-card">
            <div class="card-header-custom">
                <div>
                    <div class="card-title">Most Delayed Shipments by Product</div>
                    <div style="font-size:.75rem;color:#64748b">Orders shipped after the required date</div>
                </div>
                <span class="card-badge" style="background:#fee2e2;color:#dc2626">Risk</span>
            </div>
            <canvas id="lateChart" height="280"></canvas>
        </div>
    </div>

    {{-- Orders by Country - Horizontal Bar --}}
    <div class="col-xl-6">
        <div class="chart-card">
            <div class="card-header-custom">
                <div class="card-title">Orders by Country</div>
            </div>
            <canvas id="countryChart" height="280"></canvas>
        </div>
    </div>
</div>

{{-- ── SECTION 4: Trends & Time ── --}}
<div class="bi-section-title">📈 Time Trends</div>
<div class="row g-4 mb-4">
    {{-- Monthly Trend - Line + Bar combo --}}
    <div class="col-xl-8">
        <div class="chart-card">
            <div class="card-header-custom">
                <div>
                    <div class="card-title">Month-over-Month Sales Trend</div>
                    <div style="font-size:.75rem;color:#64748b">Revenue growth/decline over time with MoM %</div>
                </div>
            </div>
            <canvas id="trendChart" height="200"></canvas>
        </div>
    </div>

    {{-- Best Month/Year - Horizontal Bar --}}
    <div class="col-xl-4">
        <div class="chart-card">
            <div class="card-header-custom">
                <div>
                    <div class="card-title">Best Month/Year Overall</div>
                    <div style="font-size:.75rem;color:#64748b">Top 10 periods by total sales</div>
                </div>
                <span class="card-badge" style="background:#fef3c7;color:#92400e">🔥 Top</span>
            </div>
            <canvas id="bestMonthChart" height="200"></canvas>
        </div>
    </div>
</div>

{{-- ── SECTION 5: People Performance ── --}}
<div class="bi-section-title">👤 Employee Performance</div>
<div class="row g-4 mb-4">
    {{-- Employee Efficiency - Grouped Bar (revenue + revenue/customer) --}}
    <div class="col-xl-7">
        <div class="chart-card">
            <div class="card-header-custom">
                <div>
                    <div class="card-title">Sales Employee Efficiency</div>
                    <div style="font-size:.75rem;color:#64748b">Total revenue vs. revenue per customer</div>
                </div>
                <span class="card-badge">Efficiency</span>
            </div>
            <canvas id="empChart" height="220"></canvas>
        </div>
    </div>

    {{-- Employee Radar - bubble visual of customer count vs revenue --}}
    <div class="col-xl-5">
        <div class="chart-card">
            <div class="card-header-custom">
                <div>
                    <div class="card-title">Revenue per Customer</div>
                    <div style="font-size:.75rem;color:#64748b">Efficiency ranking by employee</div>
                </div>
            </div>
            <canvas id="empRadarChart" height="220"></canvas>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const C = ['#6366f1','#0ea5e9','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#14b8a6','#f97316','#64748b'];
const fmt = v => '$' + Intl.NumberFormat('en',{notation:'compact',maximumFractionDigits:1}).format(v);
const dflt = { responsive:true, maintainAspectRatio:true };

// ── Best City — Vertical Gradient Bar ──────────────────────
new Chart(document.getElementById('cityChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($bestCity->pluck('city')) !!},
        datasets: [{
            label: 'Sales ($)',
            data:  {!! json_encode($bestCity->pluck('total_sales')->map(fn($v)=>round($v,2))) !!},
            backgroundColor: C,
            borderRadius: 10,
            borderSkipped: false,
        }]
    },
    options: { ...dflt, plugins:{legend:{display:false}},
        scales:{ y:{ grid:{color:'#f1f5f9'}, ticks:{ callback: fmt } },
                 x:{ grid:{display:false} } }
    }
});

// ── Top Products — Horizontal Bar ──────────────────────────
new Chart(document.getElementById('productChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($topProducts->pluck('productName')->map(fn($n)=>strlen($n)>24?substr($n,0,24).'…':$n)) !!},
        datasets: [{
            label: 'Revenue ($)',
            data:  {!! json_encode($topProducts->pluck('total_sales')->map(fn($v)=>round($v,2))) !!},
            backgroundColor: C,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: { indexAxis:'y', ...dflt, plugins:{legend:{display:false}},
        scales:{ x:{ grid:{color:'#f1f5f9'}, ticks:{ callback: fmt } },
                 y:{ grid:{display:false} } }
    }
});

// ── Best Office — Doughnut ──────────────────────────────────
new Chart(document.getElementById('officeChart'), {
    type: 'doughnut',
    data: {
        labels:   {!! json_encode($bestOffice->pluck('office_city')) !!},
        datasets: [{
            data:            {!! json_encode($bestOffice->pluck('total_sales')->map(fn($v)=>round($v,2))) !!},
            backgroundColor: C,
            borderWidth: 4, borderColor: '#fff',
            hoverOffset: 8
        }]
    },
    options: { ...dflt, cutout:'60%',
        plugins:{ legend:{ position:'bottom', labels:{ font:{size:11}, padding:10, boxWidth:12 } } }
    }
});

// ── Product Line Revenue — Pie ──────────────────────────────
new Chart(document.getElementById('lineChart'), {
    type: 'pie',
    data: {
        labels:   {!! json_encode($productLineRevenue->pluck('productLine')) !!},
        datasets: [{
            data:            {!! json_encode($productLineRevenue->pluck('total_revenue')->map(fn($v)=>round($v,2))) !!},
            backgroundColor: C,
            borderColor: '#fff',
            borderWidth: 3,
            hoverOffset: 8
        }]
    },
    options: { ...dflt,
        plugins:{
            legend:{ position:'bottom', labels:{ font:{size:11}, padding:10, boxWidth:12 } },
            tooltip:{
                callbacks:{
                    label: function(ctx) {
                        const total = ctx.dataset.data.reduce((a,b) => a+b, 0);
                        const pct   = ((ctx.parsed / total) * 100).toFixed(1);
                        return ` ${ctx.label}: ${fmt(ctx.parsed)} (${pct}%)`;
                    }
                }
            }
        }
    }
});

// ── Office × Product Line — Stacked Bar ────────────────────
(function(){
    const raw = {!! json_encode($officeProductRevenue) !!};
    const offices = [...new Set(raw.map(r => r.city))];
    const lines   = [...new Set(raw.map(r => r.productLine))];
    const datasets = lines.map((line, i) => ({
        label: line,
        data: offices.map(city => {
            const found = raw.find(r => r.city === city && r.productLine === line);
            return found ? parseFloat(found.revenue) : 0;
        }),
        backgroundColor: C[i % C.length] + 'dd',
        borderColor: C[i % C.length],
        borderWidth: 1,
        borderRadius: 4,
    }));
    new Chart(document.getElementById('officeLineChart'), {
        type: 'bar',
        data: { labels: offices, datasets },
        options: { ...dflt,
            plugins:{ legend:{ position:'bottom', labels:{ font:{size:10}, padding:8, boxWidth:10 } } },
            scales:{
                x:{ stacked:true, grid:{display:false} },
                y:{ stacked:true, grid:{color:'#f1f5f9'}, ticks:{ callback: fmt } }
            }
        }
    });
})();

// ── Late Shipments — Horizontal Bar (red gradient) ─────────
new Chart(document.getElementById('lateChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($lateShipments->pluck('productName')->map(fn($n)=>strlen($n)>28?substr($n,0,28).'…':$n)) !!},
        datasets: [{
            label: 'Late Orders',
            data:  {!! json_encode($lateShipments->pluck('late_count')) !!},
            backgroundColor: {!! json_encode($lateShipments->values()->map(fn($r,$i)=> ['#fca5a5','#f87171','#ef4444','#dc2626','#b91c1c'][$i] ?? '#ef4444')->toArray()) !!},
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: { indexAxis:'y', ...dflt,
        plugins:{ legend:{display:false} },
        scales:{
            x:{ grid:{color:'#fef2f2'}, ticks:{ stepSize:1 } },
            y:{ grid:{display:false} }
        }
    }
});

// ── Orders by Country — Horizontal Bar ─────────────────────
new Chart(document.getElementById('countryChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($ordersByCountry->pluck('country')) !!},
        datasets: [{
            label: 'Orders',
            data:  {!! json_encode($ordersByCountry->pluck('total_orders')) !!},
            backgroundColor: C,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: { indexAxis:'y', ...dflt,
        plugins:{ legend:{display:false} },
        scales:{ x:{ grid:{color:'#f1f5f9'} }, y:{ grid:{display:false} } }
    }
});

// ── Monthly Trend — Line + Bar Combo ───────────────────────
(function(){
    const labels = {!! json_encode($monthlyTrend->pluck('period')) !!};
    const values = {!! json_encode($monthlyTrend->pluck('monthly_sales')->map(fn($v)=>round($v,2))) !!};
    const growth = values.map((v,i) => i===0 ? 0 : Math.round((v - values[i-1])/values[i-1]*100));
    new Chart(document.getElementById('trendChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    type: 'line',
                    label: 'Monthly Revenue',
                    data: values,
                    borderColor: '#6366f1', backgroundColor: '#6366f115',
                    fill: true, tension: 0.45, pointRadius: 4,
                    pointBackgroundColor: '#6366f1',
                    yAxisID: 'y', order: 1
                },
                {
                    type: 'bar',
                    label: 'MoM Growth (%)',
                    data: growth,
                    backgroundColor: growth.map(g => g >= 0 ? '#10b98144' : '#ef444444'),
                    borderColor:     growth.map(g => g >= 0 ? '#10b981'   : '#ef4444'),
                    borderWidth: 1.5,
                    borderRadius: 4,
                    yAxisID: 'y1', order: 2
                }
            ]
        },
        options: { ...dflt,
            interaction:{ mode:'index', intersect:false },
            plugins:{ legend:{ position:'bottom', labels:{ font:{size:11}, padding:12, boxWidth:12 } } },
            scales:{
                y:  { position:'left',  grid:{color:'#f1f5f9'}, ticks:{ callback: fmt } },
                y1: { position:'right', grid:{drawOnChartArea:false}, ticks:{ callback: v => v+'%' } }
            }
        }
    });
})();

// ── Best Month — Horizontal Bar ────────────────────────────
new Chart(document.getElementById('bestMonthChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($bestMonths->pluck('month_year')) !!},
        datasets: [{
            label: 'Total Sales ($)',
            data:  {!! json_encode($bestMonths->pluck('total_sales')->map(fn($v)=>round($v,2))) !!},
            backgroundColor: {!! json_encode($bestMonths->values()->map(fn($r,$i) => ['#6366f1','#8b5cf6','#a78bfa','#c4b5fd','#ddd6fe','#ede9fe','#eef2ff','#f5f3ff','#fdf4ff','#fdf2f8'][$i] ?? '#e2e8f0')->toArray()) !!},
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: { indexAxis:'y', ...dflt,
        plugins:{ legend:{display:false} },
        scales:{ x:{ grid:{color:'#f1f5f9'}, ticks:{ callback: fmt } }, y:{ grid:{display:false} } }
    }
});

// ── Employee Total Revenue + Revenue/Customer — Grouped Bar ─
new Chart(document.getElementById('empChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($employeeEfficiency->pluck('emp_name')) !!},
        datasets: [
            {
                label: 'Total Revenue ($)',
                data: {!! json_encode($employeeEfficiency->pluck('total_revenue')->map(fn($v)=>round($v,2))) !!},
                backgroundColor: '#6366f1cc',
                borderColor: '#6366f1',
                borderWidth: 1.5,
                borderRadius: 6,
                yAxisID: 'y'
            },
            {
                label: 'Revenue / Customer ($)',
                data: {!! json_encode($employeeEfficiency->pluck('revenue_per_customer')->map(fn($v)=>round($v,2))) !!},
                backgroundColor: '#10b981cc',
                borderColor: '#10b981',
                borderWidth: 1.5,
                borderRadius: 6,
                yAxisID: 'y1'
            }
        ]
    },
    options: { ...dflt,
        plugins:{ legend:{ position:'bottom', labels:{ font:{size:11}, padding:10, boxWidth:12 } } },
        scales:{
            y:  { position:'left',  grid:{color:'#f1f5f9'}, ticks:{ callback: fmt } },
            y1: { position:'right', grid:{drawOnChartArea:false}, ticks:{ callback: fmt } },
            x:  { grid:{display:false} }
        }
    }
});

// ── Employee Radar — Revenue per Customer ──────────────────
new Chart(document.getElementById('empRadarChart'), {
    type: 'radar',
    data: {
        labels: {!! json_encode($employeeEfficiency->pluck('emp_name')) !!},
        datasets: [
            {
                label: 'Revenue / Customer',
                data: {!! json_encode($employeeEfficiency->pluck('revenue_per_customer')->map(fn($v)=>round($v,2))) !!},
                borderColor: '#6366f1',
                backgroundColor: '#6366f122',
                pointBackgroundColor: '#6366f1',
                pointRadius: 4, borderWidth: 2
            },
            {
                label: 'Customer Count',
                data: {!! json_encode($employeeEfficiency->pluck('customer_count')) !!},
                borderColor: '#f59e0b',
                backgroundColor: '#f59e0b22',
                pointBackgroundColor: '#f59e0b',
                pointRadius: 4, borderWidth: 2
            }
        ]
    },
    options: { ...dflt,
        plugins:{ legend:{ position:'bottom', labels:{ font:{size:11}, padding:10, boxWidth:12 } } },
        scales:{ r:{ grid:{color:'#e2e8f0'}, pointLabels:{ font:{size:10} } } }
    }
});
</script>
@endsection
