<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class TicketVerifyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-ticket-verifying')->only(['index', 'show']);
        $this->middleware('permission:able-ticket-verifying')->only(['verifyTicket', 'updateVerification']);
    }
    public function index()
    {
        return view('admin.ticketVerify.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function verifyTicket($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        return response()->json([
            'id' => $booking->id,
            'phone_number' => $booking->phone_number,
            'fromStation' => $booking->fromStation->name,
            'toStation' => $booking->toStation->name,
            'train' => $booking->trainSchedule->train->name,
            'seat' => $booking->seat->seat_number,
            'date' => $booking->trainSchedule->departure_time,
            'verified' => $booking->verified
        ]);
    }

    public function updateVerification(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        $booking->verified = true;
        $booking->save();

        return response()->json(['message' => 'Ticket verified successfully']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
