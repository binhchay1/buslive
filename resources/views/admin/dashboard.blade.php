@extends('layouts.admin')

@section('content')
<!-- Main content -->
<?php

use Illuminate\Support\Facades\Auth;  ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-danger">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Doanh thu trong năm {{ date('Y') }} ( <span id="total-order"></span> VNĐ )
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="revenue-chart-canvas" height="300" style="height: 300px; display: block; width: 900px;" width="900" class="chartjs-render-monitor"></canvas>
                            </div>
                            <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="sales-chart-canvas" height="300" style="height: 300px; display: block; width: 900px;" class="chartjs-render-monitor" width="900"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-info">
                    <div class="card-header border-0">
                        <h3 class="card-title">Tỷ lệ vé bán được theo tuyến tháng {{ date('m/Y') }}</h3>
                    </div>
                    <div class="card-body table-responsive p-0" style="overflow-y:auto;" id="table-scroll-bus">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Tuyến đường</th>
                                    <th>Tỉ lệ lấp trống</th>
                                    <th>Tổng chuyến</th>
                                    <th>Tổng vé đã bán/phát hành</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['road'] as $road)
                                <tr>
                                    <td>{{ $road->name }}</td>
                                    
                                    <td>
                                        <small class="text-success mr-1">
                                            <i class="fas fa-arrow-up"></i>
                                            {{ $road->roadPercentPaid }} %
                                        </small>
                                       
                                    </td>
                                    <td>{{ $road->roadTripTotals }}</td>
                                    <td>{{ $road->roadTicketsPaid }} / {{ $road->roadTicketTotals }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-white">Doanh thu theo tuyến đường trong <span id="date-card-text"></span></h3>
                        <div class="card-tools d-flex">
                            <div class="dropdown">
                                <button type="button" class="btn btn-tool" data-date-format="yyyy" id="yearPicker">
                                    Theo năm
                                </button>
                            </div>
                            <div class="dropdown">
                                <button type="button" class="btn btn-tool" data-date-format="yyyy-mm" id="monthPicker">
                                    Theo tháng
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 764px;" width="764" height="250" class="chartjs-render-monitor"></canvas>
                        <div class="d-none" id="message-none">
                            <h3>Không có dữ liệu</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-success"> 
                    <div class="card-header border-0">
                        <h3 class="card-title">Tỉ lệ phần trăm các vé bán được theo các kênh thanh toán</h3>
                    </div>
                    <div class="card-body table-responsive p-0" style="overflow-y:auto;" id="table-scroll-customers">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Loại thanh toán</th>
                                    <th>Tỷ lệ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['pay'] as $pay)
                                <tr>
                                    <td>{{ $pay['type'] }}</td>
                                    <td>{{ $pay['turn'] }} % </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var role = <?php echo Auth::user()->role; ?>
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<style>
    .card-primary:not(.card-outline)>.card-header,
    .card-primary:not(.card-outline)>.card-header a {
        color: black;
    }

    #table-scroll-customers {
        max-height: 295px;
        overflow: auto;
    }

    #table-scroll-customers th {
        background-color: #f4f6f9;
        position: sticky;
        top: 0;
        z-index: 1;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    }

    #table-scroll-bus {
        max-height: 295px;
        overflow: auto;
    }

    #table-scroll-bus th {
        background-color: #f4f6f9;
        position: sticky;
        top: 0;
        z-index: 1;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    }
</style>
<script src="{{ URL::to('/js/admin/dashboard.js') }}"></script>
<!-- /Main content -->
@endsection