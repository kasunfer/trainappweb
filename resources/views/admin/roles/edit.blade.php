@extends('admin.layouts.app')
@section('title', 'Roles & Permissions')
@section('content')
{{--@can('create_roles')--}}
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card mt-3">
            <div class="card-header justify-content-between">
                <div class="card-title">
                Edit Roles & Permissions
                </div>
            </div>
            <div class="card-body">
            <form id="roles-form" data-action="{{ route('roles.update', '__id__') }}" method="POST">
            <input type="hidden" id="role_id" value="{{$role->id}}"/>
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-4">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control @error('rolename') is-invalid @enderror" name="rolename" placeholder="Role Name" value="{{$role->name}}" readonly>
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
                                    <input type="checkbox" class="form-check-input permission-checkbox" name="permission_id[]" data-group-id="{{$permission->permission_group_id}}" value="{{$permission->name}}"  {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
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
                <button type="submit" class="btn btn-warning me-2">Update</button>
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
<script src="{{ asset('js/common/crud_and_pagination.js') }}"></script>
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
        var roleId=$('#role_id').val();
        var form = $(this);
        var actionUrl = form.data('action').replace('__id__', roleId);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: $('#roles-form').serialize(),
            beforeSend: function() {
                
            },
            success: function(response) {
                toastr.success('Role Updated Successfully');
                window.location.href='{{route("roles.index")}}';
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