@extends('admin.layouts.app')
@section('title', 'Train Schedules List')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header justify-content-between">
            <div class="d-flex justify-content-between align-items-center">
                <div class="card-title">
                Train Schedules
                </div>
                @can('create-trains-schedules')
                <div class="prism-toggle">
                    <a href="{{ route('train-schedules.create') }}"><button class="btn btn-sm btn-primary forProductType">
                        <i class="ri-add-line align-middle me-2 d-inline-block"></i>
                        <span class="text">{{__('translate.add_schedule')}}</span>
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
                                            <th>Train</th>
                <th>Date</th>
                <th>Departure Time</th>
                <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('admin.schedules.filter')
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
<script type="text/javascript">
    handleCrud(
        '{{ route('train-schedules.create') }}',
        '{{ route('train-schedules.store') }}',
        '{{ route('train-schedules.show', ':id') }}',
        '{{ route('train-schedules.edit', ':id') }}',
        '{{ route('train-schedules.update', ':id') }}',
        '{{ route('train-schedules.destroy', ':id') }}',
        'tbody',
        {
            create: 'Add Train Schedules',
            edit: 'Update Train Schedules'
        },
        '{{ route('train-schedules.index') }}',
        '{{ csrf_token() }}'
    );
    function Change_status(status,id){
        var isActive = $(status).is(':checked');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('station.status', ':status') }}".replace(':status', id),
            method: 'POST',
            data: {
                id:id,
                isActive: isActive,
            },
            beforeSend: function() {
                
            },
            success: function(response) {
                toastr.success('Station Status Updated Successfully');
            },
            error: function(xhr, status, error) {
                if (xhr.status === 403) {
                toastr.error(xhr.responseJSON.message || 'Permission denied.');
            }else{
                toastr.error('An error occurred: ' + error, 'Error!');

            }
            
            },
            complete: function() {
            }
        });
    }
</script>
@endsection