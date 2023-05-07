<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(5);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd(auth()->user()->hasRole('Super-Admin'));
        die;
        if (auth()->user()->hasRole('Super-Admin')) {
            $roles = Role::pluck('name', 'name')->all();
        } else {
            $roles = Role::pluck('name', 'name')->except(['name', 'Super-Admin']);
        }
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirm-password' => 'required|same:password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        $notification = array(
            'message' => 'User created successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.users.index')
            ->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        if ($user->hasRole('Super-Admin')) {
            $notification = array(
                'message' => "You have no permission for edit this user",
                'alert-type' => 'error'
            );
            return redirect()->route('admin.users.index')
                ->with($notification);
        }
        if (auth()->user()->hasRole('Super-Admin')) {
            $roles = Role::pluck('name', 'name')->all();
        } else {
            $roles = Role::pluck('name', 'name')->except(['name', 'Super-Admin']);
        }
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        $notification = array(
            'message' => 'User updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.users.index')
            ->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (auth()->id() == $id) {
            $notification = array(
                'message' => "You cannot delete yourself",
                'alert-type' => 'error'
            );
            return redirect()->route('admin.users.index')
                ->with($notification);
        }
        if ($user->hasRole('Super-Admin')) {
            $notification = array(
                'message' => "You have no permission for delete this user",
                'alert-type' => 'error'
            );
            return redirect()->route('admin.users.index')
                ->with($notification);
        }
        $user->delete();
        $notification = array(
            'message' => "User deleted successfully",
            'alert-type' => 'success'
        );
        return redirect()->route('admin.users.index')
            ->with($notification);
    }
}