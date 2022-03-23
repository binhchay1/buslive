@extends('layouts.website')

@section('content')
<!-- HEADING BREADCRUMB-->
<link rel="stylesheet" href="css/pages/ticket.css">
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
<section class="py-2">
    </section>
    <section class="pb-5">
        <div class="container">
            <div class="card row d-flex flex-row" style="margin-left: 150px; margin-right: 150px; -moz-box-shadow: 3px 3px 5px 0px #666; 
        -webkit-box-shadow: 3px 3px 5px 0px #666; box-shadow: 3px 3px 5px 0px #666;">
                <div class="col-2 ml-5 mt-3"></div>
                <div class="col-2 mt-3" style="border:1px solid #00000020">
                    <label for="ticket-from" class="form-label">Xuất phát</label>
                    <select class="form-control" name="ticket-from" id="ticket-from-welcome" styles="width: 150px;" required>
                            @foreach($data['city'] as $city)
                            @if($city == $data['from'])
                            <option value="{{ $city }}" selected>{{ $city }}</option>
                            @else
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endif
                            @endforeach
                        </select>
                </div>
                <div class="col-2 mt-3 ml-2" style="border:1px solid #00000020">
                    <label for="ticket-to" class="form-label">Đến</label>
                    <select class="form-control" name="ticket-to" id="ticket-to-welcome" styles="width: 150px;" required>
                    @foreach($data['city'] as $city)
                            @if($city == $data['to'])
                            <option value="{{ $city }}" selected>{{ $city }}</option>
                            @else
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endif
                            @endforeach
                        </select>
                </div>
                <div class="col-2 mt-3 ml-2" style="border:1px solid #00000020;width: 160px;height: 80px">
                    <label for="ticket-to" class="form-label">Ngày đi</label>
                    <input type="date" id="txtDateWelcome" value="" 
                    class="end_date mr-3" required style="max-width: 135px; font-size: 13px;" />
                </div>
                <div class="col-2" style="margin-top: 50px; margin-left: 40px;">
                    <button class="btn btn-primary mb-2" onclick="bookTicketWelcome()" style="font-size: 13px;">Tìm chuyến</button>
                </div>
                <div class="mt-2 text-center">
                    <div class="form-group text-danger mb-2" id="error-book-welcome"></div>
                </div>
            </div>
        </div>
    </section>

    @if(!empty($data['text_null']))
    <div class="container-fluid py-3 d-flex justify-content-center">
        <div class="mt-4 mr-3"><span class="h2">{{ $data['text_null'] }}</span></div>
        <div><img src="{{ URL::to('/img/not-found.png') }}" width="120" height="120"></div>
    </div>
    @endif

    @if(empty($data['text_null']))
    <div class="py-4 row" id="list-of-trips">
        <div class="col-md-3"></div>
        <div class="col-md-6" id="ul-trips">
           
                @foreach($data['trips'] as $key => $trip)
                <li class="d-flex justify-content-between align-items-center mt-4" id="{{ $trip->id }}" onclick="takeTrips(this.id)" style="background: url('.{{ $trip->path_of_img }}'); background-repeat: no-repeat;
  background-position: right top; background-size: 505px 291px; background-">
                    <div class="card" style="width: 100% ; margin:0 ;background: rgba(0, 0, 0, 0.6);">
                        <h5 class="card-header bg-blue-400 text-white" style="border-bottom: 2px solid white; line-height: 30px;">{{ $trip->name_garages }}</h5>
                        <div class="card-body text-white">
                            <div>
                                <!-- <h5 ><b>Tên nhà xe</b> : {{ $trip->name_garages }}</h5> -->
                                <h5 ><b>Biển số</b> : {{ $trip->license_plate }}</h5>
                                <h5 ><b>Tuyến đường</b> : {{ $trip->nameRoad }}</h5>
                                <h5 ><b>Thời gian đi</b> : {{ $trip->start }}</h5>
                                <h5 ><b>Thời gian đến nơi</b> : {{ $trip->end }}</h5>
                                <h5 ><b>Gía vé</b> : {{ $trip->cost }} VNĐ</h5>
                                <h5 ><b>số điện thoại </b> : {{ $trip->phone }} </h5>
                                
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            
        </div>
        <div class="col-md-2"></div>
    </div>
    @endif
</section>

