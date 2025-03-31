@extends('admin.layouts.app')
@section('title','Edit Users')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card mt-3">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Edit User {{$user->code}}
                </div>
            </div>
            <div class="card-body">
            <form id="users-form" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="user_id" value="{{$user->id}}">
                <div class="row gy-2">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.first_name')}}</p>
                        <input type="text" name="fname" class="form-control" id="fname" value="{{$user->fname}}" placeholder="{{__('translate.enter_first_name')}}">
                    </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.last_name')}}</p>
                        <input type="text" name="lname" class="form-control" id="lname" value="{{$user->lname}}" placeholder="{{__('translate.enter_last_name')}}">
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.user_name')}}</p>
                        <input type="text" name="username" class="form-control" id="username" value="{{$user->username}}" placeholder="{{__('translate.enter_user_name')}}">
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 {{$user->roles()->first()->id==1?'d-none':''}}">
                        <p class="mb-1">{{__('translate.role')}}</p>
                        <select class="form-control js-example-basic-single" name="role" id="role">
                            @foreach($roles as $role)
                            <option value="{{$role->name}}" {{ $role->id==$user->roles()->first()->id ? 'selected' : '' }}>{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.code')}}</p>
                        <input type="text" name="code" class="form-control" id="code" value="{{$user->code}}" readonly>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.email')}}</p>
                        <input type="text" name="email" class="form-control" id="email" value="{{$user->email}}" placeholder="{{__('translate.enter_email')}}">
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.contact')}}</p>
                        <input type="number" name="contact" class="form-control" id="contact" value="{{$user->contact}}" placeholder="{{__('translate.enter_contact')}}">
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.nic')}}</p>
                        <input type="text" name="nic" class="form-control" id="nic" value="{{$user->nic}}" placeholder="{{__('translate.enter_nic')}}">
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 material_rate_div">
                    <p class="mb-1">
                    {{__('translate.display_picture')}} <span class="text--primary">(1:1)</span>
</p>
    <label class="text-center position-relative">
        <img class="img-fluid img-thumbnail image-preview" id="imagePreview"
        src="{{ isset($user->photo) && $user->photo ? $user->photo : asset('assets/images/apps/admin.png') }}" 
            alt="Uploaded Image Preview" />
        <div class="icon-file-group">
            <div class="icon-file">
                <input type="file" name="image" id="imageInput" class="custom-file-input" 
                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" onchange="previewImage(event)">
                <i class="tio-edit"></i>
            </div>
            <button class="btn action-btn btn-outline-danger remove-button" type="button" onclick="removeImage()">
                <i class="ri-delete-bin-line"></i>
            </button>
        </div>
    </label>
    <input type="hidden" name="remove_image" id="removeImageFlag" value="0">
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
        var userId=$('#user_id').val();
    console.log($('#users-form').serialize());
    var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('users.update', ':id') }}".replace(':id', userId),
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                
            },
            success: function(response) {
                toastr.success('User Updated Successfully');
                    window.location.href='{{route("users.index")}}';
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
    function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            $('.remove-button').removeClass('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    const preview = document.getElementById('imagePreview');
    const input = document.getElementById('imageInput');
    const removeImageFlag = document.getElementById('removeImageFlag');

    preview.src = '{{ asset('assets/images/apps/admin.png') }}';
    input.value = '';
    $('.remove-button').addClass('d-none');
    removeImageFlag.value = "1";
}
</script>
@endsection