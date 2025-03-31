@extends('frontend.layouts.app')
@section('title', 'Home')
@section('content')
<section class="section section-lg section-main-bunner section-main-bunner-filter text-center">
  <div class="main-bunner-img" style="background-image: url(&quot;frontend/images/train.png &quot;); background-size: cover;"></div>
  <div class="main-bunner-inner">
    <div class="container">
      <div class="box-default">
        <h1 class="box-default-title">Welcome To</h1>

        <p class="big box-default-text">
        <h2>Online Advance Train Seats Reservation!</h2>
        </p>
      </div>
    </div>
  </div>
</section>
<div class="bg-gray-1">
  <section class="section-transform-top">
    <div class="container">
      <div class="box-booking">
        <form class="booking-form" id="booking-form">
          <div>
            <p class="booking-title">Date</p>
            <div class="form-wrap form-wrap-icon"><span class="icon mdi mdi-calendar-text"></span>
              <input class="form-input" id="booking-date" type="text" name="date" data-constraints="" data-time-picker="date">
            </div>
          </div>
          <div>
            <p class="booking-title">Schedule</p>
            <div class="form-wrap">
              <select id="schedule_id">
                <option label="placeholder"></option>
              </select>
            </div>
          </div>
          <div>
            <p class="booking-title">From</p>
            <div class="form-wrap">
              <select id="from_station">
                <option label="placeholder"></option>
                @foreach($stations as $station)
                <option value="{{$station->id}}">{{$station->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div>
            <p class="booking-title">To</p>
            <div class="form-wrap">
              <select class="form-control" id="to_station">
                <option label="placeholder"></option>
                @foreach($stations as $station)
                <option value="{{$station->id}}">{{$station->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </form>
      </div>


    </div>
  </section>

  <div id="about"> </div>
  <section class="section section-lg section-inset-1 bg-gray-1 pt-lg-0">
    <div class="container">
      <div class="row row-50 justify-content-xl-between align-items-lg-center">
        <div class="col-lg-6 wow fadeInLeft">
          <div class="box-image"><img class="box-image-static" src="{{asset('frontend/images/t2.jpeg')}}" alt="" width="483" height="327" />
          </div>
        </div>
        <div class="col-lg-6 col-xl-5 wow fadeInRight">
          <h2>About Us</h2>
          <p>The Online Advanced Train Seat Reservation System was designed by Group 2 of the MSc in IT program as part of their technology software group assignment. This system aims to improve the current booking system of the Sri Lankan railway.</p>

        </div>
      </div>
    </div>
  </section>
</div>

<div id="terms"> </div>
<section class="section section-lg bg-default">
  <div class="container">
    <div class="row justify-content-left text-left">
      <div class="col-md-9 col-lg-7 wow-outer">
        <div class="wow slideInDown">
          <h2>Terms and Conditions</h2>

        </div>
      </div>
    </div>
    <div class="row row-20 row-lg-30">
      <div class="col-md-9 col-lg-7 wow-outer">
        <div class="wow fadeInUp">
          <div class="col-md-offset-1 col-md-10 col-sm-12">
            <h5>GENERAL TERMS AND CONDITIONS APPLICABLE FOR USE OF THE ONLINE SEAT RESERVATION SERVICE.
            </h5> <br>
            <ol>
              <li>1. Select the correct train for your journey.</li>
              <li>2. Fix a convenient date for both up & down journeys.</li>
              <li>3. User can buy 5 tickets with a single nic, if needs buy more than 5 ticket should provide extra valid nic for each 5 extra tickets.</li>
              <li>4. Maximum of 5 seats could be reserved at once.</li>
              <li>5. A reservation only becomes guaranteed once full payment has been received by Sri Lanka Railways.</li>
            </ol>

          </div>
        </div>


      </div>
      <hr>
    </div>
</section>



<section class="section">
  <div class="row isotope-wrap">
    <!-- Isotope Content-->
    <div class="col-lg-12">
      <div class="isotope" data-isotope-layout="fitRows" data-isotope-group="gallery" data-lightgallery="group" data-lg-thumbnail="false">
        <div class="row no-gutters row-condensed">
          <div class="col-12 col-sm-12 col-md-12 isotope-item wow-outer" data-filter="*">
            <div class="wow slideInDown">
              <div class="gallery-item-classic"><img src="{{asset('frontend/images/bannerj.webp')}}" alt="" width="auto" height="auto" />
                <div class="gallery-item-classic-caption"><a href="frontend/images/bannerj.webp" data-lightgallery="item">zoom</a></div>
              </div>
            </div>
          </div>

        </div>



      </div>
    </div>
  </div>
  </div>
</section>

<div id="contact"> </div>
<section class="section section-lg bg-default" id="contact" data-stellar-background-ratio="0.5">
  <div class="container">
    <div class="row">

      <div class="col-md-12 col-sm-12">
        <div class="section-title">
          <h2>Contact Us - Team of Group 2</h2>
        </div>
      </div>


      <div align="center" class="col-md-12 col-sm-12"> <br>

        <div class="tab-content" align="left">
          <div class="tab-pane active" id="tab001" role="tabpanel">
            <div class="tab-pane-item">
              <h4>Prabath Bandara Panwaththa</h4>
              <p>E-mail : <a href=mailto:>CL-MSCIT-25-08@student.icbtcampus.edu.lk</a> </p>
              <p>Mobile : <a href=tel:>94771556750</a> </p>
            </div>

          </div>


          <div class="tab-pane active" id="tab002" role="tabpanel">
            <div class="tab-pane-item">
              <h4>Antonroy Anpazhagan</h4>
              <p>E-mail : <a href=mailto:>CL-MSCIT-26-27@student.icbtcampus.edu.lk</a> </p>
              <p>Mobile : <a href=tel:>94776254981</a> </p>
            </div>
          </div>

          <div class="tab-pane active" id="tab003" role="tabpanel">
            <div class="tab-pane-item">
              <h4>Jayamayuran Gnanakanthan</h4>
              <p>E-mail : <a href=mailto:>CL-MSCIT-26-10@student.icbtcampus.edu.lk</a> </p>
              <p>Mobile : <a href=tel:>94767011060</a> </p>
            </div>
          </div>

          <div class="tab-pane active" id="tab004" role="tabpanel">
            <div class="tab-pane-item">
              <h4>Damindu Kalupathirana</h4>
              <p>E-mail : <a href=mailto:>CL-MSCIT-26-18@student.icbtcampus.edu.lk</a> </p>
              <p>Mobile : <a href=tel:>94714328027</a> </p>
            </div>
          </div>
          <div class="tab-pane active" id="tab005" role="tabpanel">
            <div class="tab-pane-item">
              <h4>Kasun Fernando</h4>
              <p>E-mail : <a href=mailto:>CL-MSCIT-26-07@student.icbtcampus.edu.lk</a> </p>
              <p>Mobile : <a href=tel:>94773065665</a> </p>
            </div>
            <div class="tab-pane-item">
              <h4>Gihan Wickremasinghe</h4>
              <p>E-mail : <a href=mailto:>CL-MSCIT-26-0-@student.icbtcampus.edu.lk</a> </p>
              <p>Mobile : <a href=tel:>94777332166</a> </p>
            </div>
          </div>
        </div>

      </div>



    </div>
  </div>
</section>

<div id="news"> </div>
<section class="section-lg bg-default">
  <div class="container wow-outer">
    <h2 class="text-center wow slideInDown">Recent News</h2>
    <!-- Owl Carousel-->
    <div class="owl-carousel wow fadeInUp" data-items="1" data-md-items="2" data-lg-items="3" data-dots="true" data-nav="false" data-stage-padding="15" data-loop="false" data-margin="30" data-mouse-drag="false">
      <div class="post-corporate"><a class="badge" href="">30 Jan 2025</a>
        <h4 class="post-corporate-title"><a href="">The great ‘train e-ticket’ robbery</a></h4>
        <div class="post-corporate-text">
          <p>The issue of illegal ticket sales for the popular Colombo to Ella train route has become one of the most...</p>
        </div><a class="post-corporate-link" href="https://www.themorning.lk/articles/Ncde0bJlsVCXjY4kj9Su">Read more<span class="icon linearicons-arrow-right"></span></a>
      </div>
      <div class="post-corporate"><a class="badge" href="">30 Jan 2025</a>
        <h4 class="post-corporate-title"><a href="">Train tickets scam in SL exposed by a youtuber. </a></h4>
        <div class="post-corporate-text">
          <p>Train tickets scam in SL exposed by a youtuber. Selling tickets at higher prices for Tourists...</p>
        </div><a class="post-corporate-link" href="https://www.reddit.com/r/srilanka/comments/1h6g7f8/train_tickets_scam_in_sl_exposed_by_a_youtuber/?rdt=33902">Read more<span class="icon linearicons-arrow-right"></span></a>
      </div>
      <div class="post-corporate"><a class="badge" href="">18 Jan 2025</a>
        <h4 class="post-corporate-title"><a href="">Railway Officer Suspended for Train Ticket Scam</a></h4>
        <div class="post-corporate-text">
          <p>The Railway Department has identified a key suspect in connection with a train ticket scam, following suspicions raised...</p>
        </div><a class="post-corporate-link" href="https://mawratanews.lk/news/railway-officer-suspended-for-train-ticket-scam-tickets-sold-at-exorbitant-prices-to-foreigners/">Read more<span class="icon linearicons-arrow-right"></span></a>
      </div>

    </div>
  </div>
</section>

@endsection
@push('scripts')
<script>
  $('#booking-date').on('change', function() {
            let selectedDate = $(this).val();
            $('#schedule_id').prop('disabled', true).html('<option value="">Loading...</option>');

            $.ajax({
                url: "{{ route('getSchedulesByDateFront') }}",
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
        $('#to_station').on('change', function() {
    let scheduleId = $('#schedule_id').val();
    let fromStationId = $('#from_station').val();
    let toStationId = $(this).val();

    // Hide seat layout initially
    $('#seat-layout').hide();
    $('#seats-container').html('<p>Loading Seats...</p>');

    $.ajax({
        url: "{{ route('getSeatsByScheduleAndStationsfront') }}",
        method: "GET",
        data: {
            schedule_id: scheduleId,
            from_station_id: fromStationId,
            to_station_id: toStationId
        },
        success: function(response) {
            // Clear previous seat layout
            $('#seat-layout').empty();

            let seatsPerRow = 4; // Two seats on left, aisle, two seats on right
            let aisleWidth = 40; // Width of the aisle space
            let rowDiv = null;

            // Loop through seats and generate layout
            response.seats.forEach((seat, index) => {
                if (index % seatsPerRow === 0) {
                    rowDiv = $('<div class="seat-row"></div>'); // Create new row
                    $('#seat-layout').append(rowDiv);
                }

                let seatPosition = index % seatsPerRow;

                // Add the aisle space after two seats (middle of the row)
                if (seatPosition === 2) {
                    rowDiv.append(`<div class="seat-gap" style="width: ${aisleWidth}px;"></div>`);
                }

                let isBooked = response.booked_seat_ids.includes(seat.id); // Check if seat is booked
                let seatClass = isBooked ? "seat booked" : "seat available";

                // Generate seat HTML
                let seatHtml = `
                    <div class="${seatClass}" data-seat-id="${seat.id}" data-seat-number="${seat.seat_number}">
                        <input type="checkbox" class="seat-checkbox" data-seat-id="${seat.id}" id="seat-${seat.id}" name="seats[]" value="${seat.id}" style="display: none;" ${isBooked ? 'disabled' : ''}>

                        <label for="seat-${seat.id}" class="${isBooked ? 'booked' : ''}" ${isBooked ? 'disabled' : ''}>
                            ${seat.seat_number}
                        </label>
                    </div>`;

                // Append seat to the row
                rowDiv.append(seatHtml);
            });

            // Show the ticket price
            $('#ticket-price').text('LKR.' + response.price);
            $('#price').val(response.price);

            // Show the seat layout
            $('#seat-layout').show();

            // Open the modal
            $('#seat-modal').modal('open');
        }
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
                    alert('Error booking seats: ' + error);
                }
            });
            });
            });
</script>

@endpush