@extends('admin.layouts.app')
@section('title','Add Route Fee')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card mt-3">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Add New Route Fee
                </div>
            </div>
            <div class="card-body">
                <form id="users-form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-2">
                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-12">
                            <p class="mb-1">{{__('translate.from_station')}}</p>
                            <select name="from_station_id" class="form-control">
                                @foreach($stations as $station)
                                <option value="{{ $station->id }}">{{ $station->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error" id="error-from_station_id"></span>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <p class="mb-1">{{__('translate.to_station')}}</p>
                            <select name="to_station_id" class="form-control">
                                @foreach($stations as $station)
                                <option value="{{ $station->id }}">{{ $station->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error" id="error-to_station_id"></span>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <p class="mb-1">{{__('translate.fare')}}</p>
                            <input type="number" name="ticket_price" class="form-control" step="0.01" required>
                            <span class="text-danger error" id="error-ticket_price"></span>
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
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $('#users-form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var action = $('button[name="action"]').filter(':focus').val();
        formData.append('action', action);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('route-fee.store') }}",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('.error').text('');
                $('.input-error').removeClass('input-error');
            },
            success: function(response) {
                toastr.success('Route Fee Created Successfully');
                if (response.action === 'create_exit') {
                    window.location.href = '{{route("route-fee.index")}}';
                } else {
                    $('#users-form')[0].reset();
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#error-' + key).text(value[0]);
                        $('#' + key).addClass('input-error');
                        //toastr.error(value[0]);
                    });
                } else {
                    toastr.error('An error occurred: ' + error, 'Error!');
                }
            },
            complete: function() {}
        });
    });
</script>
@endsection