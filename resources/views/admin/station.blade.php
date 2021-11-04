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
                            <div><label>Search:<input type="search" class="form-control form-control-sm" placeholder="Enter name, address, cost 1" onkeyup="search()" id="station_search"></label></div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add station</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped dataTable dtr-inline" role="grid" id="station_table">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting sorting_asc" tabindex="0" rowspan="1" colspan="1">Id</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Name</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Address</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Cost 1</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Cost 2</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Road</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['station'] as $station)
                                    <tr>
                                        <td>{{ $station->id }}</td>
                                        <td>{{ $station->name }}</td>
                                        <td>{{ $station->address }}</td>
                                        <td>{{ $station->cost_first }} đ</td>
                                        <td>{{ $station->cost_second }} đ</td>
                                        <td>{{ $station->road_name }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary" id="edit_users" data-id="{{ $station->id }}" data-name="{{ $station->name }}" data-address="{{ $station->address }}" data-cost_first="{{ $station->cost_first }}" data-cost_second="{{ $station->cost_second }}" data-road="{{ $station->roads_id }}" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary ml-1" data-id="{{ $station->id }}" data-toggle="modal" data-target="#deleteModal">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                {{ $data['station']->links() }}
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
                <form id="add_user_form" method="post" action="/admin/station/add">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="cost_first" class="form-label">Cost 1</label>
                        <input type="text" name="cost_first" class="form-control" id="cost_first" required>
                    </div>
                    <div class="mb-3">
                        <label for="cost_second" class="form-label">Cost 2</label>
                        <input type="text" name="cost_second" class="form-control" id="cost_second" required>
                    </div>
                    <div class="mb-3">
                        <label for="road" class="form-label">Road</label>
                        <select class="form-control form-select-sm" name="roads_id">
                            @foreach($data['roads'] as $road)
                            <option class="form-control" value="{{ $road->id }}">{{ $road->two_point }}</option>
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
                <form id="edit_user_form" method="post" action="/admin/station/edit">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name_edit" onkeypress='validate(event)' required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="address_edit" onkeypress='validate(event)' required>
                    </div>
                    <div class="mb-3">
                        <label for="cost_first" class="form-label">Cost 1</label>
                        <input type="text" name="cost_first" class="form-control" id="cost_first_edit" onkeypress='validate(event)' required>
                    </div>
                    <div class="mb-3">
                        <label for="cost_second" class="form-label">Cost 2</label>
                        <input type="text" name="cost_second" class="form-control" id="cost_second_edit" onkeypress='validate(event)' required>
                    </div>
                    <div class="mb-3">
                        <label for="road" class="form-label">Road</label>
                        <select class="form-control form-select-sm" name="roads_id" id="road_edit">
                            @foreach($data['roads'] as $road)
                            <option class="form-control" value="{{ $road->id }}">{{ $road->two_point }}</option>
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
                <form method="post" action="/admin/station/delete">
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
<script src="{{ URL::to('/js/admin/station.js') }}"></script>
@endsection