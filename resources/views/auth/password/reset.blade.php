<!-- resources/views/auth/login.blade.php -->
@extends('layouts.auth')

@section('title', 'Reset')

@section('content')
<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
    @if($errors->any())
                    <div class="invalid-feedback" role="alert">
                        @foreach($errors->all() as $error)
                            <span><strong>{{ $error }}</strong></span><br>
                        @endforeach
                    </div>
    @endif
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <div class="d-flex justify-content-center py-4">
                    <a href="/" class="logo d-flex align-items-center w-auto">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="">
                        <span class="d-none d-lg-block">Online Railways Booking Portal</span>
                    </a>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="card-body p-5">
                    <div class="d-flex justify-content-center align-items-center mb-4">
                    <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>

                    </div>
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <label for="email" class="form-label text-default">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{__('translate.enter_email')}}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-xl-12">
                                <label for="password" class="form-label text-default">{{ __('New Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-xl-12">
                                <label for="password_confirmation" class="form-label text-default">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                              
                            </div>
                            <div class="col-xl-12 d-grid mt-2">
                            <button type="submit" class="btn btn-primary">{{ __('Reset Password') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>

            <div class="credits" style="color:white;">
                Designed by MSCIT TEAM PROJECT GROUP 02
            </div>

        </div>
    </div>
</section>
@endsection