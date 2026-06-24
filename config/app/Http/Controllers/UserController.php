<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->orderBy('users.name')->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = DB::table('roles')->orderBy('name')->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id'  => 'required|integer|exists:roles,id',
        ]);
        $data['password'] = Hash::make($data['password']);
        DB::table('users')->insert($data);
        return redirect()->route('users.index')->with('success', 'User created.');
    }

    public function show($id)
    {
        $user = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->where('users.id', $id)->first();
        if (!$user) abort(404);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user  = DB::table('users')->where('id', $id)->first();
        if (!$user) abort(404);
        $roles = DB::table('roles')->orderBy('name')->get();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => "required|email|unique:users,email,$id",
            'role_id'  => 'required|integer|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if (empty($data['password'])) unset($data['password']);
        else $data['password'] = Hash::make($data['password']);
        DB::table('users')->where('id', $id)->update($data);
        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    public function destroy($id)
    {
        if ($id == session('user_id')) return back()->with('error', 'You cannot delete yourself.');
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
}
