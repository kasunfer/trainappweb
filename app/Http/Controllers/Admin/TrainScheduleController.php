<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RouteFee;
use App\Models\Station;
use App\Models\Train;
use App\Models\TrainSchedule;
use App\Models\TrainSeat;
use App\Models\TrainStop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrainScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-trains-schedules')->only(['index', 'show']);
        $this->middleware('permission:create-trains-schedules')->only(['create', 'store']);
        $this->middleware('permission:delete-trains-schedules')->only(['destroy']);
        $this->middleware('permission:edit-trains-schedules')->only(['edit', 'update']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('query');
            $train_schedules = TrainSchedule::with('train')->paginate(config('default_pagination'));
            return view('admin.schedules.filter', compact('train_schedules'))->render();
        } else {
            $train_schedules = TrainSchedule::with('train')->paginate(config('default_pagination'));
        }
        return view('admin.schedules.index', compact('train_schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trains = Train::all();
        $stations=Station::all();
        return view('admin.schedules.create', compact('trains','stations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'train_id' => 'required|exists:trains,id',
                'date' => 'required|date',
                'departure_time' => 'required',
                'seats' => 'required|integer|min:1',
                'stops' => 'required|array',
                'stops.*.station_id' => 'required|exists:stations,id',
                'stops.*.arrival_time' => 'required',
                'stops.*.departure_time' => 'required',
            ],
            [
                'train_id.required' => 'Please select a train.',
                'train_id.exists' => 'The selected train does not exist.',
                'date.required' => 'Please enter the schedule date.',
                'date.date' => 'Invalid date format.',
                'departure_time.required' => 'Please enter the departure time.',
                'seats.required' => 'Please enter the number of seats.',
                'seats.integer' => 'Seats must be a valid number.',
                'seats.min' => 'Seats must be at least 1.',
                'stops.required' => 'Please add at least one stop.',
                'stops.array' => 'Stops should be in an array format.',
                'stops.*.station_id.required' => 'Each stop must have a station.',
                'stops.*.station_id.exists' => 'One or more selected stations do not exist.',
                'stops.*.arrival_time.required' => 'Each stop must have an arrival time.',
                'stops.*.departure_time.required' => 'Each stop must have a departure time.',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            DB::beginTransaction();

            $TrainSchedule = new TrainSchedule();
            $TrainSchedule->train_id = $request->train_id;
            $TrainSchedule->schedule_date = $request->date;
            $TrainSchedule->departure_time = $request->departure_time;
            $TrainSchedule->save();
          
            DB::commit();
            for ($i = 1; $i <= $request->seats; $i++) {
                TrainSeat::create([
                    'train_schedule_id' => $TrainSchedule->id,
                    'seat_number' => $i,
                    'is_booked' => false,
                ]);
            }

            // Add Stops
            foreach ($request->stops as $stop) {
                TrainStop::create([
                    'train_schedule_id' => $TrainSchedule->id,
                    'station_id' => $stop['station_id'],
                    'arrival_time' => $stop['arrival_time'],
                    'departure_time' => $stop['departure_time'],
                ]);
            }
            return response()->json(['success' => 'Train Schedule created successfully!', 'action' => $request->action]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to createTrain Schedule. ' . $th->getMessage()], 500);
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
        $schedule=TrainSchedule::find($id);
        $trains = Train::all();
        $stations=Station::all();
        return view('admin.schedules.edit', compact('trains','stations','schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $validator = Validator::make(
        $request->all(),
        [
            'train_id' => 'required|exists:trains,id',
            'date' => 'required|date',
            'departure_time' => 'required',
            'seats' => 'required|integer|min:1',
            'stops' => 'required|array',
            'stops.*.station_id' => 'required|exists:stations,id',
            'stops.*.arrival_time' => 'required',
            'stops.*.departure_time' => 'required',
        ],
        [
            'train_id.required' => 'Please select a train.',
            'train_id.exists' => 'The selected train does not exist.',
            'date.required' => 'Please enter the schedule date.',
            'date.date' => 'Invalid date format.',
            'departure_time.required' => 'Please enter the departure time.',
            'seats.required' => 'Please enter the number of seats.',
            'seats.integer' => 'Seats must be a valid number.',
            'seats.min' => 'Seats must be at least 1.',
            'stops.required' => 'Please add at least one stop.',
            'stops.array' => 'Stops should be in an array format.',
            'stops.*.station_id.required' => 'Each stop must have a station.',
            'stops.*.station_id.exists' => 'One or more selected stations do not exist.',
            'stops.*.arrival_time.required' => 'Each stop must have an arrival time.',
            'stops.*.departure_time.required' => 'Each stop must have a departure time.',
        ]
    );

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        DB::beginTransaction();

        $TrainSchedule = TrainSchedule::findOrFail($id);
        $TrainSchedule->train_id = $request->train_id;
        $TrainSchedule->schedule_date = $request->date;
        $TrainSchedule->departure_time = $request->departure_time;
        $TrainSchedule->save();

        $existingSeats = $TrainSchedule->seats()->count();
        if ($request->seats > $existingSeats) {
            for ($i = $existingSeats + 1; $i <= $request->seats; $i++) {
                TrainSeat::create([
                    'train_schedule_id' => $TrainSchedule->id,
                    'seat_number' => $i,
                    'is_booked' => false,
                ]);
            }
        } elseif ($request->seats < $existingSeats) {
            TrainSeat::where('train_schedule_id', $TrainSchedule->id)
                ->where('seat_number', '>', $request->seats)
                ->delete();
        }

        TrainStop::where('train_schedule_id', $TrainSchedule->id)->delete();
        foreach ($request->stops as $stop) {
            TrainStop::create([
                'train_schedule_id' => $TrainSchedule->id,
                'station_id' => $stop['station_id'],
                'arrival_time' => $stop['arrival_time'],
                'departure_time' => $stop['departure_time'],
            ]);
        }

        DB::commit();
        return response()->json(['success' => 'Train Schedule updated successfully!', 'action' => $request->action]);
    } catch (\Throwable $th) {
        DB::rollBack();
        return response()->json(['error' => 'Failed to update Train Schedule. ' . $th->getMessage()], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
    
            $TrainSchedule = TrainSchedule::findOrFail($id);
            TrainSeat::where('train_schedule_id', $TrainSchedule->id)->delete();
            TrainStop::where('train_schedule_id', $TrainSchedule->id)->delete();
            $TrainSchedule->delete();
            DB::commit();
            return response()->json(['success' => 'Train Schedule deleted successfully!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete Train Schedule. ' . $th->getMessage()], 500);
        }
    }
   
}
