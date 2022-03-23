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
                            <div><label>Tìm kiếm:<input type="search" class="form-control form-control-sm" placeholder="Nhập tìm kiếm" onkeyup="search()" id="roads_search"></label></div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm mới</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" id="table-scroll">
                            <table class="table table-bordered table-striped dataTable dtr-inline" role="grid" id="roads_table">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting sorting_asc" tabindex="0" rowspan="1" colspan="1">STT</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Tên</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Bến đi</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Bến đến</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Các điểm trên tuyến đường</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['roads'] as $road)
                                    <tr>
                                        <td></td>
                                        <td>{{ $road->name }}</td>
                                        <td>{{ $road->name_first }}</td>
                                        <td>{{ $road->name_second }}</td>
                                        <td>{{ $road->arrStation }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary" id="edit_users" data-id="{{ $road->id }}" data-garages_id_first="{{ $road->garages_id_first }}" data-array="{{ $road->station }}" data-garages_id_second="{{ $road->garages_id_second }}" data-name="{{ $road->name }}" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary ml-1" data-id="{{ $road->id }}" data-toggle="modal" data-target="#deleteModal">
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
            <div class="modal-body">
                <form method="post" action="/admin/roads/add" id="roads_add_form">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="garage1" class="form-label">Bến đi</label>
                        <select class="form-control form-select-sm" name="garage1" id="garage1" onchange="setStationInListAdd()">
                            @foreach($data['station'] as $station)
                            <option class="form-control" value="{{ $station->id }}">{{ $station->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="garage2" class="form-label">Bến đến</label>
                        <select class="form-control form-select-sm" name="garage2" id="garage2" onchange="setStationInListAdd()">
                            @foreach($data['station'] as $station)
                            <option class="form-control" value="{{ $station->id }}">{{ $station->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="searchModalAdd" onkeyup="searchInModalAdd()" placeholder="Tìm kiếm tên...">
                    </div>
                    <div class="mb-3 interaction-box">
                        <ul class="list-group" id="list-station">
                        </ul>
                    </div>
                    <input type="hidden" name="arrayStation" id="arrayStation">
                    <div class="form-group d-flex justify-content-end">
                        <button type="button" onclick="saveRoads('add')" class="btn btn-primary mr-2">Lưu</button>
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
                <form method="post" action="/admin/roads/edit" id="roads_edit_form">
                    @csrf
                    <div class="mb-3">
                        <label for="name_edit" class="form-label">Tên</label>
                        <input type="text" name="name" class="form-control" id="name_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="garage1" class="form-label">Bến đi</label>
                        <select class="form-control form-select-sm" name="garage1" id="garage1_edit">
                            @foreach($data['station'] as $station)
                            <option class="form-control" value="{{ $station->id }}">{{ $station->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="garage2" class="form-label">Bến đến</label>
                        <select class="form-control form-select-sm" name="garage2" id="garage2_edit">
                            @foreach($data['station'] as $station)
                            <option class="form-control" value="{{ $station->id }}">{{ $station->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="searchModalEdit" onkeyup="searchInModalEdit()" placeholder="Tìm kiếm tên...">
                    </div>
                    <div class="mb-3 interaction-box">
                        <ul class="list-group" id="list-station-edit">

                        </ul>
                    </div>
                    <input type="hidden" name="id" id="id_edit" />
                    <input type="hidden" name="arrayStation" id="arrayStationEdit">
                    <div class="form-group d-flex justify-content-end">
                        <button type="button" onclick="saveRoads('edit')" class="btn btn-primary mr-2">Lưu</button>
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
                <span class="lead mb-3" id="text_delete_roads"></span>
                <br><br>
                <form method="post" action="/admin/roads/delete">
                    @csrf
                    <input type="hidden" name="id" id="id_delete" />
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2" id="delete_roads">Có</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Modal delete -->
<style>
    .interaction-box ul {
        text-align: left;
        overflow: hidden;
        overflow-y: scroll;
    }
</style>

<script>
    var station = <?php echo json_encode($data['station']) ?>;
    var roads = <?php echo json_encode($data['roads']) ?>;
</script>

<script src="{{ URL::to('/js/admin/roads.js') }}"></script>
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