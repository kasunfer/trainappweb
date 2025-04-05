<header class="section page-header">
    <div class="rd-navbar-wrap">
        <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed">
            <div class="rd-navbar-main-outer">
                <div class="rd-navbar-main">
                    <!-- RD Navbar Panel -->
                    <div class="rd-navbar-panel">
                        <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                        <div class="rd-navbar-brand">
                            <a href="/">
                                <img class="brand-logo-light" src="{{asset('frontend/images/logo.png')}}" alt="" style="width: 50px; height: auto;"/>
                            </a>
                        </div>
                    </div>
                    <div class="rd-navbar-main-element">
                        <div class="rd-navbar-nav-wrap">
                            <ul class="rd-navbar-nav">
                                <li class="rd-nav-item"><a class="rd-nav-link" href="#">Home</a></li>
                                <li class="rd-nav-item"><a class="rd-nav-link" href="#about">{{__('menu.about-us')}}</a></li>
                                <li class="rd-nav-item"><a class="rd-nav-link" href="#contact">{{__('menu.contact-us')}}</a></li>
                                <li class="rd-nav-item"><a class="rd-nav-link" href="#news">News</a></li>
                                <li class="rd-nav-item"><a class="rd-nav-link" href="#terms">Terms & Conditions</a></li>
                                <li class="rd-nav-item"><a class="button button-white button-sm me-3" href="{{route('bookingfront')}}">Book Now</a></li>
                            </ul>
                        </div>
                    </div>
                    

                </div>
            </div>
        </nav>
    </div>
</header>
