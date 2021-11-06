@extends('layouts.website')

@section('content')
<!-- HEADING BREADCRUMB-->
<section class="bg-pentagon py-4">
    <div class="container py-3">
        <div class="row d-flex align-items-center gy-4">
            <div class="col-md-7">
                <h1 class="h2 mb-0 text-uppercase">Liên hệ</h1>
            </div>
            <div class="col-md-5">
                <!-- Breadcrumb-->
                <ol class="text-sm justify-content-start justify-content-lg-end mb-0 breadcrumb undefined">
                    <li class="breadcrumb-item"><a class="text-uppercase" href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item text-uppercase active">Liên hệ </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- CONTACT SECTION-->
<section class="py-5">
    <div class="container py-4">
        <h2 class="text-uppercase lined mb-4">Chúng tôi đang ở đây để giúp bạn</h2>
        <p class="lead mb-5">Bạn có tò mò về điều gì đó không? Bạn có một số loại vấn đề với sản phẩm của chúng tôi? Hãy cho chúng tôi được lắng nghe ý kiến của bạn để chúng tôi có thể phát triển thêm trong thời gian tới.</p>
        <p class="text-sm mb-5">Xin vui lòng liên hệ với chúng tôi, trung tâm dịch vụ khách hàng của chúng tôi đang làm việc cho bạn 24/7.</p>
        <div class="row gy-5 mb-5">
            <div class="col-lg-4 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-map-marker-alt"></i></div>
                <h4 class="text-uppercase mb-3">Địa chỉ</h4>
                <p class="text-gray-600 text-sm">5 Lê Thánh Tông, Phan Chu Trinh, Hoàn Kiếm, Hà Nội</strong></p>
            </div>
            <div class="col-lg-4 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-map-marker-alt"></i></div>
                <h4 class="text-uppercase mb-3">Trung tâm hỗ trợr</h4>
                <p class="text-gray-600 text-sm">Số điện thoại: <strong>024.3976.3585</strong></p>
                <p class="text-gray-600 text-sm">Fax: <strong>024.3976.1996</strong></p>
            </div>
            <div class="col-lg-4 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-map-marker-alt"></i></div>
                <h4 class="text-uppercase mb-3">Hỗ trợ kĩ thuật</h4>
                <p class="text-gray-600 text-sm">Vui lòng viết email cho chúng tôi hoặc sử dụng hệ thống bán vé điện tử của chúng tôi.</p>
                <ul class="list-unstyled text-sm mb-0">
                    <li><strong><a href="mailto:">admin@buslive.com</a></strong></li>
                </ul>
            </div>
        </div>
        <!-- CONTACT FORM    -->
        <div class="row">
            <div class="col-lg-7 mx-auto">
                <h2 class="lined lined-center text-uppercase mb-4">Mẫu liên lạc</h2>
                <form id="contact_send_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="firstname">Tên</label>
                            <input class="form-control" name="firstname" id="firstname" type="text" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="lastname">Họ</label>
                            <input class="form-control" name="lastname" id="lastname" type="text" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="email">Địa chỉ email</label>
                            <input class="form-control" name="email" id="email" type="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="subject">Tiêu đề</label>
                            <input class="form-control" name="subject" id="subject" type="text" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="message">Nội dung</label>
                            <textarea class="form-control" name="message" id="message" rows="4" required></textarea>
                        </div>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-outline-primary" type="submit"><i class="far fa-envelope me-2"></i>Gửi mẫu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-5">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.334616542381!2d105.85670321540216!3d21.019293093476218!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135abee0e6e5bef%3A0x280f2193fab565!2zVGjDtG5nIFThuqVuIFjDoyBWaeG7h3QgTmFtLCA1IEzDqiBUaMOhbmggVMO0bmcsIFBoYW4gQ2h1IFRyaW5oLCBIb8OgbiBLaeG6v20sIEjDoCBO4buZaSwgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1635420561743!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

</section>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="plugins/leaflet/leaflet.js"></script>
<script src="js/pages/contact.js"></script>
@endsection