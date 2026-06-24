<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = DB::table('roles')
            ->select('roles.*', DB::raw('(SELECT COUNT(*) FROM users WHERE users.role_id = roles.id) as user_count'))
            ->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:50|unique:roles,name',
            'description' => 'nullable|string|max:255',
        ]);
        DB::table('roles')->insert($data);
        return redirect()->route('roles.index')->with('success', 'Role created.');
    }

    public function show($id)
    {
        $role  = DB::table('roles')->where('id', $id)->first();
        if (!$role) abort(404);
        $users = DB::table('users')->where('role_id', $id)->get();
        return view('roles.show', compact('role', 'users'));
    }

    public function edit($id)
    {
        $role = DB::table('roles')->where('id', $id)->first();
        if (!$role) abort(404);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'        => "required|string|max:50|unique:roles,name,$id",
            'description' => 'nullable|string|max:255',
        ]);
        DB::table('roles')->where('id', $id)->update($data);
        return redirect()->route('roles.index')->with('success', 'Role updated.');
    }

    public function destroy($id)
    {
        if (DB::table('users')->where('role_id', $id)->exists()) {
            return back()->with('error', 'Cannot delete role: users are assigned to it.');
        }
        DB::table('roles')->where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted.');
    }
}
