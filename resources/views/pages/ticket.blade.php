@extends('layouts.website')

@section('content')
<!-- HEADING BREADCRUMB-->
<link rel="stylesheet" href="css/pages/ticket.css">
<section class="bg-pentagon py-4">
    <div class="container py-3">
        <div class="row d-flex align-items-center gy-4">
            <div class="col-md-7">
                <h1 class="h2 mb-0 text-uppercase">Ticket</h1>
            </div>
            <div class="col-md-5">
                <!-- Breadcrumb-->
                <ol class="text-sm justify-content-start justify-content-lg-end mb-0 breadcrumb undefined">
                    <li class="breadcrumb-item"><a class="text-uppercase" href="/">Home</a></li>
                    <li class="breadcrumb-item text-uppercase active">Ticket </li>
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
                <h4 class="text-uppercase mb-3">From</h4>
                <p class="text-gray-600 text-sm" id="text-from"><strong>{{ $data['from'] }}</strong></p>
            </div>
            <div class="col-lg-2 text-center">
                <p><span style="font-size: 20px">{{ date_format(date_create($data['date']),"Y-m-d") }}</span> <br><span style="font-size: 150px; margin-bottom:20px; color:#4fbfa8">&rarr;</span></p>
            </div>
            <div class="col-lg-5 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-map-marker-alt"></i></div>
                <h4 class="text-uppercase mb-3">To</h4>
                <p class="text-gray-600 text-sm" id="text-to"><strong>{{ $data['to'] }}</strong></p>
            </div>
        </div>
        <form method="post" action="/">
            @csrf
            <input type="hidden" name="date" value="{{ $data['date'] }}">
            <div class="row gy-5 mb-5">
                <div class="col-lg-5 block-icon-hover text-center">
                    <h4 class="text-uppercase mb-3">From Garages</h4>
                    <select class="form-control" name="from" id="from" required>
                        @foreach($data['allGarageFrom'] as $garage)
                        <option value="{{ $garage->id }}">{{ $garage->name_garage }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-5 block-icon-hover text-center">
                    <h4 class="text-uppercase mb-3">To Garages</h4>
                    <input class="form-control" name="to" id="to" disabled>
                </div>
            </div>

            <div class="row gy-5 mb-5">
                <div class="col-lg-5 block-icon-hover text-center">
                    <h4 class="text-uppercase mb-3">Option( Choose from station )</h4>
                    <p class="mb-3" style="font-size:10px; color:grey;">(* If you choose blank, default 'place to' is 'from garage')</p>
                    <select class="form-control" name="station_from" id="station_from" required>
                        <option value="0" selected>blank</option>
                    </select>
                </div>
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-5 block-icon-hover text-center">
                    <h4 class="text-uppercase mb-3">Option( Choose to station )</h4>
                    <p class="mb-3" style="font-size:10px; color:grey;">(* If you choose blank, default 'place to' is 'to garage')</p>
                    <select class="form-control" name="station_to" id="station_to" required>
                        <option value="0" selected>blank</option>
                    </select>
                </div>
            </div>
            <div class="row gy-5 mb-5">
                <div class="col-lg-5 text-center">
                    <h4 class="text-uppercase mb-3">Pick time</h4>
                    <p class="mb-3" style="font-size:10px; color:grey;">(* Time is expected, bus can wait 15 minutes in station!')</p>
                    <select class="form-control" name="time_go" id="time_go" required>
                    </select>
                </div>
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-5 rectangle" id="bus-seat">
                    <button type="button" class="seat m-3" data-toggle="tooltip" data-placement="top" title=""> 23 </button><br>
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
</script>
@endsection