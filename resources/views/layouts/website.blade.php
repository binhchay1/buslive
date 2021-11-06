<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Buslive') }}</title>
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
    <link rel="icon" href="{{ URL::to('img/icon.png') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    </script>

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
                        <p class="mb-0 text-xs">Liên hệ với chúng tôi với 024.3976.3585 or admin@buslive.com.</p>
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
                                <li class="list-inline-item"><a href="{{ route('login') }}" class="text-xs text-uppercase fw-bold text-reset"><i class="fas fa-door-open me-2"></i><span class="d-none d-md-inline-block">Đăng nhập</span></a></li>
                                @if (Route::has('register'))
                                <li class="list-inline-item"><a href="{{ route('register') }}" class="text-xs text-uppercase fw-bold text-reset"><i class="fas fa-user me-2"></i><span class="d-none d-md-inline-block">Đăng ký</span></a></li>
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
        <div class="alert mb-3 alert-success d-none" role="alert" id="alert-thank"> <strong>Cám ơn! </strong> Chúng tôi sẽ trả lời trong thời gian sớm nhất.</div>
        <div class="alert mb-3 alert-success d-none" role="alert" id="alert-ticket"></div>
        @if(session('success'))
        <div class="alert mb-3 alert-success" role="alert" id="alert-success">Đặt vé thành công</div>
        @endif
        <!-- Navbar Sticky-->
        <header class="nav-holder make-sticky">
            <div class="navbar navbar-light bg-white navbar-expand-lg py-0" id="navbar">
                <div class="container py-3 py-lg-0 px-lg-0">
                    <!-- Navbar brand--><a class="navbar-brand" href="/"><img class="d-none d-md-inline-block" src="img/logo.png"><img class="d-inline-block d-md-none" src="img/logo-small.png" alt="Universal logo"><span class="sr-only">Buslive - về trang chủ</span></a>
                    <!-- Navbar toggler-->
                    <button class="navbar-toggler text-primary border-primary" type="button" data-bs-toggle="collapse" data-bs-target="#navigationCollapse" aria-controls="navigationCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="sr-only">Thu gọn</span><i class="fas fa-align-justify"></i></button>
                    <!-- Collapsed Navigation    -->
                    <div class="collapse navbar-collapse" id="navigationCollapse">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <!-- homepage dropdown-->
                            <li class="nav-item dropdown"><a class="nav-link" href="/">Trang chủ</a></li>
                            <!-- megamenu [features]-->
                            <li class="nav-item dropdown menu-small"><a class="nav-link dropdown-toggle" id="featuresMegamenu" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Vé</a>
                                <ul class="dropdown-menu megamenu p-4" aria-labelledby="featuresMegamenu" id="book-ticket">
                                    <li>
                                        <div class="row">
                                            <div class="card">
                                                <div class="mb-3">
                                                    <label for="ticket-from" class="form-label">Xuất phát</label>
                                                    <select class="form-control" name="ticket-from" id="ticket-from" required>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="ticket-to" class="form-label">Đến</label>
                                                    <select class="form-control" name="ticket-to" id="ticket-to" required>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="ticket-to" class="form-label">Ngày đi</label>
                                                    <input type="date" id="txtDate" class="end_date" required />
                                                </div>
                                                <div class="form-group text-danger mb-2" id="error-book"></div>
                                                <button class="btn btn-primary mb-2" onclick="bookTicket()">Đặt vé</button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- dropdown menu [contact]-->
                            <li class="nav-item"><a class="nav-link" id="contactMegamenu" href="/contact">Liên hệ</a>
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
                            <h4 class="mb-3 text-uppercase">Về chúng tôi</h4>
                            <p class="text-sm mb-3 text-gray-500">Chúng tôi muốn phát triển 1 hệ thống bán vé chuyên nghiệp nhất Việt Nam. Đó là </p>
                            <hr>
                            <h4 class="h6 text-uppercase mt-2">Đăng ký để nhận thêm thông tin!</h4>
                            <form>
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
                            <p class="mb-0 text-sm text-gray-500">&copy; 2021. <strong>BusLive</strong> / Đã đăng ký Bản quyền. <b>Phiên bản</b> 1.0.0</p>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="plugins/jquery-ui/jquery-ui-1.13.0.custom/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $(function() {
                let dtToday = new Date();

                let month = dtToday.getMonth() + 1;
                let day = dtToday.getDate();
                let year = dtToday.getFullYear();
                if (month < 10)
                    month = '0' + month.toString();
                if (day < 10)
                    day = '0' + day.toString();

                let maxDate = year + '-' + month + '-' + day;;

                $('#txtDate').attr('min', maxDate);
                $('[data-toggle="tooltip"]').tooltip();

                $("#alert-success").fadeTo(2000, 500).slideUp(500, function() {
                    $("#alert-success").slideUp(500);
                    $("#alert-success").removeClass("d-block").addClass("d-none");
                });
            });
        });

        let url = '/get-city';
        $.ajax({
            type: "GET",
            url: url,
            success: function(response) {
                for (i = 0; i < response.length; i++) {
                    $("#ticket-from").append("<option value='" + response[i] + "'>" + response[i] + "</option>");
                    $("#ticket-to").append("<option value='" + response[i] + "'>" + response[i] + "</option>");
                }
            }
        });

        function bookTicket() {
            let from = document.getElementById("ticket-from");
            let textFrom = from.options[from.selectedIndex].text;
            let to = document.getElementById("ticket-to");
            let textTo = to.options[to.selectedIndex].text;
            let date = document.getElementById("txtDate");
            let today = new Date();
            let bookDate = new Date(date);

            if (textFrom == textTo) {
                error = 'Điểm đến và điểm đi giống nhau!';
                document.getElementById("error-book").innerHTML = error;
                $("#book-ticket").click(function(e) {
                    e.stopPropagation();
                })
                return;
            }

            let url = '/ticket?from=' + textFrom + '&to=' + textTo + '&date=' + date.value;

            window.location.replace(url);
        }
    </script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</body>

</html>