<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query  = DB::table('employees')
            ->join('offices', 'employees.officeCode', '=', 'offices.officeCode')
            ->leftJoin('employees as mgr', 'employees.reportsTo', '=', 'mgr.employeeNumber')
            ->select('employees.*', 'offices.city as officeName',
                DB::raw("CONCAT(mgr.firstName,' ',mgr.lastName) as manager_name"));
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('employees.firstName', 'like', "%$search%")
                  ->orWhere('employees.lastName', 'like', "%$search%")
                  ->orWhere('employees.email', 'like', "%$search%")
                  ->orWhere('employees.jobTitle', 'like', "%$search%");
            });
        }
        $employees = $query->orderBy('employees.lastName')->paginate(15)->withQueryString();
        return view('employees.index', compact('employees', 'search'));
    }

    public function create()
    {
        $offices   = DB::table('offices')->orderBy('city')->get();
        $managers  = DB::table('employees')->orderBy('lastName')->get();
        return view('employees.create', compact('offices', 'managers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employeeNumber' => 'required|integer|unique:employees,employeeNumber',
            'lastName'       => 'required|string|max:50',
            'firstName'      => 'required|string|max:50',
            'extension'      => 'nullable|string|max:10',
            'email'          => 'required|email|max:100',
            'officeCode'     => 'required|string|exists:offices,officeCode',
            'reportsTo'      => 'nullable|integer',
            'jobTitle'       => 'nullable|string|max:50',
        ]);
        DB::table('employees')->insert($data);
        return redirect()->route('employees.index')->with('success', 'Employee created.');
    }

    public function show($id)
    {
        $employee = DB::table('employees')
            ->join('offices', 'employees.officeCode', '=', 'offices.officeCode')
            ->select('employees.*', 'offices.city as officeName', 'offices.country')
            ->where('employees.employeeNumber', $id)->first();
        if (!$employee) abort(404);

        $customers = DB::table('customers')
            ->where('salesRepEmployeeNumber', $id)->get();

        $revenue = DB::table('orderdetails')
            ->join('orders',    'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->join('customers', 'orders.customerNumber',   '=', 'customers.customerNumber')
            ->where('customers.salesRepEmployeeNumber', $id)
            ->where('orders.status', '!=', 'Cancelled')
            ->sum(DB::raw('orderdetails.quantityOrdered * orderdetails.priceEach'));

        return view('employees.show', compact('employee', 'customers', 'revenue'));
    }

    public function edit($id)
    {
        $employee = DB::table('employees')->where('employeeNumber', $id)->first();
        if (!$employee) abort(404);
        $offices  = DB::table('offices')->orderBy('city')->get();
        $managers = DB::table('employees')->orderBy('lastName')->get();
        return view('employees.edit', compact('employee', 'offices', 'managers'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'lastName'   => 'required|string|max:50',
            'firstName'  => 'required|string|max:50',
            'extension'  => 'nullable|string|max:10',
            'email'      => 'required|email|max:100',
            'officeCode' => 'required|string|exists:offices,officeCode',
            'reportsTo'  => 'nullable|integer',
            'jobTitle'   => 'nullable|string|max:50',
        ]);
        DB::table('employees')->where('employeeNumber', $id)->update($data);
        return redirect()->route('employees.index')->with('success', 'Employee updated.');
    }

    public function destroy($id)
    {
        DB::table('employees')->where('employeeNumber', $id)->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted.');
    }
}
