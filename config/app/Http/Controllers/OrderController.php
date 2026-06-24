<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $query  = DB::table('orders')
            ->join('customers', 'orders.customerNumber', '=', 'customers.customerNumber')
            ->select('orders.*', 'customers.customerName',
                DB::raw('(SELECT SUM(od.quantityOrdered * od.priceEach) FROM orderdetails od WHERE od.orderNumber = orders.orderNumber) as order_total'));
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('orders.orderNumber', 'like', "%$search%")
                  ->orWhere('customers.customerName', 'like', "%$search%");
            });
        }
        if ($status) $query->where('orders.status', $status);
        $orders   = $query->orderByDesc('orders.orderDate')->paginate(15)->withQueryString();
        $statuses = DB::table('orders')->select('status')->distinct()->pluck('status');
        return view('orders.index', compact('orders', 'search', 'status', 'statuses'));
    }

    public function create()
    {
        $customers = DB::table('customers')->orderBy('customerName')->get();
        return view('orders.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'orderNumber'    => 'required|integer|unique:orders,orderNumber',
            'orderDate'      => 'required|date',
            'requiredDate'   => 'required|date',
            'shippedDate'    => 'nullable|date',
            'status'         => 'required|in:Shipped,Cancelled,Resolved,On Hold,In Process,Disputed',
            'comments'       => 'nullable|string',
            'customerNumber' => 'required|integer|exists:customers,customerNumber',
        ]);
        DB::table('orders')->insert($data);
        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show($id)
    {
        $order = DB::table('orders')
            ->join('customers', 'orders.customerNumber', '=', 'customers.customerNumber')
            ->select('orders.*', 'customers.customerName', 'customers.city', 'customers.country')
            ->where('orders.orderNumber', $id)->first();
        if (!$order) abort(404);

        $details = DB::table('orderdetails')
            ->join('products', 'orderdetails.productCode', '=', 'products.productCode')
            ->select('orderdetails.*', 'products.productName',
                DB::raw('orderdetails.quantityOrdered * orderdetails.priceEach as line_total'))
            ->where('orderdetails.orderNumber', $id)
            ->orderBy('orderdetails.orderLineNumber')->get();

        $orderTotal = $details->sum('line_total');
        $isLate     = $order->shippedDate && $order->shippedDate > $order->requiredDate;
        return view('orders.show', compact('order', 'details', 'orderTotal', 'isLate'));
    }

    public function edit($id)
    {
        $order     = DB::table('orders')->where('orderNumber', $id)->first();
        if (!$order) abort(404);
        $customers = DB::table('customers')->orderBy('customerName')->get();
        return view('orders.edit', compact('order', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'orderDate'      => 'required|date',
            'requiredDate'   => 'required|date',
            'shippedDate'    => 'nullable|date',
            'status'         => 'required|in:Shipped,Cancelled,Resolved,On Hold,In Process,Disputed',
            'comments'       => 'nullable|string',
            'customerNumber' => 'required|integer|exists:customers,customerNumber',
        ]);
        DB::table('orders')->where('orderNumber', $id)->update($data);
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('orderdetails')->where('orderNumber', $id)->delete();
        DB::table('orders')->where('orderNumber', $id)->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted.');
    }
}
