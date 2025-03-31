@extends('admin.layouts.app')
@section('title', 'Profile')
@section('content')
@php
$activeTab = request('tab')?request('tab'):'basic';
@endphp
<!-- Start::row-1 -->
<div class="row mt-3">
    <div class="col-xxl-12 col-xl-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body p-0">
                <div class="d-sm-flex align-items-top p-4 border-bottom border-block-end-dashed main-profile-cover">
                    <div>
                        <span class="avatar avatar-xxl avatar-rounded online me-3">
                            <img src="../assets/images/faces/9.jpg" alt="">
                        </span>
                    </div>
                    <div class="flex-fill main-profile-info">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="fw-semibold mb-1 text-fixed-white">{{Auth::user()->fname}}&nbsp;{{Auth::user()->lname}}</h6>
                        </div>
                        <p class="mb-1 text-muted text-fixed-white op-7">{{Auth::user()->roles()->first()->name}}</p>
                        <p class="fs-12 text-fixed-white mb-4 op-5">
                            <span class="me-3"><i class="ri-building-line me-1 align-middle"></i>{{Auth::user()->code}}</span>
                        </p>
                    </div>
                </div>
                <div class="p-4 border-bottom border-block-end-dashed">
                    <p class="fs-15 mb-2 me-4 fw-semibold">Contact Information :</p>
                    <div class="text-muted">
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                <i class="ri-mail-line align-middle fs-14"></i>
                            </span>
                            {{Auth::user()->email}}
                        </p>
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                <i class="ri-phone-line align-middle fs-14"></i>
                            </span>
                            {{Auth::user()->contact}}
                        </p>
                        <p class="mb-0">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                <i class="ri-map-pin-line align-middle fs-14"></i>
                            </span>
                            {{Auth::user()->address}}
                        </p>
                    </div>
                </div>
                <div class="p-4">
                    <div class="col-xl-12">
                        <ul class="nav nav-pills mb-3 nav-justified tab-style-5 d-sm-flex d-block" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $activeTab == 'basic' ? 'active' : '' }}" id="pills-basic-info-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-basic-info" type="button" role="tab"
                                    aria-controls="pills-basic-info" aria-selected="true">Basic Info</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $activeTab == 'password' ? 'active' : '' }}" id="pills-password-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-password" type="button" role="tab"
                                    aria-controls="pills-password" aria-selected="true">Password</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane {{ $activeTab == 'basic' ? 'show active' : '' }} text-muted" id="pills-basic-info" role="tabpanel"
                                aria-labelledby="pills-basic-info-tab" tabindex="0">
                                <div class="row gy-4">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <p class="mb-2 text-muted">First Name</p>
                                        <input type="text" name="fname" class="form-control" id="fname" value="{{Auth::user()->fname}}" placeholder="first name" readonly>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <p class="mb-2 text-muted">Last Name</p>
                                        <input type="text" name="lname" class="form-control" id="lname" value="{{Auth::user()->lname}}" placeholder="last name" readonly>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <p class="mb-2 text-muted">User Name</p>
                                        <input type="text" name="username" class="form-control" id="username" value="{{Auth::user()->username}}" placeholder="User Name" readonly>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <p class="mb-2 text-muted">Role</p>
                                        <input type="text" name="code" class="form-control" id="code" value="{{Auth::user()->roles()->first()->name}}" readonly>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <p class="mb-2 text-muted">Code</p>
                                        <input type="text" name="code" class="form-control" id="code" value="{{Auth::user()->code}}" readonly>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <p class="mb-2 text-muted">Email</p>
                                        <input type="text" name="email" class="form-control" id="email" value="{{Auth::user()->email}}" placeholder="Email" readonly>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <p class="mb-2 text-muted">Contact</p>
                                        <input type="number" name="contact" class="form-control" id="contact" value="{{Auth::user()->contact}}" placeholder="Contact" readonly>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <p class="mb-2 text-muted">Nic</p>
                                        <input type="text" name="nic" class="form-control" id="nic" value="{{Auth::user()->nic}}" placeholder="Nic" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane {{ $activeTab == 'password' ? 'show active' : '' }} text-muted" id="pills-password" role="tabpanel"
                                aria-labelledby="pills-password-tab" tabindex="0">
                                <form id="Password-form" class="form" action="{{route('users.password-update')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">
                                        <div class="col-xl-4 mb-2">
                                            <div class="input-group">
                                                <input type="password" class="form-control form-control-lg" id="previous_password" placeholder="Previous Password" name="previous_password">
                                                <button class="btn btn-light" type="button" onclick="createpassword('previous_password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>

                                            </div>
                                            <span id="error-previous_password" class="text-danger"></span>

                                        </div>
                                        <div class="col-xl-4 mb-2">
                                            <div class="input-group">
                                                <input type="password" class="form-control form-control-lg" onkeyup="validatePasswords()" id="password" placeholder="New Password" name="password">
                                                <button class="btn btn-light" type="button" onclick="createpassword('password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>

                                            </div>
                                            <span id="error-password" class="text-danger"></span>

                                        </div>
                                        <div class="col-xl-4 mb-2">
                                            <div class="input-group">
                                                <input type="password" class="form-control form-control-lg" onkeyup="validatePasswords()" id="confirm_password" placeholder="Confirm Password" name="confirm_password">
                                                <button class="btn btn-light" type="button" onclick="createpassword('confirm_password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>

                                            </div>
                                            <span id="error-confirm_password" class="text-danger"></span>

                                        </div>
                                        <div class="row gy-4 mt-2">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-end">
                                                <button type="submit" name="action" value="create" class="btn btn-primary submit" id="update-button" disabled>Change</button>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End::row-1 -->

