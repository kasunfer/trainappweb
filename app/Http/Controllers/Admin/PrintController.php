<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;

class PrintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Print(Request $request, $id)
    {
        $bookingIds = explode(',', $id);
        $bookings = Booking::whereIn('id', $bookingIds)->get();
        $generator = new BarcodeGeneratorPNG();

        $bookings = $bookings->map(function ($booking) use ($generator) {
            $barcode = $generator->getBarcode($booking->id, BarcodeGeneratorPNG::TYPE_CODE_128);
            $booking->barcode = base64_encode($barcode);

            // $url = route('bookings.show', ['booking' => $booking->id]) . '?view=pdf';
            $url = $booking->id;
            $qrCode = new QrCode($url);
            $writer = new PngWriter();
            $image = $writer->write($qrCode);
            $booking->qr = base64_encode($image->getString());

            return $booking;
        });
        return view('admin.print.print-ticket', compact('bookings'));
    }
    public function Printfront(Request $request, $id)
    {
        $bookingIds = explode(',', $id);
        $bookings = Booking::whereIn('id', $bookingIds)->get();
        $generator = new BarcodeGeneratorPNG();
    
        $bookings = $bookings->map(function ($booking) use ($generator) {
            $barcode = $generator->getBarcode($booking->id, BarcodeGeneratorPNG::TYPE_CODE_128);
            $booking->barcode = base64_encode($barcode);
    
            $url = $booking->id;
            $qrCode = new QrCode($url);
            $writer = new PngWriter();
            $image = $writer->write($qrCode);
            $booking->qr = base64_encode($image->getString());

            return $booking;
        });

        $pdf = FacadePdf::loadView('frontend.print-ticket-front', compact('bookings'));
        return $pdf->download('tickets.pdf');
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
