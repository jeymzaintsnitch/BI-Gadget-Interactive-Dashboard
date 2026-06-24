<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query  = DB::table('payments')
            ->join('customers', 'payments.customerNumber', '=', 'customers.customerNumber')
            ->select('payments.*', 'customers.customerName');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('customers.customerName', 'like', "%$search%")
                  ->orWhere('payments.checkNumber', 'like', "%$search%");
            });
        }
        $payments = $query->orderByDesc('payments.paymentDate')->paginate(20)->withQueryString();
        return view('payments.index', compact('payments', 'search'));
    }

    public function create()
    {
        $customers = DB::table('customers')->orderBy('customerName')->get();
        return view('payments.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customerNumber' => 'required|integer|exists:customers,customerNumber',
            'checkNumber'    => 'required|string|max:50',
            'paymentDate'    => 'required|date',
            'amount'         => 'required|numeric|min:0',
        ]);
        DB::table('payments')->insert($data);
        return redirect()->route('payments.index')->with('success', 'Payment recorded.');
    }

    public function show($customerNumber, $checkNumber = null)
    {
        // Support both route formats
        if (!$checkNumber && str_contains($customerNumber, '_')) {
            [$customerNumber, $checkNumber] = explode('_', $customerNumber, 2);
        }
        $payment = DB::table('payments')
            ->join('customers', 'payments.customerNumber', '=', 'customers.customerNumber')
            ->select('payments.*', 'customers.customerName')
            ->where('payments.customerNumber', $customerNumber)
            ->where('payments.checkNumber', $checkNumber ?? request('checkNumber'))
            ->first();
        if (!$payment) abort(404);
        return view('payments.show', compact('payment'));
    }

    public function edit($id)
    {
        // $id = "customerNumber_checkNumber"
        [$cn, $ck] = explode('_', $id, 2);
        $payment   = DB::table('payments')
            ->where('customerNumber', $cn)->where('checkNumber', $ck)->first();
        if (!$payment) abort(404);
        $customers = DB::table('customers')->orderBy('customerName')->get();
        return view('payments.edit', compact('payment', 'customers'));
    }

    public function update(Request $request, $id)
    {
        [$cn, $ck] = explode('_', $id, 2);
        $data = $request->validate([
            'paymentDate' => 'required|date',
            'amount'      => 'required|numeric|min:0',
        ]);
        DB::table('payments')->where('customerNumber', $cn)->where('checkNumber', $ck)->update($data);
        return redirect()->route('payments.index')->with('success', 'Payment updated.');
    }

    public function destroy($id)
    {
        [$cn, $ck] = explode('_', $id, 2);
        DB::table('payments')->where('customerNumber', $cn)->where('checkNumber', $ck)->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted.');
    }
}
