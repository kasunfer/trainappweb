<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BookingExport;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function booking(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('query');
            $bookings = Booking::paginate(config('default_pagination'));
            return view('admin.booking.filter', compact('bookings'))->render();
        } else {
            $bookings = Booking::paginate(config('default_pagination'));
        }
        return view('admin.report.booking', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function export_pdf()
    {
        $bookings = Booking::all();
        $orientation='portrait';
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf = PDF::loadView('admin.report.bookings_pdf', compact('bookings'))->setPaper('a4', $orientation);
        return $pdf->stream('booking-report.pdf');
    }
    public function export_excel()
    {
        $bookings = Booking::all();
        return Excel::download(new BookingExport($bookings), 'booking.xlsx');

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
