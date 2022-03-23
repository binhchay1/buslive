@extends('layouts.website')

@section('content')
<!-- HEADING BREADCRUMB-->
<link rel="stylesheet" href="css/pages/history-buy.css">
<section class="bg-pentagon py-4">
    <div class="container py-3">
        <div class="row d-flex align-items-center gy-4">
            <div class="col-md-7">
                <h1 class="h2 mb-0 text-uppercase">Hồ sơ</h1>
            </div>
            <div class="col-md-5">
                <!-- Breadcrumb-->
                <ol class="text-sm justify-content-start justify-content-lg-end mb-0 breadcrumb undefined">
                    <li class="breadcrumb-item"><a class="text-uppercase" href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item text-uppercase active">Hồ sơ </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- CONTACT SECTION-->
<section class="py-5">
    <div class="container py-4">
        <div class="row gy-5">
            <div class="col-lg-9">
                <p class="lead mb-4">Lịch sử mua vé.</p>
                <div>
                    <div class="float-right">
                        <label for="time-picker">Tìm kiếm </label>
                        <input type="date" class="form-control" id="time-picker-history" onchange="setDataTicket(this.value)">
                    </div>
                </div>
                <!-- PROFILE DETAIL FORM-->
                <div style="margin-top: 100px">
                    @foreach($data as $key => $value)
                    <div id="{{ $key }}">
                        <div>
                            <p class="form-group h5">{{ $key }}</p>
                        </div>
                        <hr class="new4">

                        <div class="row">
                            @foreach($value as $history)
                            <div class="card mt-5 col-md-5" style="border: 0;">
                                <div class="card-body">
                                    <article class="card fl-left" style="width: 400px">
                                        <section class="date" style="width: 25%"> <time><span style="font-size: 15px !important">{{ $history->total_buy }} vé</span></time></section>
                                        <section class="card-cont">
                                            @if(Auth::check())
                                            <small>{{ Auth::user()->name }}</small>
                                            @else
                                            <small>Khách</small>
                                            @endif
                                            <h3 style="text-decoration-line: none; font-size: 13px !important;"></span></h3>
                                            <div class="even-date"> <i class="fa fa-calendar"></i> <span id="date-ticket" class="ml-2">  {{ $history->date }}</span> <span id="time-ticket" class="ml-2"></span> </time></div>
                                            <div class="even-info"> <i class="fa fa-map-marker"></i>
                                                <div class="ml-2">
                                                    <p style="padding: 0px;"><span>{{ $history->name_roads }}</p>
                                                </div>
                                            </div>
                                            <div class="even-info"> <i class="fa fa-barcode"></i>
                                                <div class="ml-2">
                                                    <p style="padding: 0px;"><span id="code-ticket">{{ $history->code }}</span></p>
                                                </div>
                                            </div>
                                            <div class="even-info"> <i class="fa fa-dollar-sign"></i>
                                                <div class="ml-2">
                                                    <p style="padding: 0px;"><span id="cost-ticket">{{ $history->cost * $history->total_buy }} VNĐ</span></p>
</br>
                                                    <p style="padding: 0px;"><span id="cost-ticket">{{ $history->name_garages}} </span></p>
                                                </div>
                                            </div>
                                            
                                        </section>
                                    </article>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                    <div class="d-none text-center h2 mt-5" id="empty-history" style="margin-bottom: 118px">
                        <hr class="mb-5 mt-5">
                        <p>Không có dữ liệu</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <h3 class="h4 text-uppercase lined mb-4">Quản lý tài khoản</h3>
                <nav class="nav flex-column nav-pills">
                    <a class="nav-link text-sm" href="/profile"> <i class="me-2 fas fa-user"></i><span>Thông tin cá nhân</span></a>
                    <a class="nav-link text-sm active" href="/history"> <i class="me-2 fas fa-list"></i><span>Lịch sử mua vé</span></a>
                </nav>
            </div>
        </div>
    </div>
</section>

<script>
    var data = <?php echo json_encode($data) ?>;
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="plugins/leaflet/leaflet.js"></script>
<script src="js/pages/history-buy.js"></script>
@endsection