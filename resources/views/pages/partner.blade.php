@extends('layouts.website')

@section('content')
<!-- HEADING BREADCRUMB-->
<section class="bg-pentagon py-4">
    <div class="container py-3">
        <div class="row d-flex align-items-center gy-4">
            <div class="col-md-7">
                <h1 class="h2 mb-0 text-uppercase">Đối tác</h1>
            </div>
            <div class="col-md-5">
                <!-- Breadcrumb-->
                <ol class="text-sm justify-content-start justify-content-lg-end mb-0 breadcrumb undefined">
                    <li class="breadcrumb-item"><a class="text-uppercase" href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item text-uppercase active">Đối tác </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- PARTNER SECTION-->
<section class="py-5 card" id="partner-background">
    <div class="container py-4 card-body">
        <h2 class="text-uppercase lined mb-4">Trở thành đối tác Bus Ticket</h2>
        <p class="lead mb-5">Vì sao bạn nên chọn Bus Ticket :</p>
        <div class="row gy-5 mb-5">
            <div class="col-lg-3 block-icon-hover text-center">
                <div class="icon icon-outlined icon-thin mx-auto mb-3"><img src="{{ URL::to('img/customers.png') }}"></div>
                <p class="text-gray-600 text-sm">Tiếp cận 1,000,000 người dùng Bus Ticket</strong></p>
            </div>
            <div class="col-lg-3 block-icon-hover text-center">
                <div class="icon icon-outlined icon-thin mx-auto mb-3"><img src="{{ URL::to('img/save-money.png') }}"></div>
                <p class="text-gray-600 text-sm">Tiết kiệm chi phí cho doanh nghiệp</p>
            </div>
            <div class="col-lg-3 block-icon-hover text-center">
                <div class="icon icon-outlined mx-auto mb-3"><img src="{{ URL::to('img/social.png') }}"></div>
                <p class="text-gray-600 text-sm">Quảng bá doanh nghiệp trên các kênh của Bus Ticket</p>
            </div>
            <div class="col-lg-3 block-icon-hover text-center">
                <div class="icon icon-outlined icon-thin mx-auto mb-3"><img src="{{ URL::to('img/connecting.png') }}"></i></div>
                <p class="text-gray-600 text-sm">Đa dạng các loại hình hợp tác</p>
            </div>
        </div>
        <!-- PARTNER FORM    -->
        <div class="row">
            <div class="col-lg-7 mx-auto">
                <h2 class="lined lined-center text-uppercase mb-4">Thông tin liên hệ</h2>
                <form id="partner_send_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="name">Tên</label>
                            <input class="form-control" name="name" id="name" type="text" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="name_company">Tên công ty</label>
                            <input class="form-control" name="name_company" id="name_company" type="text" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="email">Địa chỉ email</label>
                            <input class="form-control" name="email" id="email" type="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="phone">Điện thoại</label>
                            <input class="form-control" name="phone" id="subject" type="text" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="message">Nội dung yêu cầu thêm</label>
                            <textarea class="form-control" name="message" id="message" rows="4" required></textarea>
                        </div>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-outline-primary" type="submit"><i class="far fa-envelope me-2"></i>Gửi mẫu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="plugins/leaflet/leaflet.js"></script>
<script src="js/pages/partner.js"></script>
@endsection