@extends('admin.layouts.app')
@section('title', 'Users List')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-header justify-content-between">
            <div class="d-flex justify-content-between align-items-center">
                <div class="card-title">
                    Users
                </div>
                @can('create-user')
                <div class="prism-toggle">
                    <a href="{{ route('users.create') }}"><button class="btn btn-sm btn-primary forProductType">
                        <i class="ri-add-line align-middle me-2 d-inline-block"></i>
                        <span class="text">{{__('translate.add_user')}}</span>
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
                                            <th scope="col">Code</th>
                                            <th scope="col">Email Address</th>
                                            <th scope="col">Contact Number</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('admin.users.filter')
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
        '{{ route('users.create') }}',
        '{{ route('users.store') }}',
        '{{ route('users.show', ':id') }}',
        '{{ route('users.edit', ':id') }}',
        '{{ route('users.update', ':id') }}',
        '{{ route('users.destroy', ':id') }}',
        'tbody',
        {
            create: 'Add Role',
            edit: 'Update Role'
        },
        '{{ route('users.index') }}',
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
            url: "{{ route('users.status', ':status') }}".replace(':status', id),
            method: 'POST',
            data: {
                id:id,
                isActive: isActive,
            },
            beforeSend: function() {
                
            },
            success: function(response) {
                toastr.success('User Status Updated Successfully');
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