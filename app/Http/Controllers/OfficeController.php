<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query  = DB::table('offices');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('city', 'like', "%$search%")
                  ->orWhere('country', 'like', "%$search%")
                  ->orWhere('territory', 'like', "%$search%");
            });
        }
        $offices = $query->orderBy('city')->paginate(15)->withQueryString();
        return view('offices.index', compact('offices', 'search'));
    }

    public function create()
    {
        return view('offices.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'officeCode'   => 'required|string|max:10|unique:offices,officeCode',
            'city'         => 'required|string|max:50',
            'phone'        => 'nullable|string|max:50',
            'addressLine1' => 'nullable|string|max:50',
            'addressLine2' => 'nullable|string|max:50',
            'state'        => 'nullable|string|max:50',
            'country'      => 'nullable|string|max:50',
            'postalCode'   => 'nullable|string|max:15',
            'territory'    => 'nullable|string|max:10',
        ]);
        DB::table('offices')->insert($data);
        return redirect()->route('offices.index')->with('success', 'Office created.');
    }

    public function show($id)
    {
        $office    = DB::table('offices')->where('officeCode', $id)->first();
        if (!$office) abort(404);
        $employees = DB::table('employees')->where('officeCode', $id)->get();
        $revenue   = DB::table('orderdetails')
            ->join('orders',    'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->join('customers', 'orders.customerNumber',   '=', 'customers.customerNumber')
            ->join('employees', 'customers.salesRepEmployeeNumber', '=', 'employees.employeeNumber')
            ->where('employees.officeCode', $id)
            ->where('orders.status', '!=', 'Cancelled')
            ->sum(DB::raw('orderdetails.quantityOrdered * orderdetails.priceEach'));
        return view('offices.show', compact('office', 'employees', 'revenue'));
    }

    public function edit($id)
    {
        $office = DB::table('offices')->where('officeCode', $id)->first();
        if (!$office) abort(404);
        return view('offices.edit', compact('office'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'city'         => 'required|string|max:50',
            'phone'        => 'nullable|string|max:50',
            'addressLine1' => 'nullable|string|max:50',
            'addressLine2' => 'nullable|string|max:50',
            'state'        => 'nullable|string|max:50',
            'country'      => 'nullable|string|max:50',
            'postalCode'   => 'nullable|string|max:15',
            'territory'    => 'nullable|string|max:10',
        ]);
        DB::table('offices')->where('officeCode', $id)->update($data);
        return redirect()->route('offices.index')->with('success', 'Office updated.');
    }

    public function destroy($id)
    {
        DB::table('offices')->where('officeCode', $id)->delete();
        return redirect()->route('offices.index')->with('success', 'Office deleted.');
    }
}
