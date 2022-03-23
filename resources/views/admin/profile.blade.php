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
                            @if(Auth::user()->profile_photo_path != null)
                            <img class="profile-user-img img-fluid img-circle" src="{{ URL::to(Auth::user()->profile_photo_path) }}" style="height: 131px;">
                            @else
                            <img class="profile-user-img img-fluid img-circle" src="{{ URL::to('/img/default_avatar.png') }}" style="height: 131px;" />
                            @endif
                        </div>

                        <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                        @if(Auth::user()->role == 1)
                        <p class="text-muted text-center">Quản lý</p>
                        @elseif(Auth::user()->role == 2)
                        <p class="text-muted text-center">Quản lý ga</p>
                        @else
                        <p class="text-muted text-center">Nhân viên ga</p>
                        @endif

                        <div class="d-flex justify-content-center mt-3">
                            <form id="form-avatar" method="post" action="/admin/avatar" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="avatar" id="avatar" class="d-none" onchange="upload()" />
                                <a class="btn btn-primary" onclick="input();"><b>Thay đổi ảnh</b></a>
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
                        <h3 class="card-title">Về tôi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-envelope mr-1"></i> Địa chỉ email</strong>
                        <p class="text-muted">
                            {{ Auth::user()->email }}
                        </p>
                        <hr>
                        <strong><i class="fas fa-phone mr-1"></i> Số điện thoại</strong>

                        <p class="text-muted">
                            {{ Auth::user()->phone }}
                        </p>

                        <hr>
                        <strong><i class="fas fa-map-marked-alt mr-1"></i> Địa chỉ</strong>

                        <p class="text-muted">
                            {{ Auth::user()->address }}
                        </p>

                        <hr>
                        <strong><i class="far fa-file-alt mr-1"></i> Ngày tạo</strong>

                        <p class="text-muted">{{ Auth::user()->created_at }}</p>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="">
            <form action="/admin/change/password" method="post" class="needs-validation">
                @csrf
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block font-medium text-sm text-gray-700" for="current_password">
                                Mật khẩu hiện tại
                            </label>
                            <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="current_password" type="password" name="current_password" autocomplete="current-password">
                            @error('current_password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <label class="block font-medium text-sm text-gray-700" for="password">
                                Mật khẩu mới
                            </label>
                            <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="password" type="password" name="password" autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <label class="block font-medium text-sm text-gray-700" for="confirm_password">
                                Xác nhận mật khẩu
                            </label>
                            <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="confirm_password" type="password" name="confirm_password" autocomplete="new-password">
                            @error('confirm_password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ URL::to('/js/admin/profile.js') }}"></script>
@endsection