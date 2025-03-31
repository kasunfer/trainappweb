<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
<head>
    <title>@yield('title', 'Home')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Poppins:300,300i,400,500,600,700,800,900,900i%7CPT+Serif:400,700">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css')}}">

    <style>
        .ie-panel {
            display: none;
            background: #212121;
            padding: 10px 0;
            box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);
            clear: both;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {
            display: block;
        }
        .hover-dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }
    </style>

    @stack('styles')
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="ie-panel">
        <a href="http://windows.microsoft.com/en-US/internet-explorer/">
            <img src="{{ asset('images/ie8-panel/warning_bar_0000_us.jpg') }}" height="42" width="820" alt="You are using an outdated browser. Upgrade for free today.">
        </a>
    </div>

    <div class="preloader">
        <div class="preloader-body">
            <div class="cssload-container">
                <div class="cssload-speeding-wheel"></div>
            </div>
            <p>Loading...</p>
        </div>
    </div>

    <div class="page">
        <!-- Page Header -->
        @include('frontend.layouts.header')

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Page Footer -->
        @include('frontend.layouts.footer')
    </div>

    <div class="snackbars" id="form-output-global"></div>
    <!-- Scripts -->
    <script src="{{ asset('frontend/js/core.min.js') }}"></script>
    <script src="{{ asset('frontend/js/script.js') }}"></script>
    @yield('scripts')

</body>
</html>
