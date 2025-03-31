@extends('admin.layouts.app')
@section('title','Edit Schedule')
@section('content')
<div class="row">
<div class="col-xl-12">
    <div class="card custom-card mt-3">
        <div class="card-header justify-content-between">
            <div class="card-title">
                Edit Schedule
            </div>
        </div>
        <div class="card-body">
            <form id="users-form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="schedule_id" id="schedule_id" value="{{ $schedule->id ?? '' }}">
                
                <div class="row gy-2">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.name')}}</p>
                        <select name="train_id" id="train_id" class="form-control">
                            @foreach($trains as $train)
                                <option value="{{ $train->id }}" {{ isset($schedule) && $schedule->train_id == $train->id ? 'selected' : '' }}>
                                    {{ $train->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger error" id="error-train_id"></span>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.date')}}</p>
                        <input type="date" name="date" id="date" class="form-control" value="{{ $schedule->schedule_date ?? '' }}">
                        <span class="text-danger error" id="error-date"></span>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.departure_time')}}</p>
                        <input type="time" name="departure_time" id="departure_time" class="form-control" value="{{ $schedule->departure_time ?? '' }}">
                        <span class="text-danger error" id="error-departure_time"></span>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">Total Seats</p>
                        <input type="number" name="seats" id="seats" class="form-control" min="1" value="{{ $schedule->seats()->count() }}">
                        <span class="text-danger error" id="error-seats"></span>
                    </div>

                    <!-- Train Stops Section -->
                    <div class="col-xl-12">
                        <h3 class="mt-3">Train Stops</h3>
                        <div id="stops-container">
                            @if(isset($schedule) && $schedule->stops->count() > 0)
                                @foreach($schedule->stops as $index => $stop)
                                    <div class="stop-entry row gy-2">
                                        <div class="col-md-3">
                                            <label>Station</label>
                                            <select name="stops[{{ $index }}][station_id]" class="form-control">
                                                @foreach($stations as $station)
                                                    <option value="{{ $station->id }}" {{ $stop->station_id == $station->id ? 'selected' : '' }}>
                                                        {{ $station->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Arrival Time</label>
                                            <input type="time" name="stops[{{ $index }}][arrival_time]" class="form-control" value="{{ $stop->arrival_time }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Departure Time</label>
                                            <input type="time" name="stops[{{ $index }}][departure_time]" class="form-control" value="{{ $stop->departure_time }}">
                                        </div>
                                        @if($index==0)
                                        <div class="col-md-3 d-flex justify-content-end align-items-end">
                                        <button type="button" class="btn btn-success mt-2" onclick="addStop()">Add Stop</button>
                                        </div>
                                        @else
                                        <div class="col-md-3 d-flex justify-content-end align-items-end">
                                            <button type="button" class="btn btn-danger remove-stop">Remove</button>
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="stop-entry row gy-2">
                                    <div class="col-md-3">
                                        <label>Station</label>
                                        <select name="stops[0][station_id]" class="form-control">
                                            @foreach($stations as $station)
                                                <option value="{{ $station->id }}">{{ $station->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Arrival Time</label>
                                        <input type="time" name="stops[0][arrival_time]" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Departure Time</label>
                                        <input type="time" name="stops[0][departure_time]" class="form-control">
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-end align-items-end">
                                        <button type="button" class="btn btn-success mt-2" onclick="addStop()">Add Stop</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-end">
                        <button type="reset" class="btn btn-warning">Reset</button>
                        <button type="submit" name="action" value="create" class="btn btn-primary submit">Save</button>
                        <button type="submit" name="action" value="create_exit" class="btn btn-success submit">Save & Exit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
  function addStop() {
    let container = document.getElementById('stops-container'); // Define container

    // Get all selected station IDs
    let selectedStations = Array.from(container.querySelectorAll('select[name^="stops"]'))
        .map(select => select.value);

    // Check if a station has been selected more than once
    if (new Set(selectedStations).size !== selectedStations.length) {
        Swal.fire({
            title: 'Operation Failed?',
            text: "Each stop must have a unique station.",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#000',
        });
        return;
    }

    let stopCount = container.querySelectorAll('.stop-entry').length; // Ensure stopCount is defined dynamically

    let newStop = document.createElement('div');
    newStop.classList.add('stop-entry', 'row', 'gy-2');
    newStop.innerHTML = `
        <div class="col-md-3">
            <label>Station</label>
            <select name="stops[${stopCount}][station_id]" class="form-control stop-select">
                <option value="">Select a station</option>
                @foreach($stations as $station)
                    <option value="{{ $station->id }}">{{ $station->name }}</option>
                @endforeach
            </select>
            <span class="text-danger error" id="error-stops[${stopCount}][station_id]"></span>
        </div>
        <div class="col-md-3">
            <label>Arrival Time</label>
            <input type="time" name="stops[${stopCount}][arrival_time]" class="form-control">
            <span class="text-danger error" id="error-stops[${stopCount}][arrival_time]"></span>
        </div>
        <div class="col-md-3">
            <label>Departure Time</label>
            <input type="time" name="stops[${stopCount}][departure_time]" class="form-control">
            <span class="text-danger error" id="error-stops[${stopCount}][departure_time]"></span>
        </div>
        <div class="col-md-3 d-flex justify-content-end align-items-end">
            <button type="button" class="btn btn-danger remove-stop">Remove</button>
        </div>
    `;

    container.appendChild(newStop);
}

document.getElementById('stops-container').addEventListener('click', function(event) {
    if (event.target.classList.contains('remove-stop')) {
        event.target.closest('.stop-entry').remove();
    }
});

document.getElementById('stops-container').addEventListener('change', function(event) {
    if (event.target.classList.contains('stop-select')) {
        let selects = document.querySelectorAll('.stop-select');
        let selectedValues = Array.from(selects).map(select => select.value);
        
        let duplicates = selectedValues.filter((val, index, arr) => arr.indexOf(val) !== index);
        if (duplicates.length > 0) {
            Swal.fire({
                title: 'Operation Failed?',
                text: "This station is already selected. Please choose a different one.",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#000',
            });
            event.target.value = '';
        }
    }
});

 $('#users-form').submit(function(e) {
        e.preventDefault();
        var schedule_id=$('#schedule_id').val();
    console.log($('#users-form').serialize());
    var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('train-schedules.update', ':id') }}".replace(':id', schedule_id),
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                
            },
            success: function(response) {
                toastr.success('Schedule Updated Successfully');
                    window.location.href='{{route("train-schedules.index")}}';
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#error-' + key).text(value[0]);
                        $('#' + key).addClass('input-error');
                    });
                } else {
                    toastr.error('An error occurred: ' + error, 'Error!');
                }
            },
            complete: function() {
            }
        });
    });
</script>
@endsection