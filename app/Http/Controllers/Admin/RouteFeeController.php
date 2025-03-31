<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RouteFee;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RouteFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-route-fee')->only(['index', 'show']);
        $this->middleware('permission:create-route-fee')->only(['create', 'store']);
        $this->middleware('permission:delete-route-fee')->only(['destroy']);
        $this->middleware('permission:edit-route-fee')->only(['edit', 'update']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('query');
            $routeFees = RouteFee::with(['fromStation', 'toStation'])->paginate(config('default_pagination'));
            return view('admin.routeFee.filter', compact('routeFees'))->render();
        } else {
            $routeFees = RouteFee::with(['fromStation', 'toStation'])->paginate(config('default_pagination'));
        }
        return view('admin.routeFee.index', compact('routeFees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = Station::all();
        return view('admin.routeFee.create', compact('stations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'from_station_id' => 'required|exists:stations,id',
                'to_station_id' => [
            'required',
            'exists:stations,id',
            'different:from_station_id',
            Rule::unique('route_fees')->where(function ($query) use ($request) {
                return $query->where('from_station_id', $request->from_station_id)
                             ->where('to_station_id', $request->to_station_id);
            }),
        ],
                'ticket_price' => 'required|numeric|min:0',
            ],
            [
                'from_station_id.required' => 'The departure station is required.',
                'from_station_id.exists' => 'The selected departure station is invalid.',
                'to_station_id.required' => 'The destination station is required.',
                'to_station_id.exists' => 'The selected destination station is invalid.',
                'to_station_id.different' => 'The destination station must be different from the departure station.',
                'ticket_price.required' => 'The ticket price is required.',
                'ticket_price.numeric' => 'The ticket price must be a number.',
                'ticket_price.min' => 'The ticket price must be at least 0.',
            ]
        );
        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
            try {
                DB::beginTransaction();
    
                $routeFee = new RouteFee();
                $routeFee->from_station_id = $request->from_station_id;
                $routeFee->to_station_id = $request->to_station_id;
                $routeFee->ticket_price = $request->ticket_price;
                $routeFee->save();
                DB::commit();
                return response()->json(['success' => 'Route Fee created successfully!', 'action' => $request->action]);
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
        $routFee=RouteFee::find($id);
        $stations=Station::all();
        return view('admin.routeFee.edit', compact('routFee','stations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'from_station_id' => 'required|exists:stations,id',
                'to_station_id' => [
                    'required',
                    'exists:stations,id',
                    'different:from_station_id',
                    Rule::unique('route_fees')->where(function ($query) use ($request, $id) {
                        return $query->where('from_station_id', $request->from_station_id)
                                     ->where('to_station_id', $request->to_station_id)
                                     ->when($id, function ($q) use ($id) {
                                         return $q->where('id', '!=', $id);
                                     });
                    }),
                ],
                'ticket_price' => 'required|numeric|min:0',
            ],
            [
                'from_station_id.required' => 'The departure station is required.',
                'from_station_id.exists' => 'The selected departure station is invalid.',
                'to_station_id.required' => 'The destination station is required.',
                'to_station_id.exists' => 'The selected destination station is invalid.',
                'to_station_id.different' => 'The destination station must be different from the departure station.',
                'to_station_id.unique' => 'The route between the selected stations already exists.', // Prevent duplicate routes
                'ticket_price.required' => 'The ticket price is required.',
                'ticket_price.numeric' => 'The ticket price must be a number.',
                'ticket_price.min' => 'The ticket price must be at least 0.',
            ]
        );
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            DB::beginTransaction();
    
            if ($id) {
                $routeFee = RouteFee::findOrFail($id);
                $message = 'Route Fee updated successfully!';
            } else {
                $routeFee = new RouteFee();
                $message = 'Route Fee created successfully!';
            }
    
            $routeFee->from_station_id = $request->from_station_id;
            $routeFee->to_station_id = $request->to_station_id;
            $routeFee->ticket_price = $request->ticket_price;
            $routeFee->save();
    
            DB::commit();
            return response()->json(['success' => $message, 'action' => $request->action]);
    
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to process request. ' . $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $routeFee = RouteFee::find($id);
            $routeFee->delete();
            return response()->json(['success' => 'Route Fee Deleted successfully!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
