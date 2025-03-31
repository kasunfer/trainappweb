<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Train;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-trains')->only(['index', 'show']);
        $this->middleware('permission:create-trains')->only(['create', 'store']);
        $this->middleware('permission:delete-trains')->only(['destroy']);
        $this->middleware('permission:edit-trains')->only(['edit', 'update']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('query');
            $trains = Train::paginate(config('default_pagination'));
            return view('admin.trains.filter', compact('trains'))->render();
        } else {
            $trains = Train::paginate(config('default_pagination'));
        }
        return view('admin.trains.index', compact('trains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.trains.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:trains,name',
                'code' => 'required|unique:trains,code',
            ],
            [
                'name.required' => 'Train Name is Required',
                'code.required' => 'Train Code is Required',
                'name.unique' => 'Name has already been taken',
                'code.unique' => 'Code has already been taken',
            ]
        );
        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
            try {
                DB::beginTransaction();
    
                $train = new Train();
                $train->name = $request->name;
                $train->code = $request->code;
                $train->save();
                DB::commit();
                return response()->json(['success' => 'Train created successfully!', 'action' => $request->action]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(['error' => 'Failed to create user in tenant DB. ' . $th->getMessage()], 500);
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
        $train = Train::find($id);
        return view('admin.trains.edit', compact('train'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'required|unique:trains,code,' . $id,
                'name' => 'required|unique:trains,name,' . $id,
            ],
            [
                'code.required' => 'Code is Required',
                'name.required' => 'Name is Required',
                'code.unique' => 'The code has already been taken.',
                'name.unique' => 'The name has already been taken.',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            $train = Train::find($id);
            $train->name = $request->name;
            $train->code = $request->code;
            $train->save();
            DB::commit();
            return response()->json(['success' => 'Train Updated successfully!']);
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
            $train = Train::find($id);
            $train->delete();
            return response()->json(['success' => 'Train Deleted successfully!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function status(Request $request, $status)
    {
        try {
            $train = Train::find($status);
            $train->status = $request->isActive == 'true' ? true : false;
            $train->save();
            return response()->json(['success' => 'Updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
