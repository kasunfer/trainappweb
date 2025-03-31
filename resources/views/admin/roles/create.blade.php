@extends('admin.layouts.app')
@section('title', 'Roles & Permissions')
@section('content')
{{--@can('create_roles')--}}
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card mt-3">
            <div class="card-header justify-content-between">
                <div class="card-title">
                Roles & Permissions
                </div>
            </div>
            <div class="card-body">
            <form action="{{route('roles.store')}}" method="POST" id="roles-form">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-4">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control @error('rolename') is-invalid @enderror" name="rolename" placeholder="{{__('translate.enter_role_name')}}" value="{{ old('rolename') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if($permissionGroups->count()>0)
                    <div class="row">
                        @foreach($permissionGroups as $permissionGroup)
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                            <label class="form-check-label">
                                <input class="form-check-input group-checkbox" type="checkbox" data-group-id="{{$permissionGroup->id}}">
                                <span class="form-check-label" style="font-weight: bold;">{{ucwords(str_replace('-', ' ', $permissionGroup->name))}}</span>
                            </label>
                            <div class="custom-controls-stacked">
                                @if($permissionGroup->permissions->count() > 0)
                                @foreach($permissionGroup->permissions as $permission)
                                <label class="form-check-label mt-2">
                                    <input type="checkbox" class="form-check-input permission-checkbox" name="permission_id[]" data-group-id="{{$permission->permission_group_id}}" value="{{$permission->name}}"  @if(in_array($permission->name, old('permission_id', []))) checked @endif>
                                    <span class="form-check-label">{{ucwords(str_replace('-', ' ', $permission->name))}}</span>
                                </label><br>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @error('permission_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end">
                <button type="submit" name="action" value="create" class="btn btn-primary me-2">Create</button>
            <button type="submit" name="action" value="create_exit" class="btn btn-secondary">Create & Exit</button>
        </div>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>
{{--@endcan--}}
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.group-checkbox').change(function() {
            var groupId = $(this).data('group-id');
            var isChecked = $(this).prop('checked');
            $('.permission-checkbox').each(function() {
                console.log('per', $(this).data('group-id'));
                if ($(this).data('group-id') == groupId) {
                    $(this).prop('checked', isChecked);
                }
            });
        });
    });
    $('#roles-form').submit(function(e) {
        e.preventDefault();
        var action = $('button[name="action"]').filter(':focus').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('roles.store') }}",
            method: 'POST',
            data: $('#roles-form').serialize()+'&action=' + action,
            beforeSend: function() {
                
            },
            success: function(response) {
                toastr.success('Role Created Successfully');
                if (response.action==='create_exit') {
                    window.location.href='{{route("roles.index")}}';
                } else {
                    $('#roles-form')[0].reset();  
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
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