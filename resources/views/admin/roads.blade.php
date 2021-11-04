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
                            <div><label>Search:<input type="search" class="form-control form-control-sm" placeholder="Enter garage 1, garage 2" onkeyup="search()" id="roads_search"></label></div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add road</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped dataTable dtr-inline" role="grid" id="roads_table">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting sorting_asc" tabindex="0" rowspan="1" colspan="1">Id</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Garage 1</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Garage 2</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Cost</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['roads'] as $road)
                                    <tr>
                                        <td>{{ $road->id }}</td>
                                        <td>{{ $road->name_first }}</td>
                                        <td>{{ $road->name_second }}</td>
                                        <td>{{ $road->cost }} đ</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary" id="edit_users" data-id="{{ $road->id }}" data-garages_id_first="{{ $road->garages_id_first }}" data-garages_id_second="{{ $road->garages_id_second }}" data-cost="{{ $road->cost }}" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary ml-1" data-id="{{ $road->id }}" data-toggle="modal" data-target="#deleteModal">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                {{ $data['roads']->links() }}
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
                <form id="add_user_form" method="post" action="/admin/roads/add">
                    @csrf
                    <div class="mb-3">
                        <label for="garage1" class="form-label">Garages 1</label>
                        <select class="form-control form-select-sm" name="garage1">
                            @foreach($data['garages'] as $garage)
                            <option class="form-control" value="{{ $garage->id }}">{{ $garage->name_garage }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="garage2" class="form-label">Garages 2</label>
                        <select class="form-control form-select-sm" name="garage2">
                            @foreach($data['garages'] as $garage)
                            <option class="form-control" value="{{ $garage->id }}">{{ $garage->name_garage }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cost" class="form-label">Cost</label>
                        <input type="text" name="cost" class="form-control" id="cost" onkeypress='validate(event)' required>
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
                <form id="edit_user_form" method="post" action="/admin/roads/edit">
                    @csrf
                    <div class="mb-3">
                        <label for="garage1" class="form-label">Garages 1</label>
                        <select class="form-control form-select-sm" name="garage1" id="garage1_edit">
                            @foreach($data['garages'] as $garage)
                            <option class="form-control" value="{{ $garage->id }}">{{ $garage->name_garage }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="garage2" class="form-label">Garages 2</label>
                        <select class="form-control form-select-sm" name="garage2" id="garage2_edit">
                            @foreach($data['garages'] as $garage)
                            <option class="form-control" value="{{ $garage->id }}">{{ $garage->name_garage }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cost" class="form-label">Cost</label>
                        <input type="text" name="cost" class="form-control" id="cost_edit" required>
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
                <br>
                <span class="lead text-red-400">(* If delete this, all station and bus of this road will  be deleted!)</span>
                <br><br>
                <form method="post" action="/admin/roads/delete">
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
<script src="{{ URL::to('/js/admin/roads.js') }}"></script>
@endsection