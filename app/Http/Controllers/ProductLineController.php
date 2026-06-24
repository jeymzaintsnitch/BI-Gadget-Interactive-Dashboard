<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductLineController extends Controller
{
    public function index()
    {
        $lines = DB::table('productlines')
            ->select('productlines.*',
                DB::raw('(SELECT COUNT(*) FROM products WHERE products.productLine = productlines.productLine) as product_count'))
            ->get();
        return view('productlines.index', compact('lines'));
    }

    public function create()
    {
        return view('productlines.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'productLine'     => 'required|string|max:50|unique:productlines,productLine',
            'textDescription' => 'nullable|string|max:4000',
        ]);
        DB::table('productlines')->insert($data);
        return redirect()->route('product-lines.index')->with('success', 'Product line created.');
    }

    public function show($id)
    {
        $line     = DB::table('productlines')->where('productLine', $id)->first();
        if (!$line) abort(404);
        $products = DB::table('products')->where('productLine', $id)->get();
        $revenue  = DB::table('orderdetails')
            ->join('orders',   'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->join('products', 'orderdetails.productCode', '=', 'products.productCode')
            ->where('products.productLine', $id)
            ->where('orders.status', '!=', 'Cancelled')
            ->sum(DB::raw('orderdetails.quantityOrdered * orderdetails.priceEach'));
        return view('productlines.show', compact('line', 'products', 'revenue'));
    }

    public function edit($id)
    {
        $line = DB::table('productlines')->where('productLine', $id)->first();
        if (!$line) abort(404);
        return view('productlines.edit', compact('line'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['textDescription' => 'nullable|string|max:4000']);
        DB::table('productlines')->where('productLine', $id)->update($data);
        return redirect()->route('product-lines.index')->with('success', 'Product line updated.');
    }

    public function destroy($id)
    {
        DB::table('productlines')->where('productLine', $id)->delete();
        return redirect()->route('product-lines.index')->with('success', 'Product line deleted.');
    }
}
