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
                        <div><label>Search:<input type="search" class="form-control form-control-sm" placeholder="Enter name, phone, address" onkeyup="search()" id="garages_search"></label></div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Garage</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped dataTable dtr-inline" role="grid" id="garages_table">
                                <thead>
                                    <tr role="row">
                                        <th tabindex="0" rowspan="1" colspan="1">Id</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Name</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Banner</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Phone</th>
                                        <th tabindex="0" rowspan="1" colspan="1">Address</th>
                                        <th tabindex="0" rowspan="1" colspan="1">City</th>
                                        <th tabindex="0" rowspan="1" colspan="1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $garage)
                                    <tr>
                                        <td>{{ $garage->id }}</td>
                                        <td>{{ $garage->name_garage }}</td>
                                        <td id="bannerimage">
                                            @if($garage->path_of_banner != null)
                                            <img src="{{ $garage->path_of_banner }}" width="250" style="max-height: 40px;" />
                                            @endif
                                        </td>
                                        <td>{{ $garage->phone }}</td>
                                        <td>{{ $garage->address }}</td>
                                        <td>{{ $garage->city }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary" id="edit_garage" data-id="{{ $garage->id }}" data-name="{{ $garage->name_garage }}" data-banner="{{ $garage->path_of_banner }}" data-phone="{{ $garage->phone }}" data-address="{{ $garage->address }}" data-city="{{ $garage->city }}" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $data->links() }}
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
                <form id="add_user_form" method="post" action="/admin/garages/add" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="banner" class="form-label">Banner</label>
                        <input type="file" name="banner" class="form-control" id="banner">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="address">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">City</label>
                        @include('admin.list-city')
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
                <form id="edit_user_form" method="post" action="/admin/garages/edit" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="banner" class="form-label">Banner</label>
                        <input type="file" name="banner" class="form-control" id="banner_edit">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="address_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">City</label>
                        @include('admin.list-city')
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
<script src="{{ URL::to('/js/admin/garages.js') }}"></script>

@endsection