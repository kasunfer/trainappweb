@extends('admin.layouts.app')
@section('title', 'Stations List')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header justify-content-between">
            <div class="d-flex justify-content-between align-items-center">
                <div class="card-title">
                Stations
                </div>
                @can('create-stations')
                <div class="prism-toggle">
                    <a href="{{ route('station.create') }}"><button class="btn btn-sm btn-primary forProductType">
                        <i class="ri-add-line align-middle me-2 d-inline-block"></i>
                        <span class="text">{{__('translate.add_station')}}</span>
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
                                            <th scope="col">Name</th>
                                            <th scope="col">City</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('admin.stations.filter')
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
        '{{ route('station.create') }}',
        '{{ route('station.store') }}',
        '{{ route('station.show', ':id') }}',
        '{{ route('station.edit', ':id') }}',
        '{{ route('station.update', ':id') }}',
        '{{ route('station.destroy', ':id') }}',
        'tbody',
        {
            create: 'Add Station',
            edit: 'Update Station'
        },
        '{{ route('station.index') }}',
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