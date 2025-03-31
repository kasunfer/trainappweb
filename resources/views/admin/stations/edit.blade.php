@extends('admin.layouts.app')
@section('title','Edit Station')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card mt-3">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Edit Station {{$station->name}}
                </div>
            </div>
            <div class="card-body">
            <form id="users-form" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="station_id" value="{{$station->id}}">
                <div class="row gy-2">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.name')}}</p>
                        <input type="text" name="name" class="form-control" id="name" value="{{$station->name}}" placeholder="{{__('translate.enter_name')}}">
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.city')}}</p>
                        <input type="text" name="city" class="form-control" id="code" value="{{$station->city}}" readonly>
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
        var stationId=$('#station_id').val();
    console.log($('#users-form').serialize());
    var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('station.update', ':id') }}".replace(':id', stationId),
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                
            },
            success: function(response) {
                toastr.success('Station Updated Successfully');
                    window.location.href='{{route("station.index")}}';
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#error-' + key).text(value[0]);
                        $('#'+key).addClass('input-error');
                        //toastr.error(value[0]);
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