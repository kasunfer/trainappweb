@extends('admin.layouts.app')
@section('title','Add Booking')
<style>
    #seat-layout {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px;
        background-color: #f5f5f5;
        border-radius: 8px;
        width: fit-content;
        margin: auto;
    }

    .seat-row {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
    }

    .seat {
        width: 40px;
        height: 40px;
        margin: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #007bff;
        background-color: #fff;
        border-radius: 5px;
    }

    .seat button {
        width: 100%;
        height: 100%;
        background: transparent;
        border: none;
        font-weight: bold;
        cursor: pointer;
    }

    .seat.booked {
        background-color: #dc3545;
        /* Red for booked seats */
        border-color: #dc3545;
    }

    .seat.booked button {
        color: white;
        cursor: not-allowed;
    }

    .seat-gap {
        width: 40px;
        height: 40px;
        display: inline-block;
    }

    .seat.selected {
        background-color: #4CAF50;
        /* Green for selected */
        color: white;
    }

    /* Style for booked seats (if you want to show booked seats differently) */
    .seat.booked {
        background-color: #f44336;
        /* Red for booked */
        color: white;
        cursor: not-allowed;
    }
</style>
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card mt-3">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Add Booking
                </div>
            </div>
            <div class="card-body">
                <form id="booking-form" method="POST" action="{{ route('bookings.store') }}">
                    @csrf
                    <div id="ticket-price">
                        <p><strong>Ticket Price:</strong> <span>LKR 0.00</span></p>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <p class="mb-1">{{__('translate.mobile')}}</p>
                            <input type="number" id="phone_number" class="form-control" placeholder="947********" name="phone_number" maxlength="11" oninput="limitPhoneNumberLength(this)" required>
                            <input type="hidden" id="price" class="form-control" name="price" required>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <p class="mb-1">{{__('translate.date')}}</p>
                            <input type="date" name="date" class="form-control" id="date">
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <p class="mb-1">{{__('translate.schedule')}}</p>
                            <select id="schedule_id" name="schedule_id" required disabled class="form-control">
                                <option value="">Select Schedule</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" id="seats" name="seats[]" required>


                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <p class="mb-1">{{__('translate.from_station')}}</p>
                            <select id="from_station_id" name="from_station_id" class="form-control" required>
                                <option value="">Select From Station</option>
                                @foreach($stations as $station)
                                <option value="{{$station->id}}">{{$station->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <p class="mb-1">{{__('translate.to_station')}}</p>
                            <select id="to_station_id" name="to_station_id" class="form-control" required>
                                <option value="">Select From Station</option>
                                @foreach($stations as $station)
                                <option value="{{$station->id}}">{{$station->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row  mt-5">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

                            <div id="seat-layout" class="seat-layout" style="display: none;">
                                <p>Select Your Seat:</p>
                                <div id="seats-container"></div>
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="row mt-5">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">

                            <button type="submit" class="btn btn-primary submit">Book Seat</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
       
        $('#date').on('change', function() {
            let selectedDate = $(this).val();
            $('#schedule_id').prop('disabled', true).html('<option value="">Loading...</option>');

            $.ajax({
                url: "{{ route('getSchedulesByDate') }}",
                method: "GET",
                data: {
                    date: selectedDate
                },
                success: function(response) {
                    $('#schedule_id').prop('disabled', false).html('<option value="">Select Schedule</option>');
                    response.schedules.forEach(schedule => {
                        $('#schedule_id').append(`<option value="${schedule.id}">${schedule.train.name} - ${schedule.departure_time}</option>`);
                    });
                }
            });
        });

        $('#to_station_id').on('change', function() {
            let scheduleId = $('#schedule_id').val();
            let fromStationId = $('#from_station_id').val();
            let toStationId = $(this).val();

            $('#seat-layout').hide();
            $('#seats-container').html('<p>Loading Seats...</p>');

            $.ajax({
                url: "{{ route('getSeatsByScheduleAndStations') }}",
                method: "GET",
                data: {
                    schedule_id: scheduleId,
                    from_station_id: fromStationId,
                    to_station_id: toStationId
                },
                success: function(response) {
                    $('#seat-layout').empty();

                    let seatsPerRow = 4;
                    let aisleWidth = 40;

                    let rowDiv = null;

                    response.seats.forEach((seat, index) => {
                        if (index % seatsPerRow === 0) {
                            rowDiv = $('<div class="seat-row"></div>');
                            $('#seat-layout').append(rowDiv);
                        }

                        let seatPosition = index % seatsPerRow;

                        if (seatPosition === 2) {
                            rowDiv.append(`<div class="seat-gap" style="width: ${aisleWidth}px;"></div>`);
                        }

                        let isBooked = response.booked_seat_ids.includes(seat.id);
                        let seatClass = isBooked ? "seat booked" : "seat available";

                        let seatHtml = `
            <div class="${seatClass} seat-checkbox" data-seat-id="${seat.id}" data-seat-number="${seat.seat_number}">
                    <input type="checkbox" class="seat-checkbox" data-seat-id="${seat.id}" id="seat-${seat.id}" name="seats[]" value="${seat.id}" style="display: none;" ${isBooked ? 'disabled' : ''}>

                    <label for="seat-${seat.id}" class="${isBooked ? 'booked' : ''}" ${isBooked ? 'disabled' : ''}>
                        ${seat.seat_number}
                    </label>
            </div>`;

                        rowDiv.append(seatHtml);
                    });

                    $('#ticket-price').text('');
                    $('#ticket-price').text('LKR.' + response.price);
                    $('#price').val(response.price);
                    $('#seat-layout').show();
                }

            });
        });
    });
    $(document).ready(function() {
        let selectedSeats = [];

        $(document).on('click', '.seat-checkbox', function() {
            let seatButton = $(this);
            let seat = seatButton.closest('.seat');
            let seatId = seat.data('seat-id');
            let seatNumber = seat.data('seat-number');
            let price = parseFloat($('#price').val()) || 0;
            if (seat.hasClass('selected')) {
                seat.removeClass('selected');
                selectedSeats = selectedSeats.filter(seat => seat !== seatId);
            } else {
                seat.addClass('selected');
                selectedSeats.push(seatId);
            }
            let selectedSeatsCount = $('.selected').length;
            
            $('#ticket-price').text('LKR.' + parseFloat(price * selectedSeatsCount).toFixed(2));

            // $('#seats').val(selectedSeats);
        });

        $('#booking-form').submit(function(e) {
            e.preventDefault();
            let phoneNumber = $('#phone_number').val();
            if (phoneNumber.length !== 11) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Phone number must be 11 digits!',
                });
                return;

            }
            if (selectedSeats.length === 0) {
                Swal.fire({
                    title: 'Operation Failed?',
                    text: "Please select at least one seat!.",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#000',
                });
                return;
            }

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('bookings.store') }}",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Success',
                        text: "Seats booked successfully! Print The Tickets?",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonColor: '#000',
                    }).then((result) => {
                        if (result.isConfirmed) {
                                openPrintTab(response.bookingIds, () => {
                                    location.reload();
                                });
                            } else {
                                location.reload();
                            }
                    });

                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Error booking seats: ' + error;
                    if (xhr.status==500) {
                        Swal.fire({
                        title: 'Error',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'Ok',
                    });
                    }else{
                        Swal.fire({
                        title: 'Error',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'Ok',
                        });
                    }
                }
            });
        });
        function openPrintTab(bookingIds, callback) {
            if (!Array.isArray(bookingIds)) {
        console.error("Invalid booking IDs. Expected an array.");
        return;
    }

    const bookingIdsParam = bookingIds.join(',');

    let print_url = "{{ route('print.ticket', ['id' => ':id']) }}";
    print_url = print_url.replace(':id', encodeURIComponent(bookingIdsParam)); 

    const printWindow = window.open(print_url, '_blank');
    if (printWindow) {
        const checkIfLoaded = setInterval(() => {
            if (printWindow.closed) {
                clearInterval(checkIfLoaded);
                callback();
            }
        }, 500);
    } else {
        console.error("Failed to open the print view. Make sure pop-ups are not blocked.");
        callback();
    }
}
    });
    function limitPhoneNumberLength(input) {
        if (input.value.length > 11) {
            input.value = input.value.slice(0, 11);
        }
    }
</script>

@endsection