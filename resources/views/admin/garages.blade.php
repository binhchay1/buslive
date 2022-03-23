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
                            <div><label>Tìm kiếm:<input type="search" class="form-control form-control-sm" placeholder="Nhập tìm kiếm" onkeyup="search()" id="garages_search"></label></div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm mới</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" id="table-scroll">
                            <table class="table table-bordered table-striped dataTable dtr-inline" role="grid" id="garages_table">
                                <thead>
                                    <tr role="row">
                                        <th tabindex="0" rowspan="1" colspan="1">STT</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Tên nhà xe</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Tên chủ nhà xe</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Địa chỉ</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Số điện thoại</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Email</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Trạng thái</th>
                                        <th tabindex="0" rowspan="1" colspan="1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user)
                                    <tr>
                                        <td></td>
                                        <td>{{ $user->name_garage }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->status == 1 ? 'Đã kích hoạt' : 'Chưa kích hoạt' }}</td>
                                        <td class="text-center d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary" id="edit_users" data-id="{{ $user->id }}" data-name_garage="{{ $user->name_garage }}" data-name="{{ $user->name }}" data-address="{{ $user->address }}" data-phone="{{ $user->phone }}" data-users_id="{{ $user->users_id }}" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary ml-1" data-id="{{ $user->id }}" data-users_id="{{ $user->users_id }}" data-toggle="modal" data-target="#deleteModal">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            @if($user->status == 1)
                                            <form method="post" action="/admin/garages/status">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $user->users_id }}" />
                                                <input type="hidden" name="type" value="de-active" />
                                                <button type="submit" class="btn btn-primary ml-1">
                                                    <i class="fas fa-minus-circle"></i>
                                                </button>
                                            </form>
                                            @else
                                            <form method="post" action="/admin/garages/status">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $user->users_id }}" />
                                                <input type="hidden" name="type" value="active" />
                                                <button type="submit" class="btn btn-primary ml-1">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>
                                            @endif
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
                <form id="add_user_form" method="post" action="/admin/garages/add" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name_garage" class="form-label">Tên nhà xe</label>
                        <input type="text" name="name_garage" class="form-control" id="name_garage" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên chủ nhà xe</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" id="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
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
                <form id="edit_user_form" method="post" action="/admin/garages/edit" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name_garage" class="form-label">Tên nhà xe</label>
                        <input type="text" name="name_garage" class="form-control" id="name_garage_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên chủ nhà xe</label>
                        <input type="text" name="name" class="form-control" id="name_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" id="phone_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" id="address_edit" required>
                    </div>
                    <input type="hidden" name="id" id="id_edit" />
                    <input type="hidden" name="users_id" id="users_id_edit" />
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2">Lưu</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="deleteModal">Xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <span class="lead">Bạn chắc chắn muốn xóa ?</span>
                <br><br>
                <form method="post" action="/admin/garages/delete">
                    @csrf
                    <input type="hidden" name="id" id="id_delete" />
                    <input type="hidden" name="users_id" id="users_id_delete" />
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2">Có</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Modal delete -->

<script src="{{ URL::to('/js/admin/garages.js') }}"></script>
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