@endsection
@section('scripts')
<script src="{{ asset('js/common/crud_and_pagination.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('submit', '.form', function(e) {
            e.preventDefault();

            let form = $(this)[0];
            let formData = new FormData(form);
            let url = $(form).attr('action');
            let method = $(form).attr('method') || 'POST';

            $.ajax({
                url: url,
                type: method,
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('sscscx');

                    if (form.id == 'department-form') {
                        $('#header-department').html(response.department);
                        $('.header-department').html('<i class="ri-building-line me-1 align-middle"></i>' + response.department + '</span>');
                    }
                    toastr.success(response.success, 'Success!');
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 500) {
                        let response = xhr.responseJSON;
                        let errorSpan = $('#error-previous_password');
                        errorSpan.html("");

                        if (response && response.error) {
                            errorSpan.html(`<span class="d-block">${response.error}</span>`);
                        } else {
                            errorSpan.html(`<span class="d-block">An unexpected error occurred.</span>`);
                        }
                    } else if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        $.each(errors, function(key, messages) {
                            let errorSpan = $(`#error-${key}`);
                            if (errorSpan.length) {
                                errorSpan.html("");
                                messages.forEach(function(message) {
                                    errorSpan.append(`<span class="d-block">${message}</span>`);
                                });
                            }
                        });
                    } else {
                        toastr.error('An error occurred: ' + error, 'Error!');
                    }
                }
            });
        });
    });
    let createpassword = (type, ele) => {
        document.getElementById(type).type = document.getElementById(type).type == "password" ? "text" : "password"
        let icon = ele.childNodes[0].classList
        let stringIcon = icon.toString()
        if (stringIcon.includes("ri-eye-line")) {
            ele.childNodes[0].classList.remove("ri-eye-line")
            ele.childNodes[0].classList.add("ri-eye-off-line")
        } else {
            ele.childNodes[0].classList.add("ri-eye-line")
            ele.childNodes[0].classList.remove("ri-eye-off-line")
        }
    }

    function validatePasswords() {
        const password = $("#password").val();
        const confirmPassword = $("#confirm_password").val();

        $("#error-password").text("");
        $("#error-confirm_password").text("");

        if (password === "" || confirmPassword === "") {
            $('#update-button').prop('disabled', true);
            return;
        }

        if (password !== confirmPassword) {
            $("#error-confirm_password").text("Passwords do not match.");
            $('#update-button').prop('disabled', true);
        } else {
            $('#update-button').prop('disabled', false);
        }
    }
</script>
@endsection