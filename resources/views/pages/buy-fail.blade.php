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
        <div class="text-center">
            <h1 class="text-uppercase" style="font-size: 30px">Vé của bạn đã mua không thành công do: </h1>
            <h2 class="text-uppercase mt-3 text-danger" style="font-size: 30px">- {{ $data->textError }}</h2>
        </div>
    </div>
</section>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="plugins/leaflet/leaflet.js"></script>
<script src="js/pages/contact.js"></script>
@endsection