<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search      = $request->get('search');
        $filterLine  = $request->get('productLine');
        $query = DB::table('products')
            ->join('productlines', 'products.productLine', '=', 'productlines.productLine')
            ->select('products.*');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('products.productName', 'like', "%$search%")
                  ->orWhere('products.productCode', 'like', "%$search%");
            });
        }
        if ($filterLine) $query->where('products.productLine', $filterLine);
        $products      = $query->orderBy('products.productName')->paginate(15)->withQueryString();
        $productLines  = DB::table('productlines')->pluck('productLine');
        return view('products.index', compact('products', 'search', 'filterLine', 'productLines'));
    }

    public function create()
    {
        $productLines = DB::table('productlines')->pluck('productLine');
        return view('products.create', compact('productLines'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'productCode'        => 'required|string|max:15|unique:products,productCode',
            'productName'        => 'required|string|max:70',
            'productLine'        => 'required|string|max:50',
            'productScale'       => 'nullable|string|max:10',
            'productVendor'      => 'nullable|string|max:50',
            'productDescription' => 'nullable|string',
            'quantityInStock'    => 'required|integer|min:0',
            'buyPrice'           => 'required|numeric|min:0',
            'MSRP'               => 'required|numeric|min:0',
        ]);
        DB::table('products')->insert($data);
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = DB::table('products')
            ->join('productlines', 'products.productLine', '=', 'productlines.productLine')
            ->select('products.*', 'productlines.textDescription')
            ->where('products.productCode', $id)->first();
        if (!$product) abort(404);

        $salesHistory = DB::table('orderdetails')
            ->join('orders', 'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->where('orderdetails.productCode', $id)
            ->where('orders.status', '!=', 'Cancelled')
            ->select(DB::raw('DATE_FORMAT(orders.orderDate,"%Y-%m") as period'), DB::raw('SUM(orderdetails.quantityOrdered) as qty'), DB::raw('SUM(orderdetails.quantityOrdered * orderdetails.priceEach) as revenue'))
            ->groupBy('period')->orderBy('period')->get();

        $totalSold    = $salesHistory->sum('qty');
        $totalRevenue = $salesHistory->sum('revenue');
        return view('products.show', compact('product', 'salesHistory', 'totalSold', 'totalRevenue'));
    }

    public function edit($id)
    {
        $product      = DB::table('products')->where('productCode', $id)->first();
        if (!$product) abort(404);
        $productLines = DB::table('productlines')->pluck('productLine');
        return view('products.edit', compact('product', 'productLines'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'productName'        => 'required|string|max:70',
            'productLine'        => 'required|string|max:50',
            'productScale'       => 'nullable|string|max:10',
            'productVendor'      => 'nullable|string|max:50',
            'productDescription' => 'nullable|string',
            'quantityInStock'    => 'required|integer|min:0',
            'buyPrice'           => 'required|numeric|min:0',
            'MSRP'               => 'required|numeric|min:0',
        ]);
        DB::table('products')->where('productCode', $id)->update($data);
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('products')->where('productCode', $id)->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
