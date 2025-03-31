<!-- resources/views/auth/login.blade.php -->
@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
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
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                            <p class="text-center small">Enter your credentials to login</p>
                        </div>

                        <form class="row g-3 needs-validation" action="{{route('admin.login')}}" method="POST">
                            @csrf

                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text">@</span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Login</button>
                            </div>
                            <div class="col-12 text-center mt-2">
                                <a href="{{ route('password.request') }}">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="credits" style="color:white;">
                    Designed by MSCIT TEAM PROJECT GROUP 02
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
