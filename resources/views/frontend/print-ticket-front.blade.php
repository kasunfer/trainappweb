<!DOCTYPE html>
<html>

<head>
    <title>Print Ticket</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap');

        body {
            font-family: 'Roboto Mono', monospace !important;
            font-size: 12px;
            margin: 0;
            padding: 0;
            text-align: center;
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 80mm;
            padding: 5px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
        }

        h2, h3 {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            text-decoration: underline;
            padding: 5px;
            text-align: center;
        }

        th, td {
            padding: 5px;
            text-align: center;
        }

        .order-summary p {
            margin: 2px 0;
            text-align: left;
        }

        .total-price {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }

        .border-top {
            border-top: 0.0625rem solid #000000 !important;
        }

        .border-bottom {
            border-bottom: 0.0625rem solid #000000 !important;
        }

        .print-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .print-btn:hover {
            background-color: #0056b3;
        }

        .print-btn:active {
            background-color: #00408b;
            transform: scale(0.98);
        }

        .text-right {
            text-align: right;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body, .container {
                visibility: visible !important;
                display: block !important;
                text-align: left;
                margin: 0;
            }
        }

        @page {
            size: 80mm auto;
            margin: 5mm;
        }

        .qr-section {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-top: 20px;
        }

        .ticket-summary p {
            text-align: left;
            margin: 2px 0;
        }
    </style>
</head>

<body>
    <div class="ticket-container">
        @foreach($bookings as $booking)
        <div class="container">
            <div class="ticket-summary border-bottom">
                <p><strong>Contact No:</strong> {{ $booking->phone_number }}</p>
                <p><strong>Departure:</strong> {{ $booking->fromStation->name }}</p>
                <p><strong>Destination:</strong> {{ $booking->toStation->name }}</p>
                <p><strong>Train Name:</strong> {{ $booking->trainSchedule->train->name }}</p>
                <p><strong>Seat No:</strong> {{ $booking->seat->seat_number }}</p>
                <p><strong>Date & Time:</strong> {{ $booking->trainSchedule->departure_time }}</p>
                
                {{--<p class="border-top">
                    {{ __('fare_price') }}:{{ $booking->trainSchedule->fare_price }}
                </p>--}}
            </div>

            <div class="qr-section">
                <img src="data:image/png;base64,{{ $booking->qr }}" alt="QR Code" style="width: 100px; height: 100px;">
            </div>
        </div>
        @endforeach
    </div>
</body>

</html>
