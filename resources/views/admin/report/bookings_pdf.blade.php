<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #000;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #F4F6F6;
        }

        h3 {
            text-align: center;
        }

        td {
            border: 1px solid #ddd;
            padding: 5px;
        }

        @page {
            margin: 50px 25px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
    <!-- <img class="img-fluid" style="width:100%;margin-left:auto;margin-right:auto;" src="{{ asset('frontend/images/logo.jpg') }}"> -->
    </div>
    <h3>Booking Report</h3>
    <table class="table text-nowrap" style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Train Name</th>
                                <th>Seat No</th>
                                <th>Phone</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $key=> $booking)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{ $booking->trainSchedule->train->name }}</td>
                                <td>{{ $booking->seat->seat_number }}</td>
                                <td>{{ $booking->phone_number }}</td>
                                <td>{{ $booking->fromStation->name }}</td>
                                <td>{{ $booking->toStation->name }}</td>
                                <td>{{ $booking->trainSchedule->schedule_date }}</td>
                            </tr>
                            @empty
                            <tr class="empty-row">
                                <td colspan="9" class="text-center">No data found.</td>
                            </tr>
                            @endforelse
                
                            <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                        </tbody>
    </table>
    {{--<div class="footer">
    Page {PAGE_NUM} of {PAGE_COUNT}
</div>--}}

    <script type="text/php">
        if (isset($pdf)) {
        $x = 360;
        $y = 570;
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 14;
        $color = array(0,0,0);
        $word_space = 0.0;
        $char_space = 0.0;
        $angle = 0.0;
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>

</body>

</html>