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
                            <div><label>Search:<input type="search" class="form-control form-control-sm" placeholder="Enter name, license plate" onkeyup="search()" id="bus_search"></label></div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Bus</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped dataTable dtr-inline" role="grid" id="bus_table">
                                <thead>
                                    <tr role="row">
                                        <th tabindex="0" rowspan="1" colspan="1">Id</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Name</th>
                                        <th tabindex="0" rowspan="1" colspan="1">License Plate</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Garage</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Road</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Time Go</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Time Arrival</th>
                                        <th tabindex="0" rowspan="1" colspan="1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['bus'] as $bus)
                                    <tr>
                                        <td>{{ $bus->id }}</td>
                                        <td>{{ $bus->name }}</td>
                                        <td>{{ $bus->license_plate }}</td>
                                        <td>{{ $bus->name_garage }}</td>
                                        <td>{{ $bus->two_point }}</td>
                                        <td>{{ $bus->time_go }}</td>
                                        <td>{{ $bus->time_arrival }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary" id="edit_garage" data-id="{{ $bus->id }}" data-name="{{ $bus->name }}" data-license="{{ $bus->license_plate }}" data-garages="{{ $bus->garages_id }}" data-two_point="{{ $bus->two_point }}" data-time_go="{{ $bus->time_go }}" data-time_arrival="{{ $bus->time_arrival }}" data-toggle="modal" data-target="#editModal">
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
                {{ $data['bus']->links() }}
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
            <div class="modal-body body-edit">
                <form id="add_user_form" method="post" action="/admin/bus/add" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="license_plate" class="form-label">License Plate</label>
                        <input type="text" name="license_plate" class="form-control" id="license_plate">
                    </div>
                    <div class="mb-3">
                        <label for="garages" class="form-label">Garages</label>
                        <select class="form-control form-select-sm" name="garages" id="garages">
                            @foreach($data['garages'] as $garage)
                            <option class="form-control" value="{{ $garage->id }}">{{ $garage->name_garage }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="roads_id" class="form-label">Road</label>
                        <select class="form-control form-select-sm" name="roads_id" id="roads_id">
                            @foreach($data['roads'] as $road)
                            <option class="form-control" value="{{ $road->id }}">{{ $road->two_point }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="time_go" class="form-label">Time Go</label>
                        <input type="time" name="time_go" class="form-control" id="time_go" required>
                    </div>
                    <div class="mb-3">
                        <label for="time_arrival" class="form-label">Time Arrival</label>
                        <input type="time" name="time_arrival" class="form-control" id="time_arrival" required>
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
                <form id="edit_user_form" method="post" action="/admin/bus/edit" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="license_plate" class="form-label">License Plate</label>
                        <input type="text" name="license_plate" class="form-control" id="license_plate_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="garages" class="form-label">Garages</label>
                        <select class="form-control form-select-sm" name="garages" id="garages_edit">
                            @foreach($data['garages'] as $garage)
                            <option class="form-control" value="{{ $garage->id }}">{{ $garage->name_garage }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="roads_id" class="form-label">Road</label>
                        <select class="form-control form-select-sm" name="roads_id" id="roads_id_edit">
                            @foreach($data['roads'] as $road)
                            <option class="form-control" value="{{ $road->id }}">{{ $road->two_point }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="time_go" class="form-label">Time Go</label>
                        <input type="time" name="time_go" class="form-control" id="time_go_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="time_arrival" class="form-label">Time Arrival</label>
                        <input type="time" name="time_arrival" class="form-control" id="time_arrival_edit" required>
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
                <span class="lead">Are you sure about delete <span id="name_delete"></span> ?</span>
                <br><br>
                <form method="post" action="/admin/garages/delete">
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
<script src="{{ URL::to('/js/admin/bus.js') }}"></script>

@endsection