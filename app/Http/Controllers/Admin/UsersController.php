<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-user')->only(['index', 'show']);
        $this->middleware('permission:create-user')->only(['create', 'store']);
        $this->middleware('permission:delete-user')->only(['destroy']);
        $this->middleware('permission:edit-user')->only(['edit', 'update', 'status']);
        $this->middleware('permission:view-active-users')->only(['ActiveUsers']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('query');
            $users = User::paginate(config('default_pagination'));
            return view('admin.users.filter', compact('users'))->render();
        } else {
            $users = User::paginate(config('default_pagination'));
        }
        return view('admin.users.index', compact('users'));
    }

    public function profile(Request $request)
    {
        return view('admin.users.profile');
    }

    public function PasswordReset(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $validator = Validator::make(
            $request->all(),
            [
                'previous_password' => 'required',
                'password' => 'min:8|required|same:confirm_password',
                'confirm_password' => 'required|min:8'
            ],
            [
                'previous_password.required' => 'Previous password cannot be empty',
                'password.same' => 'Password and confirm password must same',
                'password.min' => 'Password minimum 8 character',
                'confirm_password.min' => 'Confirm password minimum 8 character',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        if (Hash::check($request->previous_password, $user->password)) {
            $user->fill([
                'password' => $request->password
            ])->save();
            return response()->json(['success' => 'User Password Updated successfully!']);
        } else {
            return response()->json(['error' => 'Password mismatch please try again.'], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $maxId = User::max('id');
        $maxId = $maxId == "" || $maxId == null ? "U100" : ("U" . (100 + $maxId + 1));
        return view('admin.users.create', compact('roles','maxId'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validator = Validator::make(
        $request->all(),
        [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'password' => 'required',
        ],
        [
            'username.required' => 'User Name is Required',
            'role.required' => 'Role is Required',
            'password.required' => 'Password is Required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email has already been taken',
        ]
    );

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
        try {
            DB::beginTransaction();

            $user = new User();
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->username = $request->username;
            $user->nic = $request->nic;
            $user->code = $request->code;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->photo=Helper::image_upload('users',$request->dp);
            $user->added_by = Auth::user()->id;
            $user->password = Hash::make($request->password);
            $user->save();
            $user->assignRole($request->role);
            DB::commit();
            return response()->json(['success' => 'User created successfully!', 'action' => $request->action]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create user in tenant DB. ' . $th->getMessage()], 500);
        }
    
}


    /**
     * Display the specified resource.
     */
    public function status(Request $request, $status)
    {
        try {
            $user = User::find($status);
            $user->is_active = $request->isActive == 'true' ? true : false;
            $user->save();
            return response()->json(['success' => 'Updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('roles','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'role' => 'required',
            ],
            [
                'username.required' => 'User Name is Required',
                'role.required' => 'Role is Required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            $user = User::find($id);
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->username = $request->username;
            $user->nic = $request->nic;
            $user->code = $request->code;
            $user->email = $request->email;
            $user->contact = $request->contact;

            if ($request->input('remove_image') == "1") {
                if ($user->photo) {
                    Helper::delete_image($user->photo);
                }
                $user->photo = null;
            }
        
            if ($request->hasFile('image')) {
                if ($user->photo) {
                    Helper::delete_image($user->photo);
                }
                $user->photo=Helper::image_upload('users', $request->image);
            }
            $user->save();
            $user->roles()->detach();
            $user->assignRole($request->role);
            DB::commit();
            return response()->json(['success' => 'User Updated successfully!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $user = User::find($id);
            $user2 = clone $user;
            $user->delete();
            return response()->json(['success' => 'User Deleted successfully!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function ActiveUsers(Request $request)
    {
        $activeUsers = User::where('last_login', '>=', Carbon::now()->subDays(30))
            ->where(function ($query) {
                $query->whereNull('last_logout')
                    ->orWhereColumn('last_login', '>', 'last_logout');
            })
            ->where('last_activity', '>=', Carbon::now()->subMinutes(5))
            ->get();
        return view('users.activeUsers', compact('activeUsers'));
    }
}
