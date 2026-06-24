<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = DB::table('customers')
            ->leftJoin('employees', 'customers.salesRepEmployeeNumber', '=', 'employees.employeeNumber')
            ->select(
                'customers.*',
                DB::raw("CONCAT(employees.firstName,' ',employees.lastName) as rep_name")
            );
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('customers.customerName', 'like', "%$search%")
                  ->orWhere('customers.city', 'like', "%$search%")
                  ->orWhere('customers.country', 'like', "%$search%");
            });
        }
        $customers = $query->orderBy('customers.customerName')->paginate(15)->withQueryString();
        return view('customers.index', compact('customers', 'search'));
    }

    public function create()
    {
        $employees = DB::table('employees')->orderBy('lastName')->get();
        return view('customers.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customerNumber'         => 'required|integer|unique:customers,customerNumber',
            'customerName'           => 'required|string|max:50',
            'contactLastName'        => 'nullable|string|max:50',
            'contactFirstName'       => 'nullable|string|max:50',
            'phone'                  => 'nullable|string|max:50',
            'addressLine1'           => 'nullable|string|max:50',
            'addressLine2'           => 'nullable|string|max:50',
            'city'                   => 'nullable|string|max:50',
            'state'                  => 'nullable|string|max:50',
            'postalCode'             => 'nullable|string|max:15',
            'country'                => 'nullable|string|max:50',
            'salesRepEmployeeNumber' => 'nullable|integer',
            'creditLimit'            => 'nullable|numeric',
        ]);
        DB::table('customers')->insert($data);
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show($id)
    {
        $customer = DB::table('customers')
            ->leftJoin('employees', 'customers.salesRepEmployeeNumber', '=', 'employees.employeeNumber')
            ->select('customers.*', DB::raw("CONCAT(employees.firstName,' ',employees.lastName) as rep_name"))
            ->where('customers.customerNumber', $id)->first();
        if (!$customer) abort(404);

        $orders = DB::table('orders')
            ->where('customerNumber', $id)
            ->orderByDesc('orderDate')->get();

        $totalSpent = DB::table('orderdetails')
            ->join('orders', 'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->where('orders.customerNumber', $id)
            ->where('orders.status', '!=', 'Cancelled')
            ->sum(DB::raw('orderdetails.quantityOrdered * orderdetails.priceEach'));

        return view('customers.show', compact('customer', 'orders', 'totalSpent'));
    }

    public function edit($id)
    {
        $customer  = DB::table('customers')->where('customerNumber', $id)->first();
        if (!$customer) abort(404);
        $employees = DB::table('employees')->orderBy('lastName')->get();
        return view('customers.edit', compact('customer', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'customerName'           => 'required|string|max:50',
            'contactLastName'        => 'nullable|string|max:50',
            'contactFirstName'       => 'nullable|string|max:50',
            'phone'                  => 'nullable|string|max:50',
            'addressLine1'           => 'nullable|string|max:50',
            'addressLine2'           => 'nullable|string|max:50',
            'city'                   => 'nullable|string|max:50',
            'state'                  => 'nullable|string|max:50',
            'postalCode'             => 'nullable|string|max:15',
            'country'                => 'nullable|string|max:50',
            'salesRepEmployeeNumber' => 'nullable|integer',
            'creditLimit'            => 'nullable|numeric',
        ]);
        DB::table('customers')->where('customerNumber', $id)->update($data);
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('customers')->where('customerNumber', $id)->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted.');
    }
}
