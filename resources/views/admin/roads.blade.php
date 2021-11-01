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
                        <div class="col-sm-11">
                            <div><label>Search:<input type="search" class="form-control form-control-sm" placeholder="Enter name, email, role" onkeyup="search()" id="employee_search"></label></div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add employee</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped dataTable dtr-inline" role="grid" id="employee_table">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting sorting_asc" tabindex="0" rowspan="1" colspan="1">Id</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Name</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Email</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Role</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Garages</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['employee'] as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role == 2 ? 'Garage Manager' : 'Garage Employee' }}</td>
                                        <td>{{ $user->name_garage }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary" id="edit_users" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-role="{{ $user->role }}" data-garages="{{ $user->garages_id }}" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary ml-1" data-id="{{ $user->id }}" data-toggle="modal" data-target="#deleteModal">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                {{ $data['employee']->links() }}
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<!-- Modal add -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="addModal">Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form id="add_user_form" method="post" action="/admin/employee/add">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                        @if($errors->has('name'))
                        <div class="error text-danger">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" id="email" required>
                        @if($errors->has('email'))
                        <div class="error text-danger">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                        @if($errors->has('password'))
                        <div class="error text-danger">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control form-select-sm" name="role">
                            <option class="form-control" value="2">Garage Manager</option>
                            <option class="form-control" value="3">Garage Employee</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="garages" class="form-label">Garages</label>
                        <select class="form-control form-select-sm" name="garages">
                            @foreach($data['garages'] as $garage)
                            <option class="form-control" value="{{ $garage->id }}">{{ $garage->name_garage }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                <h5 class="modal-title" id="editModal">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form id="edit_user_form" method="post" action="/admin/employee/edit">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name_edit" required>
                        @if($errors->has('name'))
                        <div class="error text-danger">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control form-select-sm" name="role" id="role_edit">
                            <option class="form-control" value="2">Garage Manager</option>
                            <option class="form-control" value="3">Garage Employee</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="garages" class="form-label">Garages</label>
                        <select class="form-control form-select-sm" name="garages" id="garages_edit">
                            @foreach($data['garages'] as $garage)
                            <option class="form-control" value="{{ $garage->id }}">{{ $garage->name_garage }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="id" id="id_edit" />
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                <h5 class="modal-title" id="deleteModal">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <span class="lead">Are you sure about delete ?</span>
                <br><br>
                <form method="post" action="/admin/employee/delete">
                    @csrf
                    <input type="hidden" name="id" id="id_delete" />
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Modal delete -->
<script src="{{ URL::to('/js/admin/employee.js') }}"></script>

@endsection