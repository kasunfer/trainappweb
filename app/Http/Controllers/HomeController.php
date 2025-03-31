<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RouteFee;
use App\Models\Station;
use App\Models\TrainSchedule;
use App\Models\TrainSeat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use stdClass;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stations = Station::all();
        return view('frontend.index', compact('stations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function aboutus()
    {
        return view('frontend.about');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function contact_us(Request $request)
    {
        return view('frontend.contact-us');
    }
    public function privacy_policy(Request $request)
    {
        return view('frontend.privacy-policy');
    }
    public function bookingStore(Request $request)
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
            }
        }

        return response()->json(['message' => 'Seats booked successfully.', 'bookingIds' => $bookingId, 'phone' => $request->phone_number, 'price' => $request->price_form], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function sendOtp(Request $request)
    {
        $phoneNumber = $request->input('phone_number');
        $otp = rand(100000, 999999);
        Session::put('otp', $otp);
        Session::put('otp_phone', $phoneNumber);

        $message = "Your OTP is: $otp Ralway Booking Portal";

        $apiUrl = "https://www.textit.biz/sendmsg/?id=94776254981&pw=4345&to=$phoneNumber&text=" . urlencode($message);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            return response()->json(['success' => false, 'message' => "Error sending OTP: $error"]);
        }

        curl_close($ch);
        return response()->json(['success' => true,'otp'=>$otp, 'message' => 'OTP sent successfully.']);
    }
    public function verifyOtp(Request $request)
    {
        $otp = $request->input('otp');

        // Check if the OTP matches
        if ($otp == Session::get('otp')) {
            Session::forget('otp');

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid OTP.']);
        }
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
    public function bookingCreate(Request $request)
    {
        $schedules = TrainSchedule::all();
        $availableSeats = TrainSeat::where('is_booked', false)->get();
        $stations = Station::all();
        return view('frontend.bookingCreate', compact('stations', 'schedules', 'availableSeats'));
    }
    public function destroy(string $id)
    {
        //
    }
    public function getSchedulesByDate(Request $request)
    {
        $date = $request->input('date');
        $formattedDate = Carbon::createFromFormat('d/m/y', $date)->format('Y-m-d');
        $schedules = TrainSchedule::with('train')->where('schedule_date', $formattedDate)->get();
        return response()->json(['schedules' => $schedules]);
    }
    public function getSeatsByScheduleAndStationsfront(Request $request)
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
    public function bookingCancel(Request $request)
    {
        // dd($request->bookingId);
        foreach ($request->bookingId as $id) {
            $booking = Booking::find($id);

            if ($booking) {
                TrainSeat::where('id', $booking->seat_id)->update(['is_booked' => false]);
                $booking->delete();
            }
        }

        return response()->json(['message' => 'Booking cancelled successfully.'], 200);
    }
    public function bookingCancelStripe(Request $request)
{
    // Get the booking IDs from the request
    $bookingIds = explode(',', $request->booking_ids);

    foreach ($bookingIds as $id) {
        $booking = Booking::find($id);

        if ($booking) {
            TrainSeat::where('id', $booking->seat_id)->update(['is_booked' => false]);
            $booking->delete();
        }
    }

    return redirect('booking');
}

    public function stripe(Request $request){
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $publicKey=env('STRIPE_KEY');
        $ticketIds = $request->bookingIds;
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => 'Ticket Booking'],
                    'unit_amount' => number_format(($request->amount/29600),2)*100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/payment-success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/cancel-booking-stripe?booking_ids=' .implode(',', $ticketIds)),
            'client_reference_id' => implode(',', $ticketIds),
        ]);
    
        return response()->json(['id' => $session->id,'publicKey'=>$publicKey]);
    }
    public function paymentSuccess(Request $request) {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = \Stripe\Checkout\Session::retrieve($request->session_id);
        if ($session->payment_status === 'paid') {
            $ticketUrl = route('front-print.ticket', ['id' => $session->client_reference_id]);
            return redirect('booking?id='.$session->client_reference_id);
        }
    
        return redirect()->route('/');
    }
    
    public function Payhere(Request $request)
    {
        $order_id = $request->order_id;
        if (is_array($order_id)) {
            $order_id = $order_id[0];
        }
        $sandbox = true;
        $merchant_id = env('PAYHERE_MERCHANT_ID');
        $name = env('APP_NAME');
        $price =number_format($request->amount, 2, '.', '');
        $currency = "LKR";
        $merchant_secret = env('PAYHERE_MERCHANT_SECRET');
        $first_name = 'Passenger';
        $last_name = 'Passenger';
        $email = 'passenger@gmail.com';
        $phone = $request->phone;
        $address = '';
        $city = 'Colomb0';
        $country = "Srilanka";
        $items = $request->order_id;
        $return_url = env('APP_URL');
        $cancel_url = env('APP_URL');
        $hash = strtoupper(
            md5(
                env('PAYHERE_MERCHANT_ID') .
                    $order_id .
                    number_format($price, 2, '.', '') .
                    $currency .
                    strtoupper(md5(env('PAYHERE_MERCHANT_SECRET')))
            )
        );

        $obj = new stdClass();
        $obj->sandbox = $sandbox;
        $obj->order_id = $order_id;
        $obj->merchant_id = $merchant_id;
        $obj->name = $name;
        $obj->price = $price;
        $obj->currency = $currency;
        $obj->hash = $hash;
        $obj->first_name = $first_name;
        $obj->last_name = $last_name;
        $obj->email = $email;
        $obj->phone = $phone;
        $obj->address = $address;
        $obj->city = $city;
        $obj->country = $country;
        $obj->items = $items;
        $obj->return_url = $return_url;
        $obj->cancel_url = $cancel_url;
        return response()->json([
            'data' => $obj,
        ]);
    }
}
