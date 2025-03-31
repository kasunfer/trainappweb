<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\RouteFee;
use App\Models\Station;
use App\Models\TrainSchedule;
use App\Models\TrainSeat;
use App\Models\TrainStop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-booking')->only(['index', 'show']);
        $this->middleware('permission:create-booking')->only(['create', 'store']);
        $this->middleware('permission:delete-booking')->only(['destroy']);
        $this->middleware('permission:edit-booking')->only(['edit', 'update']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('query');
            $bookings = Booking::paginate(config('default_pagination'));
            return view('admin.booking.filter', compact('bookings'))->render();
        } else {
            $bookings = Booking::paginate(config('default_pagination'));
        }
        return view('admin.booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schedules = TrainSchedule::all();
        $availableSeats = TrainSeat::where('is_booked', false)->get();
        $stations = Station::all();

        // Return the Blade view and pass the data
        return view('admin.booking.create', compact('schedules', 'availableSeats', 'stations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'schedule_id' => 'required|exists:train_schedules,id',
            'seats' => 'required|array',
            // 'seats.*' => 'exists:train_seats,id',
            'from_station_id' => 'required|exists:stations,id',
            'to_station_id' => 'required|exists:stations,id',
        ]);

        $trainSchedule = TrainSchedule::find($request->schedule_id);
        if (!$trainSchedule) {
            return response()->json(['message' => 'Invalid schedule ID.'], 400);
        }

        $bookingLimit = 5;
        $bookingId = [];
        foreach ($request->seats as $seatId) {
            if ($seatId != null) {
                $seat = TrainSeat::find($seatId);

                if (!$seat) {
                    return response()->json(['message' => "Seat ID {$seatId} not found."], 400);
                }

                if ($seat->is_booked) {
                    return response()->json(['message' => "Seat {$seat->seat_number} is already booked."], 400);
                }

                $existingBookingsCount = Booking::where('phone_number', $request->phone_number)
                    ->where('schedule_id', $trainSchedule->id)
                    ->whereDate('created_at', $trainSchedule->schedule_date)
                    ->count();
                if ($existingBookingsCount >= $bookingLimit) {
                    return response()->json(['message' => 'Booking limit reached for this phone number on this day.'], 400);
                }

                $booking = Booking::create([
                    'phone_number' => $request->phone_number,
                    'train_id' => $seat->trainSchedule->train_id,
                    'schedule_id' => $request->schedule_id,
                    'seat_id' => $seat->id,
                    'from_station_id' => $request->from_station_id,
                    'to_station_id' => $request->to_station_id,
                    'status' => 'booked',
                ]);

                $seat->update(['is_booked' => true]);
                $bookingId[] = $booking->id;
                Log::info("Seat {$seat->seat_number} booked successfully.");
            }
        }

        return response()->json(['message' => 'Seats booked successfully.', 'bookingIds' => $bookingId], 200);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found.'], 404);
        }
        $seat = TrainSeat::find($booking->seat_id);
        if (!$seat) {
            return response()->json(['message' => 'Seat not found.'], 404);
        }
        $seat->update(['is_booked' => false]);
        $booking->delete();
        return response()->json(['message' => 'Booking deleted and seat released successfully.']);
    }
    public function getSchedulesByDate(Request $request)
    {
        $schedules = TrainSchedule::where('schedule_date', $request->date)->get();
        return response()->json(['schedules' => $schedules]);
    }

    public function getStationsBySchedule(Request $request)
    {
        $stations = TrainStop::where('train_schedule_id', $request->schedule_id)->get();
        return response()->json(['stations' => $stations]);
    }

    public function getSeatsByScheduleAndStations(Request $request)
    {
        $scheduleId = $request->schedule_id;
        $fromStationId = $request->from_station_id;
        $toStationId = $request->to_station_id;

        $allSeats = TrainSeat::where('train_schedule_id', $scheduleId)->get();

        $bookedSeats = TrainSeat::where('train_schedule_id', $scheduleId)
            ->whereHas('bookings', function ($query) use ($fromStationId, $toStationId) {
                $query->where('from_station_id', '<=', $toStationId)
                    ->where('to_station_id', '>=', $fromStationId);
            })
            ->pluck('id')
            ->toArray();
        $ticketPrice = $this->getTicketPrice($fromStationId, $toStationId);
        if (!$ticketPrice) {
            return response()->json(['error' => 'No route fee found for this route.'], 404);
        }
        return response()->json([
            'seats' => $allSeats,
            'booked_seat_ids' => $bookedSeats,
            'price' => $ticketPrice
        ]);
    }
    private function getTicketPrice($from_station_id, $to_station_id)
    {
        $totalFare = 0;
        $currentStation = $from_station_id;

        while ($currentStation != $to_station_id) {
            $nextRoute = RouteFee::where('from_station_id', $currentStation)
                ->where('to_station_id', '<=', $to_station_id)
                ->orderBy('to_station_id')
                ->first();

            if (!$nextRoute) {
                return null;
            }

            $totalFare += $nextRoute->ticket_price;
            $currentStation = $nextRoute->to_station_id;
        }

        return $totalFare;
    }
}
