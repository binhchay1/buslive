@extends('layouts.website')

@section('content')
<!-- HEADING BREADCRUMB-->
<section class="bg-pentagon py-4">
    <div class="container py-3">
        <div class="row d-flex align-items-center gy-4">
            <div class="col-md-7">
                <h1 class="h2 mb-0 text-uppercase">Hồ sơ</h1>
            </div>
            <div class="col-md-5">
                <!-- Breadcrumb-->
                <ol class="text-sm justify-content-start justify-content-lg-end mb-0 breadcrumb undefined">
                    <li class="breadcrumb-item"><a class="text-uppercase" href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item text-uppercase active">Hồ sơ </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- CONTACT SECTION-->
<section class="py-5">
    <div class="container py-4">
        <div class="row gy-5">
            <div class="col-lg-9">
                <p class="lead mb-4">Bạn có thể xem thông tin và thay đổi tại đây.</p>
                <p class="text-muted mb-5">Nếu muốn check lịch sử mua vé và các thông tin khác, tìm hiểu thanh dọc bên tay phải.</p>
                <!-- PROFILE DETAIL FORM-->
                <form class="py-4" action="/update-profile" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h3 class="text-uppercase lined">Thông tin cá nhân</h3>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="name">Tên</label>
                            <input class="form-control" id="name" type="text" name="name" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="email">Địa chỉ email</label>
                            <input class="form-control" id="email" type="text" name="email" value="{{ Auth::user()->email }}" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="phone">Số điện thoại</label>
                            <input class="form-control" id="phone" type="text" name="phone" value="{{ Auth::user()->phone }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="cmt">CMT/CCCD</label>
                            <input class="form-control" id="cmt" type="text" name="cmt" value="{{ Auth::user()->cmt }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="gender">Gender</label>
                            <select class="form-control" name="gender" id="gender" value="{{ Auth::user()->gender }}">
                                <option value="1">Nam</option>
                                <option value="1">Nữ</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ticket-to" class="form-label">Ngày sinh</label>
                            <div class="row" style="margin-left: 0px;">
                                <select class="col-sm-3" id="year" name="year" onchange="change_year(this)" value="{{ $data['year'] }}">
                                </select>
                                <div class="col-sm-1"></div>
                                <select class="col-sm-3" id="month" name="month" onchange="change_month(this)" value="{{ $data['month'] }}">
                                </select>
                                <div class="col-sm-1"></div>
                                <select class="col-sm-3" id="day" name="day" value="">
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button class="btn btn-outline-primary" type="submit"> <i class="fas fa-save me-2"></i>Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
                <!-- CHANGE PASSWORD FORM-->
                <form class="py-4 border-top border-bottom mb-5" action="/change-password" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h3 class="text-uppercase lined">Thay đổi mật khẩu</h3>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="current_password">Mật khẩu cũ</label>
                            <input class="form-control" id="current_password" type="password" name="current_password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="password">Mật khẩu mới</label>
                            <input class="form-control" id="password" type="password" name="password">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="confirm_password">Nhập lại mật khẩu mới</label>
                            <input class="form-control" id="confirm_password" type="password" name="confirm_password">
                        </div>
                        <div class="col-lg-12 text-center">
                            <button class="btn btn-outline-primary" type="submit"> <i class="fas fa-save me-2"></i>Lưu mật khẩu mới</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3">
                <h3 class="h4 text-uppercase lined mb-4">Quản lý tài khoản</h3>
                <nav class="nav flex-column nav-pills">
                    <a class="nav-link text-sm active" href="/profile"> <i class="me-2 fas fa-user"></i><span>Thông tin cá nhân</span></a>
                    <a class="nav-link text-sm" href="/history"> <i class="me-2 fas fa-list"></i><span>Lịch sử mua vé</span></a>
                </nav>
            </div>
        </div>
    </div>
</section>
<script>
    var dateEdit = <?php echo json_encode($data['day']) ?>;
    var monthEdit = <?php echo json_encode($data['month']) ?>;
    var yearEdit = <?php echo json_encode($data['year']) ?>;
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="plugins/leaflet/leaflet.js"></script>
<script src="js/pages/profile.js"></script>
@endsection