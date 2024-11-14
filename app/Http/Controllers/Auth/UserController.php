<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $name = Auth::user()->name;
        return view('admin.auth.user.index', compact('users', 'name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.auth.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return redirect()->route('user.index')->with('status', 'Thêm người dùng thành công!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra, vui lòng thử lại.']);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function phanvaitro($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $permission = Permission::all();
        $all_colum_roles = $user->roles()->first(); // Lấy vai trò hiện tại của người dùng
        return view('admin.auth.user.role.phanvaitro', compact('user', 'roles', 'all_colum_roles', 'permission'));
    }
    public function storeRole(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
        $user->syncRoles($data['role']);
        $role_id = $user->roles()->first();
        return redirect()->route('user.index');
    }
    public function phanquyen($id)
    {
        $user = User::findOrFail($id);
        $permission = Permission::all();
        $name_role = $user->roles()->first()->name;
        $get_permission_via_role = $user->getPermissionsViaRoles();
        return view('admin.auth.user.permissions.phanquyen', compact('user', 'permission', 'name_role', 'get_permission_via_role'));
    }
    public function storePermission($id, Request $request)
    {   
        $data = $request->all();
        $user = User::find($id);
        $role_id = $user->roles()->first()->id;
        $role = Role::find($role_id);
        $role->syncPermissions([$data['permissions']]);
        return redirect()->route('user.index');
    }
    public function createRole()
    {
        $users = User::paginate(10);
        return view('admin.auth.user.role.phanvaitro', compact('users'));
    }
    public function storeRoles(Request $request)
    {
        $data = $request->all();
        Role::create(['name' => $data['role']]);
        return redirect()->back();
    }
    public function createPermisstions()
    {
        $users = User::paginate(10);
        return view('admin.auth.user.role.phanvaitro', compact('users'));
    }
    public function Permissions(Request $request)
    {
        $data = $request->all();
        Permission::create(['name' => $data['permission']]);
        return redirect()->back();
    }
    // public function impersonate($id)
    // {
    //     $user = User::find($id);
    //     if ($user) {
    //         Session::put('impersonate', $user->id);
    //         Auth::loginUsingId($user->id);
    //     }
    //     return redirect()->route('nhanvien');
    // }
    // public function revertImpersonation()
    // {
    //     if (Session::has('impersonate')) {
    //         Session::forget('impersonate');
    //         Auth::loginUsingId(2);
    //     }
    //     return redirect()->route('home'); 
    // }
}
