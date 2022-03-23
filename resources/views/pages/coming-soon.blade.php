@extends('layouts.website')

@section('content')
<!-- HEADING BREADCRUMB-->
<section class="bg-pentagon py-4">
    <div class="container py-3">
        <div class="row d-flex align-items-center gy-4">
            <div class="col-md-7">
                <h1 class="h2 mb-0 text-uppercase">Sắp có</h1>
            </div>
            <div class="col-md-5">
                <!-- Breadcrumb-->
                <ol class="text-sm justify-content-start justify-content-lg-end mb-0 breadcrumb undefined">
                    <li class="breadcrumb-item"><a class="text-uppercase" href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item text-uppercase active">Sắp có </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- CONTACT SECTION-->
<section class="py-5" id="coming-soon-background">
    <div class="container py-4">
        <div class="text-center">
            <h1 class="text-uppercase" style="font-size: 30px">Cám ơn đã sử dụng dịch vụ của chúng tôi! Tính năng hiện đang trong giai đoạn phát triển.</h1>
        </div>
        <br>
        <div class="text-center">
            <h5>Hãy để lại thông tin để chúng tôi có thể thông báo đến bạn sớm nhất</h5>
            <form class="ml-5 w-50 mt-4" style="margin-left: 330px;" id="send-mail-only">
                <div class="input-group border mb-3">
                    <input class="form-control bg-none border-0 shadow-0 text-warning bg-primary" type="email" placeholder="Email address" aria-label="Email address" aria-describedby="button-submit">
                    <button class="btn btn-outline-light bg-none border-0" type="button" id="button-submit" type="button"><i class="fas fa-paper-plane text-primary"></i></button>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="plugins/leaflet/leaflet.js"></script>
<script src="js/pages/coming-soon.js"></script>

<style>
    #coming-soon-background img {
        opacity: .3;
    }

    #coming-soon-background {
        position: relative;
        height: auto;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #coming-soon-background::before {
        content: "";
        background-image: url(img/bus-stop-with-sign-timetable-city-background-with-skyscrapers_136277-98.jpg);
        position: absolute;
        top: 0px;
        right: 0px;
        bottom: 0px;
        left: 0px;
        opacity: 0.3;
    }

    #coming-soon-background h1, h5 {
        position: relative;
        color: #df03fc;
        text-align: center;
    }
</style>
@endsection