<!-- Modal add -->
<div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModal" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="bookModal">Đặt chuyến</h5>
            </div>
            <div class="modal-body body-edit">
                <form method="post" action="/createPay" id="form-add-trips">
                    @csrf
                    <div class="mb-3 text-center h3">
                        <span id="header-modal-trips"></span>
                    </div>
                    <!-- <div class="mb-3">
                        <h4><b>Tên xe</b> : <span id="bus"></span></h4>
                    </div> -->
                    <div class="mb-3">
                        <h4><b>Biển số</b> : <span id="license_plate"></span></h4>
                    </div>
                    <div class="mb-3">
                        <h4><b>Tuyến đường</b> : <span id="roads"></span></h4>
                    </div>
                    <div class="mb-3">
                        <h4><b>Thời gian xuất phát</b> : <span id="start"></span></h4>
                    </div>
                    <div class="mb-3">
                        <h4><b>Thời gian đến nơi</b> : <span id="end"></span></h4>
                    </div>
                    <div class="mb-3">
                        <h4><b>Loại xe</b> : <span id="name_type"></span></h4>
                    </div>
                    <div class="mb-3">
                        <h4><b>Gía vé</b> : <span id="cost"></span></h4>
                    </div>
                    <!-- <div class="mb-3">
                        <h4><b>Lái xe</b> : <span id="driver"></span></h4>
                    </div>
                    <div class="mb-3">
                        <h4><b>Phụ xe</b> : <span id="driver_mate"></span></h4>
                    </div> -->
                    <div class="mb-3">
                        <h4><b>Số ghế còn</b> : <span id="stock"></span></h4>
                    </div>
                    <h4><b>Ước chừng thời gian các điểm dừng</b></h4>
                    <div class="mb-3 mt-4" id="station-for-roads">
                        <ul class="list-group" id="list-station-of-roads">

                        </ul>
                    </div>
                    @if(Auth::check())
                    <input type="hidden" name="users_id" value="{{ Auth::user()->id }}">
                    <div>
                        <label class="form-label" for="name-customer">Tên người đặt</label>
                        <input class="form-control" type="text" id="name-customer" name="name_customer" value="{{ Auth::user()->name }}" readonly required>
                    </div>
                    <div>
                        <label class="form-label" for="phone-customer">Số điện thoại người đặt</label>
                        <input class="form-control" type="text" id="phone-customer" name="phone_customer" value="{{ Auth::user()->phone }}" readonly required>
                    </div>
                    <div>
                        <label class="form-label" for="total-buy">Số vé</label>
                        <input class="form-control" type="number" id="total-buy" name="total_buy" required>
                    </div>
                    @else
                    <div>
                        <label class="form-label h4" for="name-customer">Tên người đặt</label>
                        <input class="form-control" type="text" id="name-customer" name="name_customer" required>
                    </div>
                    <div>
                        <label class="form-label h4" for="phone-customer">Số điện thoại người đặt</label>
                        <input class="form-control" type="text" id="phone-customer" name="phone_customer" required>
                    </div>
                    <div>
                        <label class="form-label h4" for="total-buy">Số vé</label>
                        <input class="form-control" type="number" id="total-buy" name="total_buy" required>
                    </div>
                    @endif
                    <input type="hidden" name="trips_id" id="trips_id">
                    <input type="hidden" name="name" id="hidden_name">
                    <input type="hidden" name="bus" id="hidden_bus">
                    <input type="hidden" name="license_plate" id="hidden_license_plate">
                    <input type="hidden" name="roads" id="hidden_roads">
                    <input type="hidden" name="start" id="hidden_start">
                    <input type="hidden" name="end" id="hidden_end">
                    <input type="hidden" name="cost" id="hidden_cost">
                    <input type="hidden" name="driver" id="hidden_driver">
                    <input type="hidden" name="driver_mate" id="hidden_driver_mate">
                    <input type="hidden" name="date" id="hidden_date">
                    <input type="hidden" name="date_exp" id="hidden_exp_date">
                    <input type="hidden" name="date_buy" id="hidden_buy_date">
                    <div class="form-group d-flex justify-content-end mt-5">
                        <button type="submit" class="btn btn-primary mr-2">Đặt vé</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Modal book -->

<script src="js/pages/ticket.js"></script>
<script>
    var trips = <?php echo json_encode($data['trips']) ?>;
</script>
<style>
    #list-of-trips ul li:hover {
        -webkit-transform: scale(1.05);
        -moz-transform: scale(1.05);
        -ms-transform: scale(1.05);
        -o-transform: scale(1.05);
        transform: scale(1.05);
    }

    #list-of-trips ul li {
        -webkit-transition: all 0.1s linear;
        transition: all 0.1s linear;
    }

    #ul-trips ul {
        max-height: 620px;
        overflow-y: scroll;
    }
</style>
@endsection