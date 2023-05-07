<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use PhpParser\Node\Stmt\TryCatch;
use DB;

class PermissionController extends Controller
{
    public function __construct()
    {

        $this->middleware('role:Super-Admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = Permission::all();
        if ($request->ajax()) {
            return response()->json([
                'permissions' => $permissions,
            ]);
        }
        return view('admin.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.permissions.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions',
        ]);
        Permission::Create(
            [
                'name' => $request->name,
            ]
        );

        $notification = array(
            'message' => 'Permission added successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.permissions.index')
            ->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.permissions.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return redirect()->route('admin.permissions.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                Rule::unique('permissions', 'name')->ignore($id)
            ]
        ]);
        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table("permissions")->where('id', $id)->delete();
        return response()->json([
            'message' => 'Record deleted successfully!'
        ]);
        /* $notification = array(            
        'message' => 'Permissions deleted successfully',
        'alert-type' => 'success'            
        );
        return redirect()->route('admin.permissions.index')
        ->with($notification); */
    }
}