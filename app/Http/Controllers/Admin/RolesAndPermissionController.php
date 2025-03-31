<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RolesAndPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-roles')->only(['index', 'show']);
        $this->middleware('permission:create-roles')->only(['create', 'store']);
        $this->middleware('permission:delete-roles')->only(['destroy']);
        $this->middleware('permission:edit-roles')->only(['edit', 'update']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('query');
            $roles=Role::with('permissions')->paginate(config('default_pagination'));
            return view('admin.roles.filter', compact('roles'))->render();
        }else{
            $roles=Role::with('permissions')->paginate(config('default_pagination'));
        }
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissionGroups=PermissionGroup::all();
        return view('admin.roles.create',compact('permissionGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'rolename' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('roles', 'name')->where(function ($query) use ($request) {
                        return $query->where('name', $request->input('rolename'));
                    }),
                ],
                'permission_id' => 'required|array',
            ],
            [
                'rolename.required' => 'Role Name is Required',
                'rolename.unique' => 'This role name already exists.',
                'permission_id.required' => 'Permissions are Required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            DB::beginTransaction();
            $role = new Role();
            $role->name = $request->rolename;
            $role->save();
    
            $role->syncPermissions($request->permission_id);
            DB::commit();
    
            return response()->json(['success' => 'Role created successfully!','action'=>$request->action]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Something Went Wrong!'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role=Role::with('permissions')->find($id);
        $permissionGroups=PermissionGroup::all();
        return view('admin.roles.edit',compact('role','permissionGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'rolename' => 'required|string|max:255',
            'permission_id' => 'nullable|array',
        ], [
            'rolename.required' => 'Role Name is Required',
            'permission_id.array' => 'Permissions should be an array',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            DB::beginTransaction();
            $role = Role::findOrFail($id);
            $role->name = $request->rolename;
            $role->save();
            if ($request->has('permission_id')) {
                $role->syncPermissions($request->permission_id);
            }
    
            DB::commit();
            return response()->json(['message' => 'Role updated successfully']);
    
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::findOrFail($id);
            // $deletedRole = clone $role;
            $role->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Role and Permission Deleted Successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $th->getMessage(),
            ], 500);
        }
    }
}
