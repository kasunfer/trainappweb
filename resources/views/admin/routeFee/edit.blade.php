@extends('admin.layouts.app')
@section('title','Edit Route Fee')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card mt-3">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Edit Route Fee
                </div>
            </div>
            <div class="card-body">
            <form id="users-form" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="route_fee_id" value="{{$routFee->id}}">
                <div class="row gy-2">
                <div class="col-xl-4 col-lg-6 col-md-4 col-sm-12">
                            <p class="mb-1">{{__('translate.from_station')}}</p>
                            <select name="from_station_id" class="form-control">
                                @foreach($stations as $station)
                                <option value="{{ $station->id }}" {{$routFee->from_station_id==$station->id?'selected':''}}>{{ $station->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error" id="error-from_station_id"></span>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <p class="mb-1">{{__('translate.to_station')}}</p>
                            <select name="to_station_id" class="form-control">
                                @foreach($stations as $station)
                                <option value="{{ $station->id }}" {{$routFee->to_station_id==$station->id?'selected':''}}>{{ $station->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error" id="error-to_station_id"></span>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <p class="mb-1">{{__('translate.fare')}}</p>
                            <input type="number" name="ticket_price" class="form-control" step="0.01" value="{{$routFee->ticket_price}}" required>
                            <span class="text-danger error" id="error-ticket_price"></span>
                            </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-end">
                        <button type="submit" name="action" value="create" class="btn btn-primary submit">Update</button>
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
        var route_fee_id=$('#route_fee_id').val();
    console.log($('#users-form').serialize());
    var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('route-fee.update', ':id') }}".replace(':id', route_fee_id),
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                
            },
            success: function(response) {
                toastr.success('Route Fee Updated Successfully');
                    window.location.href='{{route("route-fee.index")}}';
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