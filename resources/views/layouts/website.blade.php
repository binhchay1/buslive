<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Bus Ticket') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Google fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700">
    <!-- Swiper slider-->
    <link rel="stylesheet" href="plugins/swiper/swiper-bundle.min.css">
    <!-- Choices.js [Custom select]-->
    <link rel="stylesheet" href="plugins/choices.js/public/assets/styles/choices.css">
    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
    <!-- Theme stylesheet-->
   
    <link rel="stylesheet" href="css/universal/style.default.css" id="theme-stylesheet">
    <link rel="stylesheet" href="css/pages/main.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/universal/custom.css">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <!-- Favicon and apple touch icons-->
    <link rel="icon" href="{{ URL::to('img/logo_icon.ico') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </script>
    <!-- Tweaks for older IEs-->

</head>

<body>
    <div class="wide" id="all">
        <!-- Top bar-->
        <div class="top-bar py-2" id="topBar" style="background: rgba(0, 97, 197, 0.11)">
            <div class="container px-lg-0 text-light py-1">
                <div class="row d-flex align-items-center">
                    <div class="col-md-4 d-md-block d-none">
                        <p class=" text_custom text-danger" style="margin-top: 17px;margin-left: -36px">SIÊU SALE 27.12 SẼ KẾT THÚC SAU</p>
                    </div>
                    <div class="col-md-5 d-md-block d-none" style="margin-left: -126px;" id="count-down-time">
                        <button type="button" class="btn btn-outline-secondary" id="button-countdown-days"></button>
                        <button type="button" class="btn btn-outline-secondary" id="button-countdown-hours"></button>
                        <button type="button" class="btn btn-outline-secondary" id="button-countdown-mins"></button>
                        <button type="button" class="btn btn-outline-secondary" id="button-countdown-seconds"></button>
                    </div>
                    <div class="col-md-3" style="margin-left:126px">
                        <div class="d-flex justify-content-md-end justify-content-between">
                            <ul class="list-inline d-block d-md-none mb-0">
                                <li class="list-inline-item"><a class="text-xs" href="#"><i class="fa fa-phone"></i></a></li>
                                <li class="list-inline-item"><a class="text-xs" href="#"><i class="fa fa-envelope"></i></a></li>
                            </ul>
                            @if (Route::has('login'))
                            <ul class="list-inline mb-0">
                                @auth
                                <li class="list-inline-item text-danger">
                                    <div class="user-panel d-flex">
                                        <div class="info dropdown">
                                            <a class="d-block dropdown-toggle nav-link" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="/profile">Hồ sơ</a>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button class="dropdown-item">{{ __('Đăng xuất') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @else
                                <li class="list-inline-item text-danger"><a href="{{ route('login') }}" class="text-xs text-uppercase fw-bold text-reset"><i class="fas fa-door-open me-2"></i><span class="d-none d-md-inline-block ">Đăng nhập</span></a></li>
                                @if (Route::has('register'))
                                <li class="list-inline-item text-danger"><a href="{{ route('register') }}" class="text-xs text-uppercase fw-bold text-reset"><i class="fas fa-user me-2"></i><span class="d-none d-md-inline-block">Đăng ký</span></a></li>
                                @endif
                                @endauth
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="top-bar py-2" id="topBar" style="background: rgb(255, 197, 47);height: 40px;">
            <div class="container px-lg-0 text-light py-1">
                <div class="row d-flex align-items-center">
                    <div class="col-md-12 d-md-block d-none">
                        <p class=" text_custom text-danger" style="text-align: center;font-size: 14px;">Cập nhật các thông tin mới nhất về dịch Covid-19 trước khi di chuyển. <a href="https://covid19.gov.vn/">Xem chi tiết...</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Top bar end-->
        <div class="alert mb-3 alert-success d-none" role="alert" id="alert-thank"> <strong>Cám ơn! </strong> Chúng tôi sẽ trả lời trong thời gian sớm nhất.</div>
        <div class="alert mb-3 alert-success d-none" role="alert" id="alert-ticket"></div>
        @if(session('success'))
        <div class="alert mb-3 alert-success" role="alert" id="alert-success" style="margin-top:90px;">{{ session('success') }}</div>
        @endif

        <!-- Navbar Sticky-->
        <header class="nav-holder make-sticky">
            <div class="navbar navbar-light bg-white navbar-expand-lg py-0" id="navbar">
                <div class="container py-3 py-lg-0 px-lg-0">
                    <!-- Navbar brand--><a class="navbar-brand" href="/">
                        <img class="d-none d-md-inline-block" src="img/logo-removebg.png" style="max-width: 45%;height: auto;margin-left: -98px;"><span class="sr-only">Bus Ticket - về trang chủ</span></a>
                    <!-- Navbar toggler-->
                    <button class="navbar-toggler text-primary border-primary" type="button" data-bs-toggle="collapse" data-bs-target="#navigationCollapse" aria-controls="navigationCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="sr-only">Thu gọn</span><i class="fas fa-align-justify"></i></button>
                    <!-- Collapsed Navigation    -->
                    <div class="collapse navbar-collapse" id="navigationCollapse">
                        <ul class="navbar-nav ms-auto mb-6 mb-lg-0">
                            <li class="nav-item dropdown"><a class="nav-link" href="/">Trang chủ</a></li>
                            <li class="nav-item"><a class="nav-link" id="contactMegamenu" href="/rentcar">Thuê xe</a>
                            <li class="nav-item"><a class="nav-link" id="contactMegamenu" href="/partner">Trở thành đối tác</a>
                            <li class="nav-item"><a class="nav-link" id="contactMegamenu" href="/contact">Liên hệ</a>
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
                            <h4 class="mb-3 text-uppercase">Về chúng tôi</h4>
                            <p class="text-sm mb-3 text-gray-500">Chúng tôi muốn phát triển 1 hệ thống bán vé chuyên nghiệp nhất Việt Nam. Đó là </p>
                            <hr>
                            <h4 class="h6 text-uppercase mt-2">Đăng ký để nhận thêm thông tin!</h4>
                            <form id="send-mail-only-footer">
                                <div class="input-group border mb-3">
                                    <input class="form-control bg-none border-0 shadow-0 text-white" type="email" placeholder="Email address" aria-label="Email address" aria-describedby="button-submit">
                                    <button class="btn btn-outline-light bg-none border-0" id="button-submit" type="button"><i class="fas fa-paper-plane"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="mb-3 text-uppercase">Liên hệ</h4>
                            <p class="text-uppercase text-sm text-gray-500">5 Lê Thánh Tông, Phan Chu Trinh, Hoàn Kiếm, Hà Nội</p>
                            <p class="text-uppercase text-sm text-gray-500">Số điện thoại: <strong>024.3976.3585</strong></p>
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
                            <p class="mb-0 text-sm text-gray-500">&copy; 2021. <strong>Bus Ticket</strong> / Đã đăng ký Bản quyền. <b>Phiên bản</b> 1.0.0</p>
                        </div>
                        <div class="col-md-6 text text-md-end">
                            <p class="mb-0 text-sm text-gray-500">Thư viện được thiết kế bởi <a href="https://bootstrapious.com" target="_blank">Bootstrapious</a> &amp; <a href="https://hikershq.com/" target="_blank">HHQ</a> </p>
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
    <script src="js/pages/main.js"></script>
    <script src="plugins/jquery-ui/jquery-ui-1.13.0.custom/jquery-ui.min.js"></script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</body>

</html>