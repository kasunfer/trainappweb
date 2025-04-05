<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
        $bookings = Booking::whereBetween('created_at', [$startOfMonth, $endOfMonth])->selectRaw('DATE(created_at) as date, count(*) as count')
                            ->groupBy('date')->orderBy('date')->get();
    
        $days = [];
        $counts = [];
        $currentDate = Carbon::now()->startOfMonth();
        foreach ($bookings as $booking) {
            $days[] = Carbon::parse($booking->date)->format('d');
            $counts[] = $booking->count;
        }
        while ($currentDate->format('Y-m-d') <= Carbon::now()->endOfMonth()->format('Y-m-d')) {
            $day = $currentDate->format('d');
            if (!in_array($day, $days)) {
                $days[] = $day;
                $counts[] = 0;
            }
            $currentDate->addDay();
        }
        $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d');
        $endOfYear = Carbon::now()->endOfYear()->format('Y-m-d');
        $yearBookings = Booking::whereBetween('created_at', [$startOfYear, $endOfYear])->selectRaw('MONTH(created_at) as month, count(*) as count')->groupBy('month')->orderBy('month')->get();
    
        $months = [];
        $yearcounts = [];
        $currentMonth = Carbon::now()->startOfYear();
        foreach ($yearBookings as $booking) {
            $monthDate = Carbon::createFromFormat('Y-m-d', Carbon::now()->year . '-' . str_pad($booking->month, 2, '0', STR_PAD_LEFT) . '-01');
            $months[] = $monthDate->format('F');
            $yearcounts[] = $booking->count;
        }
        while ($currentMonth->format('Y-m') <= Carbon::now()->endOfYear()->format('Y-m')) {
            $month = $currentMonth->format('F');
            if (!in_array($month, $months)) {
                $months[] = $month;
                $yearcounts[] = 0;
            }
            $currentMonth->addMonth();
        }
    
    
        return view('admin.dashboard',compact('days','counts','months','yearcounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
