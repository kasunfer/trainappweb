@extends('admin.layouts.app')
@section('title','Add Users')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card mt-3">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Add New User
                </div>
            </div>
            <div class="card-body">
            <form id="users-form" action="" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="row gy-2">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.first_name')}}</p>
                        <input type="text" name="fname" class="form-control" id="fname" placeholder="{{__('translate.enter_first_name')}}">
                        <span class="text-danger error" id="error-fname"></span>
                    </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.last_name')}}</p>
                        <input type="text" name="lname" class="form-control" id="lname" placeholder="{{__('translate.enter_last_name')}}">
                        <span class="text-danger error" id="error-lname"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.user_name')}}<span class="text-danger"> *</span></p>
                        <input type="text" name="username" class="form-control" id="username" placeholder="{{__('translate.enter_user_name')}}">
                        <span class="text-danger error" id="error-username"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.role')}}<span class="text-danger"> *</span></p>
                        <select class="form-control js-example-basic-single" name="role" id="role">
                            <option value="" disabled selected>Select an Option</option>
                            @foreach($roles as $role)
                            <option value="{{$role->name}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error" id="error-role"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.code')}}</p>
                        <input type="text" name="code" class="form-control" id="code" value="{{ old('code') == "" ? $maxId : old('code') }}" readonly>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.email')}}<span class="text-danger"> *</span></p>
                        <input type="text" name="email" class="form-control email" id="email" placeholder="{{__('translate.enter_email')}}">
                        <span class="text-danger error" id="error-email"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.contact')}}</p>
                        <input type="number" name="contact" class="form-control" id="contact" placeholder="{{__('translate.enter_contact')}}">
                        <span class="text-danger error" id="error-contact"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.nic')}}</p>
                        <input type="text" name="nic" class="form-control" id="nic" placeholder="{{__('translate.enter_nic')}}">
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.password')}}<span class="text-danger"> *</span></p>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="signin-password" placeholder="{{__('translate.enter_password')}}" value="{{ old('password') }}"><button  class="btn btn-light" type="button" onclick="togglePasswordVisibility('signin-password', this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                        </div>
                        <span class="text-danger error" id="error-password"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 material_rate_div">
                    <p class="mb-1">
                    {{__('translate.display_picture')}} <span class="text--primary">(1:1)</span>
                    </p>
    <label class="text-center position-relative">
        <img class="img-fluid img-thumbnail image-preview" id="imagePreview"
        src="{{ isset($user->dp) && $user->dp ? $user->dp : asset('assets/images/apps/admin.png') }}" 
            alt="Uploaded Image Preview" />
        <div class="icon-file-group">
            <div class="icon-file">
                <input type="file" name="dp" id="imageInput" class="custom-file-input" 
                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" onchange="previewImage(event)">
                <i class="tio-edit"></i>
            </div>
            <button class="btn action-btn btn-outline-danger remove-button d-none" type="button" onclick="removeImage()">
                <i class="ri-delete-bin-line"></i>
            </button>
        </div>
    </label>
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
            url: "{{ route('users.store') }}",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('.error').text('');
                $('.input-error').removeClass('input-error');
            },
            success: function(response) {
                toastr.success('User Created Successfully');
                if (response.action==='create_exit') {
                    window.location.href='{{route("users.index")}}';
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
    function togglePasswordVisibility(inputId, button) {
    const passwordInput = document.getElementById(inputId);
    const icon = button.querySelector('i');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('ri-eye-off-line');
        icon.classList.add('ri-eye-line');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('ri-eye-line');
        icon.classList.add('ri-eye-off-line');
    }
}
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
    
    preview.src = '{{ asset('assets/images/apps/admin.png') }}';
    input.value = '';
    $('.remove-button').addClass('d-none');
}
</script>
@endsection