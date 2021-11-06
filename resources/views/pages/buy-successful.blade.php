@extends('layouts.website')

@section('content')
<!-- HEADING BREADCRUMB-->
<section class="bg-pentagon py-4">
    <div class="container py-3">
        <div class="row d-flex align-items-center gy-4">
            <div class="col-md-7">
                <h1 class="h2 mb-0 text-uppercase">Vé</h1>
            </div>
            <div class="col-md-5">
                <!-- Breadcrumb-->
                <ol class="text-sm justify-content-start justify-content-lg-end mb-0 breadcrumb undefined">
                    <li class="breadcrumb-item"><a class="text-uppercase" href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item text-uppercase active">Vé </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- CONTACT SECTION-->
<section class="py-5">
    <div class="container py-4">
        <div class="text-center">
            <h1 class="text-uppercase" style="font-size: 30px">Cám ơn đã sử dụng dịch vụ của chúng tôi!</h1>
        </div>

        <br>
        <div class="row mt-5">
            <div class="col-md-4"></div>
            <div class="card col-md-4 p-0">
                <div class="card-header">
                    Thông tin vé
                </div>
                <div class="card-body">
                    <p class="card-text">Ngày khởi hành : {{ $data->date }}</p>
                    <p class="card-text">Giờ khởi hành : {{ $data->time_go }}</p>
                    <p class="card-text">Địa điểm khởi hành : {{ $data->place_from }}</p>
                    <p class="card-text">Địa điểm đến : {{ $data->place_to }}</p>
                    <p class="card-text">Mã vé : {{ $data->code }}</p>
                    <p class="card-text">Số ghế : {{ $data->seat }}</p>
                    <p class="card-text">Tên xe : {{ $data->bus_name }}</p>
                    <p class="card-text">Biển số : {{ $data->license_plate }}</p>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>

    </div>
</section>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="plugins/leaflet/leaflet.js"></script>
<script src="js/pages/contact.js"></script>
@endsection