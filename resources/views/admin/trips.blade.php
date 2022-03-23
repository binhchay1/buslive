@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <div>
                                <div style="text-align: center;"><label>Chọn tuyến</label></div>
                                <div>
                                    @if(isset($data['current_roads_id']))
                                    <select class="form-control" id="selection-roads" onchange="changeRoads()">
                                        @foreach($data['roads'] as $road)
                                        @if($data['current_roads_id'] == $road->id)
                                        @if($road->status == false)
                                        <option  style='color:red'value="{{ $road->id }}" selected>{{ $road->name }}</option>
                                        @else
                                        <option  value="{{ $road->id }}" selected>{{ $road->name }}</option>
                                        @endif
                                        @else
                                        @if($road->status == false)
                                        <option style='color:red' value="{{ $road->id }}">{{ $road->name }}</option>
                                        @else
                                        <option value="{{ $road->id }}">{{ $road->name }}</option>
                                        @endif
                                        
                                        @endif
                                        @endforeach
                                    </select>
                                    @else
                                    <select class="form-control" id="selection-roads" onchange="changeRoads()">
                                        @foreach($data['roads'] as $road)
                                         @if($road->status == false)
                                        <option style='color:red' value="{{ $road->id }}">{{ $road->name }}</option>
                                        @else
                                        <option value="{{ $road->id }}">{{ $road->name }}</option>
                                        @endif
                                        
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-sm-2">
                            <div class="ml-3">
                                <button type="button" class="btn btn-primary" onclick="changeCurrentWeek('previous')">Tuần trước</button>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <p class="text-center h3" id="cal-header"> </p>
                        </div>
                        <div class="col-sm-2">
                            <div class="ml-3">
                                <button type="button" class="btn btn-primary float-right" onclick="changeCurrentWeek('next')">Tuần sau</button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5" id="table-scroll">
                        <table class="table table-bordered dtr-inline" role="grid" id="trips_table">
                            <thead>
                                <tr role="row" id="table-header">
                                    @if(Auth::user()->role == 2)
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-1" onclick="setTextForModal(this.id)"><br><span id="cal-th-1"></span></th>
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-2" onclick="setTextForModal(this.id)"><br><span id="cal-th-2"></span></th>
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-3" onclick="setTextForModal(this.id)"><br><span id="cal-th-3"></span></th>
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-4" onclick="setTextForModal(this.id)"><br><span id="cal-th-4"></span></th>
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-5" onclick="setTextForModal(this.id)"><br><span id="cal-th-5"></span></th>
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-6" onclick="setTextForModal(this.id)"><br><span id="cal-th-6"></span></th>
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-7" onclick="setTextForModal(this.id)"><br><span id="cal-th-7"></span></th>
                                    @else
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-1"><br><span id="cal-th-1"></span></th>
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-2"><br><span id="cal-th-2"></span></th>
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-3"><br><span id="cal-th-3"></span></th>
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-4"><br><span id="cal-th-4"></span></th>
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-5"><br><span id="cal-th-5"></span></th>
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-6"><br><span id="cal-th-6"></span></th>
                                    <th class="sorting text-center" tabindex="0" rowspan="1" colspan="1" id="cal-click-7"><br><span id="cal-th-7"></span></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="table-data-trips">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <div><span class="mr-2" style="color: #b3afaf !important;"><i class="fas fa-square"></i></span>đã chạy</div>
                    <div class="ml-3"><span class="mr-2" style="color: #3ede89 !important;"><i class="fas fa-square"></i></span>đã lên lịch</div>
                    <div class="ml-3"><span class="mr-2" style="color: #d96666 !important;"><i class="fas fa-square"></i></span>đã hủy</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal add -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="addModal">Tạo chuyến đi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body body-edit">
                <form method="post" action="/admin/trips/add" enctype="multipart/form-data" id="form-add-trips">
                    @csrf
                    <div class="mb-3 text-center h3">
                        <span id="header-modal-trips"></span>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên chuyến</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="bus" class="form-label">Chọn xe</label>
                        <select type="text" name="bus" class="form-control" id="bus" required>
                            @foreach($data['bus'] as $bus)
                            @if( $bus->status == true )
                            <option value="{{ $bus->id }}">{{ $bus->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="roads" class="form-label">Chọn tuyến</label>
                        <select name="roads" class="form-control" id="roads" onchange="getDataStation(this.value)" required>
                            @foreach($data['roads'] as $road)
                            @if( $road->status == true )
                            <option value="{{ $road->id }}">{{ $road->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start" class="form-label">Thời gian xuất phát</label>
                        <input type="time" name="start" class="form-control" id="start" required>
                    </div>
                    <div class="mb-3">
                        <label for="end" class="form-label">Thời gian đến nơi</label>
                        <input type="time" name="end" class="form-control" id="end" required>
                    </div>
                    <div class="mb-3">
                        <label for="cost" class="form-label">Gía vé</label>
                        <input type="number" name="cost" class="form-control" id="cost" required>
                    </div>
                    <div class="mb-3">
                        <label for="driver" class="form-label">Tài xế</label>
                        <select type="text" name="driver" class="form-control" id="driver" required>
                            @foreach($data['driver'] as $driver)
                            @if( $driver->status_delete == true )
                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="driver_mate" class="form-label">Phụ xe</label>
                        <select type="text" name="driver_mate" class="form-control" id="driver_mate" required>
                            @foreach($data['driver_mate'] as $driver_mate)
                            @if( $driver_mate->status_delete == true )
                            <option value="{{ $driver_mate->id }}">{{ $driver_mate->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <label>Ước chừng thời gian điểm dừng</label>
                    <div class="mb-3" id="station-for-roads">
                        <ul class="list-group" id="list-station-of-roads">

                        </ul>
                    </div>
                    <label>Lập lại mỗi tuần theo thứ đến hết tháng</label>
                    <div class="mb-3 d-flex">
                        <div>
                            <input type="checkbox" class="form-control" name="duplicate[t2]" id="duplicate-t2">
                            <span class="form-label text-bold ml-2">T2<span>
                        </div>
                        <div class="ml-2">
                            <input type="checkbox" class="form-control" name="duplicate[t3]" id="duplicate-t3">
                            <span class="form-label text-bold ml-2">T3<span>
                        </div>
                        <div class="ml-2">
                            <input type="checkbox" class="form-control" name="duplicate[t4]" id="duplicate-t4">
                            <span class="form-label text-bold ml-2">T4<span>
                        </div>
                        <div class="ml-2">
                            <input type="checkbox" class="form-control" name="duplicate[t5]" id="duplicate-t5">
                            <span class="form-label text-bold ml-2">T5<span>
                        </div>
                        <div class="ml-2">
                            <input type="checkbox" class="form-control" name="duplicate[t6]" id="duplicate-t6">
                            <span class="form-label text-bold ml-2">T6<span>
                        </div>
                        <div class="ml-2">
                            <input type="checkbox" class="form-control" name="duplicate[t7]" id="duplicate-t7">
                            <span class="form-label text-bold ml-2">T7<span>
                        </div>
                        <div class="ml-2">
                            <input type="checkbox" class="form-control" name="duplicate[cn]" id="duplicate-cn">
                            <span class="form-label text-bold ml-2">CN<span>
                        </div>
                    </div>
                    <input type="hidden" name="date" id="date-trips">
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2">Tạo</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Modal add -->

<!-- Modal show -->
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModal" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="addModal">Thông tin chuyến đi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body body-edit">
                <div class="mb-3 text-center h3">
                    <span id="header-modal-trips-show">Chi tiết chuyến đi</span>
                </div>
                <form method="post" action="/admin/repick/" id="form-repick-trips">
                    <div class="mb-3 text-center h5">
                        <span id="name-modal-trips-show"></span>
                    </div>
                    <div class="mb-3 text-center">
                        <span id="time-modal-trips-show"></span>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <span id="roads-modal-trips-show"></span>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <span id="totalSeat-modal-trips-show"></span>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6 d-flex">
                            @if(Auth::user()-> role == 3)
                            <span id="bus-modal-trips-show"></span>
                            @else
                            <span style="width: 100px">Xe chạy : </span> <select class="form-control" name="bus" id="bus-modal-trips-show-select">
                                @foreach($data['bus'] as $bus)
                                <option value="{{ $bus->id }}">{{ $bus->name }}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <span id="sale-modal-trips-show"></span>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6 d-flex">
                            @if(Auth::user()-> role == 3)
                            <span id="cost-modal-trips-show"></span>
                            @else
                            <span style="width: 100px">Gía vé : </span><input class="form-control" name="cost" id="cost-modal-trips-show-input" required>
                            @endif
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <span id="stock-modal-trips-show"></span><br>
                            <span id="status-modal-trips-show"></span>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6 d-flex">
                            @if(Auth::user()-> role == 3)
                            <span id="driver-modal-trips-show"></span>
                            @else
                            <span style="width: 76px">Lái xe : </span><select class="form-control" name="driver" id="driver-modal-trips-show-select">
                                @foreach($data['driver'] as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-4 d-flex">
                            @if(Auth::user()-> role == 3)
                            <span id="driver-mate-modal-trips-show"></span>
                            @else
                            <span style="width: 100px">Phụ xe : </span><select class="form-control" name="driver_mate" id="driver-mate-modal-trips-show-select">
                                @foreach($data['driver_mate'] as $driver_mate)
                                <option value="{{ $driver_mate->id }}">{{ $driver_mate->name }}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <span id="estimate-title-modal-trips-show">Ước tính thời gian điểm dừng</span>
                            <ul class="list-group" id="estimate-data-modal-trips-show">

                            </ul>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-1"></div>
                        <div class="col-md-11 d-flex justify-content-between">
                        @if(Auth::user()->role == 2)
                           <div>
                                <input type="checkbox" class="form-control" name="acceptAll" id="acceptAll">
                                <span class="form-label text-bold ml-2">Áp dụng cho các chuyến trong tương lai<span>
                            </div>
                            @else
                            <div> </div>
                            @endif
                            
                            @if(Auth::user()->sub_role == 2 or Auth::user()->sub_role == 3 or Auth::user()->role == 2)
                            <div id="button-add-new-customer">
                                <button type="button" class="btn btn-primary" id="add_customer_to_trips">Thêm khách</button>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if(Auth::user()->sub_role == 2 or Auth::user()->role == 2 or Auth::user()->sub_role == 3)
                    <div id="table-buyers">
                        <table class="table table-bordered table-striped dataTable dtr-inline" role="grid" id="buyers-table">
                            <thead>
                                <tr>
                                    <th colspan="5" class="text-center">Khách hàng</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Tên</th>
                                    <th class="text-center">Số điện thoại</th>
                                    <th class="text-center">Số ghế đã mua</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Ghi chú</th>
                                </tr>
                            </thead>
                            @csrf
                            <tbody id="table-buyers-data" class="text-center">

                            </tbody>
                        </table>
                    </div>
                    @endif
                    <div>
                        <span id="text_new_customer"> </span>
                    </div>
                    <input type="hidden" name="date" id="date-trips-hidden">
                    <input type="hidden" name="tripsId_hidden" id="tripsId-hidden">
                    <input type="hidden" name="start" id="start-hidden">
                    <input type="hidden" name="currentBus" id="bus-current-hidden">
                    <input type="hidden" name="currentStart" id="start-current-hidden">
                    <input type="hidden" name="currentDriver" id="driver-current-hidden">
                    <input type="hidden" name="currentDriverMate" id="driver-mate-current-hidden">
                    <div class="form-group d-flex justify-content-end" id="group-button-trips">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Modal show -->

<style>
    #table-scroll {
        height: 453px;
        overflow: auto;
    }

    #table-scroll th {
        background-color: #f4f6f9;
        position: sticky;
        top: -1;
        z-index: 1;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    }

    #table-buyers {
        max-height: 200px;
        overflow: auto;
    }

    #table-data-trips {
        font-size: 12px;
        line-height: 20px;
    }

    .modal-lg {
        max-width: 1200px !important;
    }
</style>
<script>
    var roads = <?php echo json_encode($data['roads']) ?>;
    var role = <?php echo json_encode($data['role']) ?>;
    var sub_role = <?php if (isset($data['sub_role'])) {
                        echo json_encode($data['sub_role']);
                    } else {
                        echo 'null';
                    } ?>;

    var lastChoiceYear = <?php if (isset($data['year'])) {
                                echo json_encode($data['year']);
                            } else {
                                echo 'null';
                            } ?>;

    var lastChoiceMonth = <?php if (isset($data['month'])) {
                                echo json_encode($data['month']);
                            } else {
                                echo 'null';
                            } ?>;

    var lastChoiceDay = <?php if (isset($data['day'])) {
                            echo json_encode($data['day']);
                        } else {
                            echo 'null';
                        } ?>;
    var bus = <?php echo json_encode($data['bus']) ?>;
    var driver = <?php echo json_encode($data['driver']) ?>;
    var driver_mate = <?php echo json_encode($data['driver_mate']) ?>;
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="{{ URL::to('/js/admin/trips.js') }}"></script>

@endsection