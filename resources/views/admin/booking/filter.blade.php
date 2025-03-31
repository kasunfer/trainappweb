@forelse($bookings as $key=> $booking)
<tr>
    <td>{{++$key}}</td>
    <td>{{ $booking->trainSchedule->train->name }}</td>
    <td>{{ $booking->seat->seat_number }}</td>
    <td>{{ $booking->phone_number }}</td>
    <td>{{ $booking->fromStation->name }}</td>
    <td>{{ $booking->toStation->name }}</td>
                <td>{{ $booking->trainSchedule->schedule_date }}</td>
                <td class="text-right">
        @can('delete-booking')
        <button type="submit" onclick="destroy({{$booking->id}})" class="btn btn-icon btn-danger-transparent rounded-pill btn-wave">
            <i class="ri-delete-bin-line"></i>
        </button>
        @endcan
    </td>
</tr>
@empty
<tr class="empty-row">
    <td colspan="9" class="text-center">No data found.</td>
</tr>
@endforelse
<td colspan="9">
<span style="float: left;margin-top:10px;">showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} Entries</span>
<span style="float: right;">{{$bookings->links('app.include.pagination')}}</span>
</td>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />