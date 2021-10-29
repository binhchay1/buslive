@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ URL::to(Auth::user()->profile_photo_path) }}" style="height: 131px;">
                        </div>

                        <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                        @if(Auth::user()->role == 1)
                        <p class="text-muted text-center">Admin</p>
                        @elseif(Auth::user()->role == 2)
                        <p class="text-muted text-center">Garage Manager</p>
                        @else
                        <p class="text-muted text-center">Garage Employee</p>
                        @endif

                        <div class="d-flex justify-content-center mt-3">
                            <form id="form-avatar" method="post" action="/admin/avatar" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="avatar" id="avatar" class="d-none" onchange="upload()"/>
                                <a class="btn btn-primary" onclick="input();"><b>Upload Avatar</b></a>
                            </form>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>

            </div>

            <div class="col-md-6">
                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Education</strong>

                        <p class="text-muted">
                            B.S. in Computer Science from the University of Tennessee at Knoxville
                        </p>

                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                        <p class="text-muted">Malibu, California</p>

                        <hr>

                        <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                        <p class="text-muted">
                            <span class="tag tag-danger">UI Design</span>
                            <span class="tag tag-success">Coding</span>
                            <span class="tag tag-info">Javascript</span>
                            <span class="tag tag-warning">PHP</span>
                            <span class="tag tag-primary">Node.js</span>
                        </p>

                        <hr>

                        <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::to('/js/admin/profile.js') }}"></script>
@endsection