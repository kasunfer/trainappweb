@extends('admin.layouts.app')
@section('title', 'Train Booking List')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        Train Booking List
                    </div>
                    @can('export-reports')
                    <div class="prism-toggle">
                        <a href="{{ route('booking.pdf') }}"><button class="btn btn-sm btn-danger forProductType">
                                <span class="text">Export PDF</span>
                            </button></a>
                        <a href="{{ route('booking.excel') }}"><button class="btn btn-sm btn-success forProductType">
                                <span class="text">Excel</span>
                            </button></a>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div class="table table-responsive">
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
                            <td colspan="9">
                                <span style="float: left;margin-top:10px;">showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} Entries</span>
                                <span style="float: right;">{{$bookings->links('app.include.pagination')}}</span>
                            </td>
                            <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script src="{{ asset('js/common/crud_and_pagination.js') }}"></script>

@endsection