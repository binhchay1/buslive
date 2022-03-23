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
                            <div><label>Tìm kiếm:<input type="search" class="form-control form-control-sm" placeholder="Nhập tìm kiếm" onkeyup="search()" id="employee_search"></label></div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm mới</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" id="table-scroll">
                            <table class="table table-bordered table-striped dataTable dtr-inline" role="grid" id="employee_table">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting sorting_asc" tabindex="0" rowspan="1" colspan="1">STT</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Tên nhân viên</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Email</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Địa chỉ</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Số điện thoại</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Giới tính</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Ngày sinh</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Vai trò</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $user)
                                    <tr>
                                        <td></td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->gender == 1 ? 'Nam' : 'Nữ' }}</td>
                                        <td>{{ $user->dob }}</td>
                                        @if($user->sub_role == 1)
                                        <td>Lái xe</</td>
                                        @elseif($user->sub_role == 2)
                                        <td>Phụ xe</</td>
                                        @else
                                        <td>Trực hotline</</td>
                                        @endif
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary" id="edit_users" 
                                            data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-address="{{ $user->address }}" data-phone="{{ $user->phone }}" data-gender="{{ $user->gender }}" data-dob="{{ $user->dob }}" data-sub_role="{{ $user->sub_role }}" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary ml-1" 
                                            data-id="{{ $user->id }}" data-sub_role="{{ $user->sub_role }}" data-toggle="modal" data-target="#deleteModal">
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
                <form id="add_user_form" method="post" action="/admin/employee/add">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên nhân viên</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Địa chỉ email</label>
                        <input type="text" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" id="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="phone" name="phone" class="form-control" id="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Giới tính</label>
                        <select class="form-control" name="gender" id="gender">
                            <option value="1">Nam</option>
                            <option value="2">Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sub_role" class="form-label">Vai trò</label>
                        <select class="form-control" name="sub_role" id="sub_role">
                            <option value="1">Lái xe</option>
                            <option value="2">Phụ xe</option>
                            <option value="3">Trực hotline</option>
                        </select>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="ticket-to" class="form-label">Ngày sinh</label>
                        <div class="row mt-1">
                            <select class="col-sm-3 ml-2" id="year" name="year" onchange="change_year(this)" required>
                            </select>
                            <select class="col-sm-3 ml-3" id="month" name="month" onchange="change_month(this)" required>
                            </select>
                            <select class="col-sm-3 ml-3" id="day" name="day" required>
                            </select>
                        </div>
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
                <form id="edit_user_form" method="post" action="/admin/employee/edit">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên nhân viên</label>
                        <input type="text" name="name" class="form-control" id="name_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" id="address_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="phone" name="phone" class="form-control" id="phone_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Giới tính</label>
                        <select class="form-control" name="gender" id="gender_edit">
                            <option value="1">Nam</option>
                            <option value="2">Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sub_role" class="form-label">Vai trò</label>
                        <select class="form-control" name="sub_role" id="sub_role_edit">
                            <option value="1">Lái xe</option>
                            <option value="2">Phụ xe</option>
                            <option value="3">Trực hotline</option>
                        </select>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="ticket-to" class="form-label">Ngày sinh</label>
                        <div class="row mt-1">
                            <select class="col-sm-3 ml-2" id="year_edit" name="year" onchange="change_year_edit(this)" required>
                            </select>
                            <select class="col-sm-3 ml-3" id="month_edit" name="month" onchange="change_month_edit(this)" required>
                            </select>
                            <select class="col-sm-3 ml-3" id="day_edit" name="day" required>
                            </select>
                        </div>
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
                <span class="lead mb-3" id="text_delete_employee"></span>
                <br><br>
                <form method="post" action="/admin/employee/delete">
                    @csrf
                    <input type="hidden" name="id" id="id_delete" />
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2" id="delete_employee">Có</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Modal delete -->
<script src="{{ URL::to('/js/admin/employee.js') }}"></script>
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