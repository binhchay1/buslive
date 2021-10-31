@extends('layouts.website')

@section('content')
<!-- HEADING BREADCRUMB-->
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
                <p style="font-size: 150px; margin-bottom:20px; color:#4fbfa8">&rarr;</p>
            </div>
            <div class="col-lg-5 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-map-marker-alt"></i></div>
                <h4 class="text-uppercase mb-3">To</h4>
                <p class="text-gray-600 text-sm" id="text-to"><strong>{{ $data['to'] }}</strong></p>
            </div>
        </div>

        <div class="row gy-5 mb-5">
            <div class="col-lg-5 block-icon-hover text-center">
                <h4 class="text-uppercase mb-3">Choose Garages</h4>
                <select class="form-control" name="from" id="from" required>
                    @foreach($data['allCityFrom'] as $garage)
                    <option value="{{ $garage->name_garage }}">{{ $garage->name_garage }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-5 block-icon-hover text-center">
                <h4 class="text-uppercase mb-3">Choose Garages</h4>
                <select class="form-control" name="to" id="to" required>
                    @foreach($data['allCityTo'] as $garage)
                    <option value="{{ $garage->name_garage }}">{{ $garage->name_garage }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>

</section>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="js/pages/ticket.js"></script>
@endsection