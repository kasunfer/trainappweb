<table>
    <thead>
        <tr>
            <th>Train Name</th>
            <th>Seat No</th>
            <th>Phone</th>
            <th>From</th>
            <th>To</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->train_name }}</td>
                <td>{{ $booking->seat_no }}</td>
                <td>{{ $booking->phone }}</td>
                <td>{{ $booking->from }}</td>
                <td>{{ $booking->to }}</td>
                <td>{{ $booking->date }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
