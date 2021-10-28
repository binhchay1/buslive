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
                            <div id="example1_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="Enter name, phone, role"></label></div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add employee</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped dataTable dtr-inline" role="grid">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting sorting_asc" tabindex="0" rowspan="1" colspan="1">STT</th>
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
                                        <td class="no"></td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role == 2 ? 'Garage Manager' : 'Employee Manager' }}</td>
                                        <td>{{ $user->name_garage }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary" id="edit_users" data-name="{{ $user->name }}" data-phone="0934385154" data-role="admin" data-id="1" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary ml-1" data-id="1" data-name="{{ $user->name }}" data-toggle="modal" data-target="#deleteModal">
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
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="garages" class="form-label">Garages</label>
                        <select class="form-control form-select-sm" name="garages">
                            @foreach($data['garages'] as $garage)
                            <option class="form-control" value="{{ $garage->id }}">{{ $garage->name_garage }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(Auth::user()->role == 1)
                    <input type="hidden" name="role" id="role" value="2">
                    @else
                    <input type="hidden" name="role" id="role" value="3">
                    @endif
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
                <form id="edit_user_form" method="post" action="">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" name="role" class="form-control" id="role">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone">
                    </div>
                    <input type="hidden" name="id" id="id" />
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
                <span class="lead">Are you sure about delete <span id="name_delete"></span> ?</span>
                <br><br>
                <form method="post" action="">
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
<style>
    table {
        counter-reset: tableCount;
    }

    .no:before {
        content: counter(tableCount);
        counter-increment: tableCount;
    }
</style>
@endsection