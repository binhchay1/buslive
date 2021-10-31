<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Google fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700">
    <!-- Swiper slider-->
    <link rel="stylesheet" href="plugins/swiper/swiper-bundle.min.css">
    <!-- Choices.js [Custom select]-->
    <link rel="stylesheet" href="plugins/choices.js/public/assets/styles/choices.css">
    <!-- Theme stylesheet-->
    <link rel="stylesheet" href="css/universal/style.default.css" id="theme-stylesheet">
    <link rel="stylesheet" href="css/pages/main.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/universal/custom.css">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <!-- Favicon and apple touch icons-->
    <link rel="icon" href="{{ URL::to('img/icon.png') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="57x57" href="img/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/apple-touch-icon-152x152.png">
    <!-- Tweaks for older IEs-->

</head>

<body>
    <div class="wide" id="all">
        <!-- Top bar-->
        <div class="top-bar py-2" id="topBar" style="background: #555">
            <div class="container px-lg-0 text-light py-1">
                <div class="row d-flex align-items-center">
                    <div class="col-md-6 d-md-block d-none">
                        <p class="mb-0 text-xs">Contact us on 024.3976.3585 or admin@buslive.com.</p>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-md-end justify-content-between">
                            <ul class="list-inline d-block d-md-none mb-0">
                                <li class="list-inline-item"><a class="text-xs" href="#"><i class="fa fa-phone"></i></a></li>
                                <li class="list-inline-item"><a class="text-xs" href="#"><i class="fa fa-envelope"></i></a></li>
                            </ul>
                            @if (Route::has('login'))
                            <ul class="list-inline mb-0">
                                @auth
                                <li>
                                    <div class="user-panel d-flex">
                                        <div class="info dropdown">
                                            <a class="d-block dropdown-toggle nav-link" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="/profile">Profile</a>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button class="dropdown-item">{{ __('Sign out') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @else
                                <li class="list-inline-item"><a href="{{ route('login') }}" class="text-xs text-uppercase fw-bold text-reset"><i class="fas fa-door-open me-2"></i><span class="d-none d-md-inline-block">Sign In</span></a></li>
                                @if (Route::has('register'))
                                <li class="list-inline-item"><a href="{{ route('register') }}" class="text-xs text-uppercase fw-bold text-reset"><i class="fas fa-user me-2"></i><span class="d-none d-md-inline-block">Sign Up</span></a></li>
                                @endif
                                @endauth
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Top bar end-->
        <div class="alert mb-3 alert-success d-none" role="alert" id="alert-thank"> <strong>Thank you! </strong> Reply soon.</div>
        <!-- Navbar Sticky-->
        <header class="nav-holder make-sticky">
            <div class="navbar navbar-light bg-white navbar-expand-lg py-0" id="navbar">
                <div class="container py-3 py-lg-0 px-lg-0">
                    <!-- Navbar brand--><a class="navbar-brand" href="/"><img class="d-none d-md-inline-block" src="img/logo.png"><img class="d-inline-block d-md-none" src="img/logo-small.png" alt="Universal logo"><span class="sr-only">Universal - go to homepage</span></a>
                    <!-- Navbar toggler-->
                    <button class="navbar-toggler text-primary border-primary" type="button" data-bs-toggle="collapse" data-bs-target="#navigationCollapse" aria-controls="navigationCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="sr-only">Toggle navigation</span><i class="fas fa-align-justify"></i></button>
                    <!-- Collapsed Navigation    -->
                    <div class="collapse navbar-collapse" id="navigationCollapse">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <!-- homepage dropdown-->
                            <li class="nav-item dropdown"><a class="nav-link" href="/">Home</a></li>
                            <!-- megamenu [features]-->
                            <li class="nav-item dropdown menu-small"><a class="nav-link dropdown-toggle" id="featuresMegamenu" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Ticket</a>
                                <ul class="dropdown-menu megamenu p-4" aria-labelledby="featuresMegamenu">
                                    <li>
                                        <div class="row">
                                            <div class="card">

                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- megamenu [portfolio]-->
                            <li class="nav-item dropdown menu-large"><a class="nav-link dropdown-toggle" id="portfolioMegamenu" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Portfolio</a>
                                <ul class="dropdown-menu megamenu p-4" aria-labelledby="portfolioMegamenu">
                                    <li>
                                        <div class="row">
                                            <div class="col-lg-6"><img class="img-fluid d-none d-lg-block" src="img/template-homepage.png" alt=""></div>
                                            <div class="col-lg-3 col-md-6">
                                                <h5 class="text-dark text-uppercase pb-2 border-bottom">Portfolio</h5>
                                                <ul class="list-unstyled mb-3">
                                                    <li class="nav-item"><a class="nav-link-sub py-2 text-uppercase" href="portfolio-2.html">2
                                                            columns</a></li>
                                                    <li class="nav-item"><a class="nav-link-sub py-2 text-uppercase" href="portfolio-no-space-2.html">2 columns with negative space</a></li>
                                                    <li class="nav-item"><a class="nav-link-sub py-2 text-uppercase" href="portfolio-3.html">3
                                                            columns</a></li>
                                                    <li class="nav-item"><a class="nav-link-sub py-2 text-uppercase" href="portfolio-no-space-3.html">3 columns with negative space</a></li>
                                                    <li class="nav-item"><a class="nav-link-sub py-2 text-uppercase" href="portfolio-4.html">4
                                                            columns</a></li>
                                                    <li class="nav-item"><a class="nav-link-sub py-2 text-uppercase" href="portfolio-no-space-4.html">4 columns with negative space</a></li>
                                                    <li class="nav-item"><a class="nav-link-sub py-2 text-uppercase" href="portfolio-detail.html">Portfolio - detail</a></li>
                                                    <li class="nav-item"><a class="nav-link-sub py-2 text-uppercase" href="portfolio-detail-2.html">Portfolio - detail 2</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <h5 class="text-dark text-uppercase pb-2 border-bottom">About</h5>
                                                <ul class="list-unstyled mb-3">
                                                    <li class="nav-item"><a class="nav-link-sub py-2 text-uppercase" href="about.html">About
                                                            us</a></li>
                                                    <li class="nav-item"><a class="nav-link-sub py-2 text-uppercase" href="team.html">Our team</a>
                                                    </li>
                                                    <li class="nav-item"><a class="nav-link-sub py-2 text-uppercase" href="team-member.html">Team
                                                            member</a></li>
                                                    <li class="nav-item"><a class="nav-link-sub py-2 text-uppercase" href="services.html">Services</a></li>
                                                </ul>
                                                <h5 class="text-dark text-uppercase pb-2 border-bottom">Marketing</h5>
                                                <ul class="list-unstyled">
                                                    <li class="nav-item"><a class="nav-link-sub py-2 text-uppercase" href="packages.html">Packages</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- megamenu [all pages]-->
                            <li class="nav-item"><a class="nav-link" id="allPagesMegamenu" href="/testapi">All pages</a>
                            </li>
                            <!-- dropdown menu [contact]-->
                            <li class="nav-item"><a class="nav-link" id="contactMegamenu" href="/contact">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <div>
            @yield('content')
        </div>

        <footer>
            <!-- MAIN FOOTER-->
            <div class="bg-gray-700 text-white">
                <div class="container py-4">
                    <div class="row gy-2">
                        <div class="col-lg-6">
                            <h4 class="mb-3 text-uppercase">About Us</h4>
                            <p class="text-sm mb-3 text-gray-500">We want to serve all of your trips perfectly. That's exactly what we built the BusLive system</p>
                            <hr>
                            <h4 class="h6 text-uppercase mt-2">Join Us!</h4>
                            <form>
                                <div class="input-group border mb-3">
                                    <input class="form-control bg-none border-0 shadow-0 text-white" type="email" placeholder="Email address" aria-label="Email address" aria-describedby="button-submit">
                                    <button class="btn btn-outline-light bg-none border-0" id="button-submit" type="button"><i class="fas fa-paper-plane"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="mb-3 text-uppercase">Contact</h4>
                            <p class="text-uppercase text-sm text-gray-500">5 Lê Thánh Tông, Phan Chu Trinh, Hoàn Kiếm, Hà Nội</p>
                            <p class="text-uppercase text-sm text-gray-500">Phone: <strong>024.3976.3585</strong></p>
                            <p class="text-uppercase text-sm text-gray-500">Fax: <strong>024.3976.1996</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- COPYRIGHTS                -->
            <div class="bg-dark py-2">
                <div class="container">
                    <div class="row align-items-cenrer gy-3 text-center">
                        <div class="col-md-6 text-md-start">
                            <p class="mb-0 text-sm text-gray-500">&copy; 2021. <strong>BusLive</strong> / All rights reserved. <b>Version</b> 1.0.0</p>
                        </div>
                        <div class="col-md-6 text text-md-end">
                            <p class="mb-0 text-sm text-gray-500">Template designed by <a href="https://bootstrapious.com" target="_blank">Bootstrapious</a> &amp; <a href="https://hikershq.com/" target="_blank">HHQ</a> </p>

                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- JavaScript files-->
    <script src="plugins/bootstrapuniversal/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/waypoints/lib/noframework.waypoints.js"></script>
    <script src="plugins/swiper/swiper-bundle.min.js"></script>
    <script src="plugins/choices.js/public/assets/scripts/choices.js"></script>
    <script src="js/universal/theme.js"></script>
    <script>
        // ------------------------------------------------------- //
        //   Inject SVG Sprite - 
        //   see more here 
        //   https://css-tricks.com/ajaxing-svg-sprite/
        // ------------------------------------------------------ //
        function injectSvgSprite(path) {

            var ajax = new XMLHttpRequest();
            ajax.open("GET", path, true);
            ajax.send();
            ajax.onload = function(e) {
                var div = document.createElement("div");
                div.className = 'd-none';
                div.innerHTML = ajax.responseText;
                document.body.insertBefore(div, document.body.childNodes[0]);
            }
        }
        // this is set to BootstrapTemple website as you cannot 
        // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
        // while using file:// protocol
        // pls don't forget to change to your domain :)
        injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg');
    </script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</body>

</html>