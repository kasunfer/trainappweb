<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-stations')->only(['index', 'show']);
        $this->middleware('permission:create-stations')->only(['create', 'store']);
        $this->middleware('permission:delete-stations')->only(['destroy']);
        $this->middleware('permission:edit-stations')->only(['edit', 'update']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('query');
            $stations = Station::paginate(config('default_pagination'));
            return view('admin.stations.filter', compact('stations'))->render();
        } else {
            $stations = Station::paginate(config('default_pagination'));
        }
        return view('admin.stations.index', compact('stations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.stations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:stations,name',
                'city' => 'required',
            ],
            [
                'name.required' => 'Station Name is Required',
                'city.required' => 'Station City is Required',
                'name.unique' => 'Name has already been taken',
            ]
        );
        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
            try {
                DB::beginTransaction();
    
                $station = new Station();
                $station->name = $request->name;
                $station->city = $request->city;
                $station->save();
                DB::commit();
                return response()->json(['success' => 'Station created successfully!', 'action' => $request->action]);
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
        $station = Station::find($id);
        return view('admin.stations.edit', compact('station'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'city' => 'required',
                'name' => 'required|unique:stations,name,' . $id,
            ],
            [
                'city.required' => 'City is Required',
                'name.required' => 'Name is Required',
                'name.unique' => 'The name has already been taken.',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            $station = Station::find($id);
            $station->name = $request->name;
            $station->city = $request->city;
            $station->save();
            DB::commit();
            return response()->json(['success' => 'Station Updated successfully!']);
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
            $station = Station::find($id);
            $station->delete();
            return response()->json(['success' => 'Station Deleted successfully!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function status(Request $request, $status)
    {
        try {
            $station = Station::find($status);
            $station->status = $request->isActive == 'true' ? true : false;
            $station->save();
            return response()->json(['success' => 'Updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
