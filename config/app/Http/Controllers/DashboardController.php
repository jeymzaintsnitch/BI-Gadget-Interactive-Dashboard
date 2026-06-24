<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // KPI Cards
        $totalRevenue   = DB::table('orderdetails')
            ->join('orders', 'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->where('orders.status', '!=', 'Cancelled')
            ->sum(DB::raw('orderdetails.quantityOrdered * orderdetails.priceEach'));

        $totalOrders    = DB::table('orders')->where('status', '!=', 'Cancelled')->count();
        $totalCustomers = DB::table('customers')->count();
        $totalProducts  = DB::table('products')->count();

        // Q1 Best city by sales
        $bestCity = DB::table('orderdetails')
            ->join('orders',    'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->join('customers', 'orders.customerNumber',   '=', 'customers.customerNumber')
            ->where('orders.status', '!=', 'Cancelled')
            ->select('customers.city', DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as total_sales'))
            ->groupBy('customers.city')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get();

        // Q2 Highest selling product
        $topProducts = DB::table('orderdetails')
            ->join('orders',   'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->join('products', 'orderdetails.productCode', '=', 'products.productCode')
            ->where('orders.status', '!=', 'Cancelled')
            ->select('products.productName', DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as total_sales'))
            ->groupBy('products.productName')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get();

        // Q3 Best office by sales support
        $bestOffice = DB::table('orderdetails')
            ->join('orders',    'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->join('customers', 'orders.customerNumber',   '=', 'customers.customerNumber')
            ->join('employees', 'customers.salesRepEmployeeNumber', '=', 'employees.employeeNumber')
            ->join('offices',   'employees.officeCode',    '=', 'offices.officeCode')
            ->where('orders.status', '!=', 'Cancelled')
            ->select('offices.city as office_city', 'offices.country', DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as total_sales'))
            ->groupBy('offices.city', 'offices.country')
            ->orderByDesc('total_sales')
            ->get();

        // Q4 Product line revenue
        $productLineRevenue = DB::table('orderdetails')
            ->join('orders',       'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->join('products',     'orderdetails.productCode', '=', 'products.productCode')
            ->join('productlines', 'products.productLine',     '=', 'productlines.productLine')
            ->where('orders.status', '!=', 'Cancelled')
            ->select('products.productLine', DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as total_revenue'))
            ->groupBy('products.productLine')
            ->orderByDesc('total_revenue')
            ->get();

        // Q5 Office managing highest revenue products
        $officeProductRevenue = DB::table('orderdetails')
            ->join('orders',    'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->join('customers', 'orders.customerNumber',   '=', 'customers.customerNumber')
            ->join('employees', 'customers.salesRepEmployeeNumber', '=', 'employees.employeeNumber')
            ->join('offices',   'employees.officeCode',    '=', 'offices.officeCode')
            ->join('products',  'orderdetails.productCode','=', 'products.productCode')
            ->where('orders.status', '!=', 'Cancelled')
            ->select('offices.city', 'products.productLine', DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as revenue'))
            ->groupBy('offices.city', 'products.productLine')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        // Q6 Late shipments per product (exclude Cancelled orders)
        $lateShipments = DB::table('orders')
            ->join('orderdetails', 'orders.orderNumber', '=', 'orderdetails.orderNumber')
            ->join('products',     'orderdetails.productCode', '=', 'products.productCode')
            ->whereNotNull('orders.shippedDate')
            ->where('orders.status', '!=', 'Cancelled')
            ->whereRaw('orders.shippedDate > orders.requiredDate')
            ->select('products.productName', DB::raw('COUNT(DISTINCT orders.orderNumber) as late_count'))
            ->groupBy('products.productName')
            ->orderByDesc('late_count')
            ->limit(10)
            ->get();

        // Q7 Orders by country
        $ordersByCountry = DB::table('orders')
            ->join('customers', 'orders.customerNumber', '=', 'customers.customerNumber')
            ->where('orders.status', '!=', 'Cancelled')
            ->select('customers.country', DB::raw('COUNT(orders.orderNumber) as total_orders'))
            ->groupBy('customers.country')
            ->orderByDesc('total_orders')
            ->limit(10)
            ->get();

        // Q8 Monthly sales trend (MoM)
        $monthlyTrend = DB::table('orderdetails')
            ->join('orders', 'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->where('orders.status', '!=', 'Cancelled')
            ->select(
                DB::raw('YEAR(orders.orderDate) as yr'),
                DB::raw('MONTH(orders.orderDate) as mo'),
                DB::raw('DATE_FORMAT(orders.orderDate, "%Y-%m") as period'),
                DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as monthly_sales')
            )
            ->groupBy('yr', 'mo', 'period')
            ->orderBy('yr')
            ->orderBy('mo')
            ->get();

        // Q9 Sales employee efficiency (revenue per customer)
        $employeeEfficiency = DB::table('orderdetails')
            ->join('orders',    'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->join('customers', 'orders.customerNumber',   '=', 'customers.customerNumber')
            ->join('employees', 'customers.salesRepEmployeeNumber', '=', 'employees.employeeNumber')
            ->where('orders.status', '!=', 'Cancelled')
            ->select(
                DB::raw("CONCAT(employees.firstName, ' ', employees.lastName) as emp_name"),
                DB::raw('COUNT(DISTINCT customers.customerNumber) as customer_count'),
                DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as total_revenue'),
                DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) / COUNT(DISTINCT customers.customerNumber) as revenue_per_customer')
            )
            ->groupBy('employees.employeeNumber', 'employees.firstName', 'employees.lastName')
            ->orderByDesc('revenue_per_customer')
            ->limit(10)
            ->get();

        // Q10 Best month/year overall
        $bestMonths = DB::table('orderdetails')
            ->join('orders', 'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->where('orders.status', '!=', 'Cancelled')
            ->select(
                DB::raw('DATE_FORMAT(orders.orderDate, "%B %Y") as month_year'),
                DB::raw('DATE_FORMAT(orders.orderDate, "%Y-%m") as sort_key'),
                DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as total_sales')
            )
            ->groupBy('month_year', 'sort_key')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact(
            'totalRevenue', 'totalOrders', 'totalCustomers', 'totalProducts',
            'bestCity', 'topProducts', 'bestOffice', 'productLineRevenue',
            'officeProductRevenue', 'lateShipments', 'ordersByCountry',
            'monthlyTrend', 'employeeEfficiency', 'bestMonths'
        ));
    }

    public function chartData(string $type)
    {
        switch ($type) {
            case 'city-sales':
                $data = DB::table('orderdetails')
                    ->join('orders',    'orderdetails.orderNumber', '=', 'orders.orderNumber')
                    ->join('customers', 'orders.customerNumber',   '=', 'customers.customerNumber')
                    ->where('orders.status', '!=', 'Cancelled')
                    ->select('customers.city', DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as total'))
                    ->groupBy('customers.city')->orderByDesc('total')->limit(10)->get();
                return response()->json(['labels' => $data->pluck('city'), 'values' => $data->pluck('total')]);

            case 'product-sales':
                $data = DB::table('orderdetails')
                    ->join('orders',   'orderdetails.orderNumber', '=', 'orders.orderNumber')
                    ->join('products', 'orderdetails.productCode', '=', 'products.productCode')
                    ->where('orders.status', '!=', 'Cancelled')
                    ->select('products.productName', DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as total'))
                    ->groupBy('products.productName')->orderByDesc('total')->limit(10)->get();
                return response()->json(['labels' => $data->pluck('productName'), 'values' => $data->pluck('total')]);

            case 'office-sales':
                $data = DB::table('orderdetails')
                    ->join('orders',    'orderdetails.orderNumber', '=', 'orders.orderNumber')
                    ->join('customers', 'orders.customerNumber',   '=', 'customers.customerNumber')
                    ->join('employees', 'customers.salesRepEmployeeNumber', '=', 'employees.employeeNumber')
                    ->join('offices',   'employees.officeCode',    '=', 'offices.officeCode')
                    ->where('orders.status', '!=', 'Cancelled')
                    ->select('offices.city', DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as total'))
                    ->groupBy('offices.city')->orderByDesc('total')->get();
                return response()->json(['labels' => $data->pluck('city'), 'values' => $data->pluck('total')]);

            case 'productline-revenue':
                $data = DB::table('orderdetails')
                    ->join('orders',   'orderdetails.orderNumber', '=', 'orders.orderNumber')
                    ->join('products', 'orderdetails.productCode', '=', 'products.productCode')
                    ->where('orders.status', '!=', 'Cancelled')
                    ->select('products.productLine', DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as total'))
                    ->groupBy('products.productLine')->orderByDesc('total')->get();
                return response()->json(['labels' => $data->pluck('productLine'), 'values' => $data->pluck('total')]);

            case 'monthly-trend':
                $data = DB::table('orderdetails')
                    ->join('orders', 'orderdetails.orderNumber', '=', 'orders.orderNumber')
                    ->where('orders.status', '!=', 'Cancelled')
                    ->select(DB::raw('DATE_FORMAT(orders.orderDate,"%Y-%m") as period'), DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as total'))
                    ->groupBy('period')->orderBy('period')->get();
                return response()->json(['labels' => $data->pluck('period'), 'values' => $data->pluck('total')]);

            case 'country-orders':
                $data = DB::table('orders')
                    ->join('customers', 'orders.customerNumber', '=', 'customers.customerNumber')
                    ->where('orders.status', '!=', 'Cancelled')
                    ->select('customers.country', DB::raw('COUNT(orders.orderNumber) as total'))
                    ->groupBy('customers.country')->orderByDesc('total')->limit(10)->get();
                return response()->json(['labels' => $data->pluck('country'), 'values' => $data->pluck('total')]);

            default:
                return response()->json(['error' => 'Unknown chart type'], 404);
        }
    }
}
