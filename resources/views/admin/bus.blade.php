@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-11">
                            <div><label>Tìm kiếm:<input type="search" class="form-control form-control-sm" placeholder="Nhập tìm kiếm" onkeyup="search()" id="bus_search"></label></div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm mới</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" id="table-scroll">
                            <table class="table table-bordered table-striped dataTable dtr-inline" role="grid" id="bus_table">
                                <thead>
                                    <tr role="row">
                                        <th tabindex="0" rowspan="1" colspan="1">STT</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Tên</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Biển số</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Loại xe</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Số lượng ghế</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Ảnh xe</th>
                                        <th tabindex="0" rowspan="1" colspan="1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $bus)
                                    <tr>
                                        <td></td>
                                        <td>{{ $bus->name }}</td>
                                        <td>{{ $bus->license_plate }}</td>
                                        <td>{{ $bus->name_type }}</td>
                                        <td>{{ $bus->seat }} chỗ</td>
                                        @if(!empty($bus->path_of_img) or $bus->path_of_img != null)
                                        <td style="text-align: center;"><img src="{{ URL::to($bus->path_of_img) }}" width="100" height="40" style="max-width: 100px; max-height: 40px;"></td>
                                        @else
                                        <td></td>
                                        @endif
                                        <td class="text-center">
                                            <a href="/admin/mapshare" class="btn btn-primary ml-1">
                                                <i class="fas fa-map"></i>
                                            </a>
                                            <button type="button" class="btn btn-primary" id="edit_bus" data-id="{{ $bus->id }}" data-name="{{ $bus->name }}" data-license="{{ $bus->license_plate }}" data-name_type="{{ $bus->name_type }}" data-seat="{{ $bus->seat }}" data-path_of_img="{{ $bus->path_of_img }}" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary ml-1" data-id="{{ $bus->id }}" data-toggle="modal" data-target="#deleteModal">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
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
</div>

<!-- Modal add -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="addModal">Thêm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body body-edit">
                <form id="add_user_form" method="post" action="/admin/bus/add" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="license_plate" class="form-label">Biển số</label>
                        <input type="text" name="license_plate" class="form-control" id="license_plate" required>
                    </div>
                    <div class="mb-3">
                        <label for="name_type" class="form-label">Loại xe</label>
                        <input type="text" name="name_type" class="form-control" id="name_type" required>
                    </div>
                    <div class="mb-3">
                        <label for="seat" class="form-label">Số lượng ghế</label>
                        <input type="number" name="seat" class="form-control" id="seat" required>
                    </div>
                    <div class="mb-3">
                        <label for="seat" class="form-label">Ảnh xe</label>
                        <input type="file" name="img" class="form-control" id="img" accept="image/*" required>
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2">Lưu</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Modal add -->

<!-- Modal edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="editModal">Sửa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form id="edit_user_form" method="post" action="/admin/bus/edit" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name_edit" class="form-label">Tên</label>
                        <input type="text" name="name" class="form-control" id="name_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="license_plate_edit" class="form-label">Biển số</label>
                        <input type="text" name="license_plate" class="form-control" id="license_plate_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="name_type_edit" class="form-label">Loại xe</label>
                        <input type="text" name="name_type" class="form-control" id="name_type_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="seat_edit" class="form-label">Số lượng ghế</label>
                        <input type="text" name="seat" class="form-control" id="seat_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="img_edit" class="form-label">Ảnh xe</label>
                        <div class="d-flex" id="area-img-edit-bus">
                            <img id="img-for-edit-bus" width="100" height="40" style="max-width: 100px; max-height: 40px;">
                            <!-- <span class="mt-3 ml-2" id="text-img-bus-edit"></span> -->
                            <button type="button" class="btn btn-primary ml-2" onclick="editImageBus()">
                                <i class="fas fa-exchange-alt"></i>
                            </button>
                        </div>
                        <input type="file" name="img" class="form-control d-none" id="img_edit" accept="image/*" require>
                    </div>
                    <input type="hidden" name="id" id="id_edit" />
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2">Lưu</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Modal edit -->

<!-- Modal delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="deleteModal">Xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <span class="lead mb-3" id="text_delete_bus"></span>
                <br><br>
                <form method="post" action="/admin/bus/delete">
                    @csrf
                    <input type="hidden" name="id" id="id_delete" />
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2" id="delete_bus">Có</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Modal delete -->
<script>
    var data = <?php echo json_encode($data); ?>
</script>
<script src="{{ URL::to('/js/admin/bus.js') }}"></script>
<style type="text/css">
    #table-scroll {
        max-height: 630px;
        overflow: auto;
    }

    #table-scroll th {
        background-color: #f4f6f9;
        position: sticky;
        top: -1;
        z-index: 1;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    }

    table {
        counter-reset: rowNumber - 1;
    }

    table tr {
        counter-increment: rowNumber;
    }

    table tr td:first-child::before {
        content: counter(rowNumber);
        min-width: 1em;
        margin-right: 0.5em;
    }
</style>
@endsection