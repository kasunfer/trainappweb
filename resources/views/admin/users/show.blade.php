@extends('admin.layouts.app')
@section('title','Show User')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card mt-3">
            <div class="card-header justify-content-between">
                <div class="card-title">
                {{$user->fname}}&nbsp;{{$user->lname}}&nbsp;{{$user->code}}
                </div>
            </div>
            <div class="card-body">
            <input type="hidden" id="user_id" value="{{$user->id}}">
                <div class="row gy-2">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.first_name')}}</p>
                        <input type="text" name="fname" class="form-control" id="fname" value="{{$user->fname}}" placeholder="first name" readonly>
                    </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.last_name')}}</p>
                        <input type="text" name="lname" class="form-control" id="lname" value="{{$user->lname}}" placeholder="last name" readonly>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.user_name')}}</p>
                        <input type="text" name="username" class="form-control" id="username" value="{{$user->username}}" placeholder="User Name" readonly>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.role')}}</p>
                        <input type="text" name="code" class="form-control" id="code" value="{{$user->roles()->first()->name}}" readonly>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.code')}}</p>
                        <input type="text" name="code" class="form-control" id="code" value="{{$user->code}}" readonly>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.email')}}</p>
                        <input type="text" name="email" class="form-control" id="email" value="{{$user->email}}" placeholder="Email" readonly>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.contact')}}</p>
                        <input type="number" name="contact" class="form-control" id="contact" value="{{$user->contact}}" placeholder="Contact" readonly>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <p class="mb-1">{{__('translate.nic')}}</p>
                        <input type="text" name="nic" class="form-control" id="nic" value="{{$user->nic}}" placeholder="Nic" readonly>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 material_rate_div">
                    <p class="mb-1">
                    {{__('translate.display_picture')}} <span class="text--primary">(1:1)</span>
</p>
    <label class="text-center position-relative">
        <img class="img-fluid img-thumbnail image-preview" id="imagePreview"
        src="{{ isset($user->dp) && $user->dp ? $user->dp : asset('assets/images/apps/admin.png') }}" 
            alt="Uploaded Image Preview" />
    </label>
</div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-end">
                        <a href="{{route('users.edit',$user->id)}}"><button type="submit" name="action" value="create" class="btn btn-primary submit">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection