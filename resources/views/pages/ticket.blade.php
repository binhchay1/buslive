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
<section class="py-5">
    <div class="container py-4">
        <div class="row gy-5 mb-5">
            <div class="col-lg-5 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-map-marker-alt"></i></div>
                <h4 class="text-uppercase mb-3">Xuất phát</h4>
                <p class="text-gray-600 text-sm" id="text-from"><strong>{{ $data['from'] }}</strong></p>
            </div>
            <div class="col-lg-2 text-center">
                <p><span style="font-size: 20px" id="date_create_ticket">{{ date_format(date_create($data['date']),"Y-m-d") }}</span> <br><span style="font-size: 150px; margin-bottom:20px; color:#4fbfa8">&rarr;</span></p>
            </div>
            <div class="col-lg-5 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-map-marker-alt"></i></div>
                <h4 class="text-uppercase mb-3">Đến</h4>
                <p class="text-gray-600 text-sm" id="text-to"><strong>{{ $data['to'] }}</strong></p>
            </div>
        </div>
        <form method="post" action="/taketicket">
            @csrf
            <input type="hidden" name="date" value="{{ $data['date'] }}">
            <div class="row gy-5 mb-5">
                <div class="col-lg-5 block-icon-hover text-center">
                    <h4 class="text-uppercase mb-3">Ga xuất phát</h4>
                    <select class="form-control" name="from" id="from" required>
                        @foreach($data['allGarageFrom'] as $garage)
                        <option value="{{ $garage->id }}">{{ $garage->name_garage }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-5 block-icon-hover text-center">
                    <h4 class="text-uppercase mb-3">Ga đến</h4>
                    <input class="form-control" name="to" id="to" disabled>
                </div>
            </div>

            <div class="row gy-5 mb-5">
                <div class="col-lg-5 block-icon-hover text-center">
                    <h4 class="text-uppercase mb-3">Tùy chọn( Chọn xuất phát tại điểm dừng chân )</h4>
                    <p class="mb-3" style="font-size:10px; color:grey;">(* Nếu bạn để trống, mặc định sẽ xuất phát tại nhà ga)</p>
                    <select class="form-control" name="station_from" id="station_from" required>
                        <option value="0" selected>trống</option>
                    </select>
                </div>
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-5 block-icon-hover text-center">
                    <h4 class="text-uppercase mb-3">Tùy chọn ( Chọn điểm đến là điểm dừng chân )</h4>
                    <p class="mb-3" style="font-size:10px; color:grey;">(* Nếu bạn để trống, mặc định sẽ đến điểm cuối cùng là nhà ga)</p>
                    <select class="form-control" name="station_to" id="station_to" required>
                        <option value="0" selected>trống</option>
                    </select>
                </div>
            </div>
            <div class="row gy-5 mb-5">
                <div class="col-lg-5 text-center">
                    <h4 class="text-uppercase mb-3">Chọn thời gian</h4>
                    <p class="mb-3" style="font-size:10px; color:grey;">(* Thời gian chỉ là dự kiến, hãy cố gắng đến trước 30 phút!')</p>
                    <select class="form-control" name="time_go" id="time_go" required>
                    </select>
                </div>
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-5">
                    <div></div>
                </div>
            </div>

            <div class="d-flex align-items-center">
                <div class="d-flex car">
                    <div class="rectangle" id="bus-seat"></div>
                    <div class="rectangle-2" id="bus-seat-back">
                        <div class="mt-2 ml-5"><button id='seat-in-bus-41' type='button' class='seat' data-toggle='tooltip' data-placement='top' onClick='setNumberSeat(this.id)'>41</button><span id='seat-back-41'></span></div>
                        <div class="ml-5"><button id='seat-in-bus-42' type='button' class='seat' data-toggle='tooltip' data-placement='top' onClick='setNumberSeat(this.id)'>42</button><span id='seat-back-42'></span></div>
                        <div class="ml-5"><button id='seat-in-bus-43' type='button' class='seat' data-toggle='tooltip' data-placement='top' onClick='setNumberSeat(this.id)'>43</button><span id='seat-back-43'></span></div>
                        <div class="ml-5"><button id='seat-in-bus-44' type='button' class='seat' data-toggle='tooltip' data-placement='top' onClick='setNumberSeat(this.id)'>44</button><span id='seat-back-44'></span></div>
                        <div class="ml-5"><button id='seat-in-bus-45' type='button' class='seat' data-toggle='tooltip' data-placement='top' onClick='setNumberSeat(this.id)'>45</button><span id='seat-back-45'></span></div>
                    </div>
                </div>
                <div class="card" style="border: 0;">
                    <div class="card-body" style="padding: 0 !important">
                        <article class="card fl-left" style="margin-left: 175px;">
                            <section class="date" style="border-left: 2px dashes white !important;"> <time><span id="seat-ticket"></span></time></section>
                            <section class="card-cont">
                                @if(Auth::check())
                                <small>{{ Auth::user()->name }}</small>
                                @else
                                <small>Khách</small>
                                @endif
                                <h3><span id="bus-ticket"></span> - <span id="license-plate-ticket"></span></h3>
                                <div class="even-date"> <i class="fa fa-calendar"></i> <time> <span id="date-ticket" class="ml-2"></span> <span id="time-ticket" class="ml-2"></span> </time></div>
                                <div class="even-info"> <i class="fa fa-map-marker"></i>
                                    <div class="ml-2">
                                        <p style="padding: 0px;"><span id="location-ticket-from"></span> đến <span id="location-ticket-to"></span></p>
                                    </div>
                                </div>
                                <div class="even-info"> <i class="fa fa-barcode"></i>
                                    <div class="ml-2">
                                        <p style="padding: 0px;"><span id="code-ticket"></span></p>
                                    </div>
                                </div>
                                <div class="even-info"> <i class="fa fa-dollar-sign"></i>
                                    <div class="ml-2">
                                        <p style="padding: 0px;"><span id="cost-ticket"></span></p>
                                    </div>
                                </div>
                                <input type="hidden" name="code" id="hidden-code-ticket" />
                                <input type="hidden" name="seat" id="hidden-seat-ticket" />
                                <input type="hidden" name="bus_id" id="hidden-bus-id-ticket" />
                                <input type="hidden" name="to_number" id="to_number">
                                <input type="hidden" name="cost" id="hidden-cost-ticket">
                                <input type="hidden" name="users_id" value="{{ Auth::check() ? Auth::user()->id : 0 }}">
                                <input type="hidden" name="name_of_bus" id="name-of-bus-ticket" />
                                <input type="hidden" name="place_from" id="place-from-ticket" />
                                <input type="hidden" name="place_to" id="place-to-ticket" />
                                <input type="hidden" name="license_plate_of_bus" id="license-plate-of-bus-ticket" />
                                <button type="submit" class="btn btn-primary mt-3">Đặt vé</a>
                            </section>
                        </article>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script src="js/pages/ticket.js"></script>
<script>
    var road = <?php echo json_encode($data['roads']) ?>;
    var garagesTo = <?php echo json_encode($data['allGarageTo']) ?>;
    var station = <?php echo json_encode($data['station']) ?>;
    var ticket = <?php echo json_encode($data['ticket']) ?>;
    var disable_seat = <?php echo json_encode($data['disable_seat']) ?>;
</script>
@endsection