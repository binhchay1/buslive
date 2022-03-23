@extends('layouts.website')

@section('content')
<!-- HERO SLIDER SECTION-->
<section class="text-white bg-cover bg-center overlay-dense" style="height:812px;background: url('https:////static.vexere.com/production/banners/330/__leaderboard-1920x922-.png') repeat">
    <div class="overlay-content py-5">
        <div class="container py-4">
            <!-- Hero slider-->
            <div class="container">
                <div class="card row d-flex flex-row" style="background-color: yellow;margin-top:257px;margin-left: 200px; margin-right: 200px; -moz-box-shadow: 3px 3px 5px 0px #666; 
        -webkit-box-shadow: 3px 3px 5px 0px #666; box-shadow: 3px 3px 5px 0px #666;">
                    <div class="col-2 ml-5 mt-3"></div>
                    <div class="col-2 mt-3" style="border:1px solid #00000020">
                        <!-- <label for="ticket-from" class="form-label">Xuất phát</label> -->
                        <h6 style="color:red;">Xuất phát</h6>
                        <select class="form-control" name="ticket-from" id="ticket-from-welcome" styles="width: 150px;" required>
                            @foreach($data as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2 mt-3 ml-2" style="border:1px solid #00000020">
                        <!-- <label for="ticket-to" class="form-label">Đến</label> -->
                        <h6 style="color:red;">Nơi đến</h6>
                        <select class="form-control" name="ticket-to" id="ticket-to-welcome" styles="width: 150px;" required>
                            @foreach($data as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2 mt-3 ml-2" style="border:1px solid #00000020;width:21%;">
                        <h6 style="color:red;">Ngày đi</h6>
                        <input type="date" id="txtDateWelcome" class="end_date" required style="max-width: 155px; font-size: 13px;color: black;max-height:38px" />
                    </div>
                    <div class="col-2" style="margin-top: 45px; margin-left: 57px;">
                        <button class="btn btn-primary mb-2" onclick="bookTicketWelcome()" style="font-size: 14px;">Tìm chuyến</button>
                    </div>
                    <div class="mt-2 text-center">
                        <div class="form-group text-danger mb-2" id="error-book-welcome"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container py-4">
        <div class="row gy-4">
            <!-- Service-->
            <h2>Ưu đãi nổi bật</h2>
            <div class="swiper-container homepage-slider" style="">
                <div class="swiper-wrapper">
                    <!-- Hero Slide-->
                    <div class="swiper-slide h-auto mb-5">
                        <div class="row gy-5 h-100 align-items-center">
                            <div class="col-lg-5 text-lg-end"><img class="ml-auto img-fluid" src="img/logo.png" alt="">
                                <h1 class="text-uppercase">Chúng tôi thiết kế để phù hợp với tất cả thiết bị</h1>
                                <ul class="list-unstyled text-uppercase fw-bold mb-0">
                                    <li class="mb-2">Máy tính bảng. Điện thoại. Máy tính.</li>
                                </ul>
                            </div>
                            <div class="col-lg-7"><img class="img-fluid" src="img/template-homepage.png" alt=""></div>
                        </div>
                    </div>
                    <!-- Hero Slide-->
                    <div class="swiper-slide h-auto mb-5">
                        <div class="row gy-5 h-100 align-items-center">
                            <div class="col-lg-7">
                                <img class="img-fluid" src="img/template-mac.png" alt="" style="margin-left: 20px;max-width:90%">
                            </div>
                            <div class="col-lg-5">
                                <h1 class="text-uppercase">10 tuyến đường cả nước</h1>
                                <ul class="list-unstyled text-uppercase fw-bold mb-0">
                                    <li class="mb-2">Chúng tôi hiện tại có 10 tuyến đường trên cả nước</li>
                                    <li class="mb-2">Triển khai thêm hơn 10 tuyển đường trong tương lai</li>
                                    <li class="mb-2">Google map sẽ được tích hợp thêm</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Hero Slide-->
                    <div class="swiper-slide h-auto mb-5" style="margin-left: 300px;">
                        <div class="row gy-5 h-100 align-items-center">
                            <div class="col-lg-5 text-lg-end">
                                <h1 class="text-uppercase">Khuyến mại</h1>
                                <ul class="list-unstyled text-uppercase fw-bold mb-0">
                                    <li class="mb-2">Chúng tôi luôn muốn mang lại cho khác hàng 1 dịch vụ tốt nhất</li>
                                    <li class="mb-2">Khuyến mại 20% cho người sử dụng lần đầu</li>
                                    <li class="mb-2">Đối tượng áp dụng</li>
                                    <li>Tất cả những ai đăng ký vào hệ thống và mua vé đầu tiên</li>
                                </ul>
                            </div>
                            <div class="col-md-7"><img class="img-fluid" src="img/template-easy-customize.png" alt=""></div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination swiper-pagination-Secondary"></div>
            </div>
            <!-- Service-->

        </div>
    </div>
</section>

<section style="background-color:#ebebeb" class="py-5" sty>
    <div class="container py-4">
        <div class="row gy-4">
            <!-- Service-->
            <div class="col-lg-4 col-md-6 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-desktop"></i>
                </div>
                <h4 class="text-uppercase mb-3">Thiết kế</h4>
                <p class="text-gray-600 text-sm">Chúng tôi luôn mang đến cho bạn 1 thiết kế gần gũi và thuận tiện nhất cho khác hàng. Chúng tôi luôn cố gắng để cải tiến để mang lại cho khách hàng 1 trải nghiệm tốt nhất</p>
            </div>
            <!-- Service-->
            <div class="col-lg-4 col-md-6 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-print"></i>
                </div>
                <h4 class="text-uppercase mb-3">Vé</h4>
                <p class="text-gray-600 text-sm">Chúng tôi không muốn bạn cần phải quá lo âu vì phải in vé vật lý nữa. Tất cả là chỉ cần ảnh hoặc là đăng nhập vào hệ thống của chúng tôi. Mọi vé bạn mua đề được lưu trên hệ thống</p>
            </div>
            <!-- Service-->
            <div class="col-lg-4 col-md-6 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-globe-americas"></i></div>
                <h4 class="text-uppercase mb-3">Quy mô</h4>
                <p class="text-gray-600 text-sm">Chúng tôi luôn mong muốn mở rộng hệ thống trong tương lai. Hãy cùng chúng tôi thực hiện điều đó!</p>
            </div>
            <!-- Service-->
            <div class="col-lg-4 col-md-6 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="far fa-lightbulb"></i></div>
                <h4 class="text-uppercase mb-3">Tư vấn</h4>
                <p class="text-gray-600 text-sm">Chúng tôi tự tin khẳng định chúng tôi luôn mang cho bạn 1 trải nghiệm tốt nhất. Hãy liên hệ với chúng tôi nếu bạn sự tư vấn tận tình</p>
            </div>
            <!-- Service-->
            <div class="col-lg-4 col-md-6 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-lock"></i>
                </div>
                <h4 class="text-uppercase mb-3">Bảo mật</h4>
                <p class="text-gray-600 text-sm">Chúng tôi đảm bảo mọi thông tin của khách sẽ được bảo mật tối đa. Bao gồm các thông tin cá nhân và thông tin của vé. Vui lòng đừng chia sẻ nó cho bất kì ai!</p>
            </div>
            <!-- Service-->
            <div class="col-lg-4 col-md-6 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-chart-pie"></i>
                </div>
                <h4 class="text-uppercase mb-3">Tầm nhìn</h4>
                <p class="text-gray-600 text-sm">Chúng tôi đang hướng đến 1 hệ thống bán vé lớn nhất Việt Nam và trong lương là cả Đông Nam Á.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-pentagon border-top border-gray-600">
    <div class="container py-4">
        <header class="mb-5">
            <h2 class="lined lined-center text-uppercase mb-4">Ý kiến khách hàng</h2>
            <p class="lead text-center">Chúng tôi đã làm việc với nhiều khách hàng và chúng tôi luôn muốn nghe về sự hài lòng mà chúng tôi mang lại. Hãy xem khách hàng của chúng tôi nói gì về chúng tôi..</p>
        </header>
        <!-- Testimonials slider-->
        <div class="swiper-container testimonials-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide h-auto mb-5">
                    <div class="p-4 bg-white h-100 d-flex flex-column justify-content-between">
                        <div class="mb-2">
                            <p class="text-sm text-gray-600">Chất lượng dịch vụ tốt, thanh toán nhanh gọn và rất thuận tiện. Tôi đã từ bỏ đi xe tàu hỏa vì dịch vụ này
                                Thật là tốt khi có những dịch vụ này</p>
                            <p class="text-sm text-gray-600"></p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between"><i class="fas fa-quote-left text-primary fa-2x"></i>
                            <div class="d-flex align-items-center ms-3">
                                <div class="me-3 text-end">
                                    <h5 class="text-uppercase mb-0">Hải Đình</h5>
                                    <p class="small text-muted mb-0">Tech Lead</p>
                                </div><img class="avatar p-1 flex-shrink-0" src="img/person-1.jpg" alt="John McIntyre" width="60">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide h-auto mb-5">
                    <div class="p-4 bg-white h-100 d-flex flex-column justify-content-between">
                        <div class="mb-2">
                            <p class="text-sm text-gray-600">Thiết bị và ghế rất thoải mái. Nhân viên phục vụ tận tình thoải mái. Niềm nở và đón khách 1 cách nhiệt tình.
                                Phải nói tôi chưa bao giờ được trải nghiệm 1 dịch vụ tốt đến thế.
                                Cám ơn </p>
                            <p class="text-sm text-gray-600"></p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between"><i class="fas fa-quote-left text-primary fa-2x"></i>
                            <div class="d-flex align-items-center ms-3">
                                <div class="me-3 text-end">
                                    <h5 class="text-uppercase mb-0">Trịnh Sang</h5>
                                    <p class="small text-muted mb-0">Giám đốc</p>
                                </div><img class="avatar p-1 flex-shrink-0" src="img/person-2.jpg" alt="John McIntyre" width="60">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide h-auto mb-5">
                    <div class="p-4 bg-white h-100 d-flex flex-column justify-content-between">
                        <div class="mb-2">
                            <p class="text-sm text-gray-600">Ghế ngồi rất hợp lý. Mọi thứ tôi được trải nghiệm 1 cách cực kì thoải mái</p>
                            <p class="text-sm text-gray-600">Webiste thiết kế giao diện rất nhìn không quá lằng nhằng so với các webiste khách
                                Tôi cảm thấy thật sự rất thuận tiện cho việc vào mua nhanh gọn. Tôi không thích 1 trang web quá nhiều thứ lằng nhằng đơn giản tôi c
                                chỉ cần đặt vé. Đó là lý do vì sao tôi chọn website này.</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between"><i class="fas fa-quote-left text-primary fa-2x"></i>
                            <div class="d-flex align-items-center ms-3">
                                <div class="me-3 text-end">
                                    <h5 class="text-uppercase mb-0">John McIntyre</h5>
                                    <p class="small text-muted mb-0">CEO, transTech</p>
                                </div><img class="avatar p-1 flex-shrink-0" src="img/person-3.png" alt="John McIntyre" width="60">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide h-auto mb-5">
                    <div class="p-4 bg-white h-100 d-flex flex-column justify-content-between">
                        <div class="mb-2">
                            <p class="text-sm text-gray-600">Chắc chắn chúng ta không thể tím được 1 webiste bán vé xe nào tốt hơn. Thật sự chúng đã giúp tôi thay đổi cách nhìn về tất cả các website bán vé.
                                Nó mang lại cho chúng tôi 1 cảm giác rất thuận tiện và cực kì được tôn trọng
                                Hãy dùng thử và tôi chắc chắn rằng bạn cũng sẽ như tôi.</p>
                            <p class="text-sm text-gray-600"></p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between"><i class="fas fa-quote-left text-primary fa-2x"></i>
                            <div class="d-flex align-items-center ms-3">
                                <div class="me-3 text-end">
                                    <h5 class="text-uppercase mb-0">Nguyễn Bình</h5>
                                    <p class="small text-muted mb-0">Kĩ sư xây dựng</p>
                                </div><img class="avatar p-1 flex-shrink-0" src="img/person-4.jpg" alt="John McIntyre" width="60">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide h-auto mb-5">
                    <div class="p-4 bg-white h-100 d-flex flex-column justify-content-between">
                        <div class="mb-2">
                            <p class="text-sm text-gray-600">Nó cho thấy sự nghiêm túc trong việc quản lý và tôi thấy phần mềm giúp nhà xe chúng tôi cực kì
                                dễ dàng và thu hút khách nhiều hơn.
                                Chúng tôi đang tìm kiếm 1 nền tảng tạo ra giá trị thật sự và đó cũng là lý do tôi tìm đến nền tảng này. Thật sự đây là 1 trải nghiệm cực kì thú vị</p>
                            <p class="text-sm text-gray-600"></p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between"><i class="fas fa-quote-left text-primary fa-2x"></i>
                            <div class="d-flex align-items-center ms-3">
                                <div class="me-3 text-end">
                                    <h5 class="text-uppercase mb-0">John Trần</h5>
                                    <p class="small text-muted mb-0">Giáo viên</p>
                                </div><img class="avatar p-1 flex-shrink-0" src="img/person-1.jpg" alt="John McIntyre" width="60">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<!-- BANNER SECTION-->
<section class="py-5 bg-fixed bg-cover bg-center dark-overlay">
    <div class="overlay-content">
        <div class="container py-4 text-white text-center">
            <div class="icon icon-outlined icon-lg mx-auto mb-4">
                <svg class="svg-icon text-white svg-icon-lg">
                    <use xlink:href="#numbers-1"> </use>
                </svg>
            </div>
            <h2 class="text-uppercase mb-3">Bạn muốn đặt vé luôn ?</h2>
            <p class="lead mb-4">Ấn vào nút bên dưới để trải nghiệm dịch vụ của chúng tôi ngay hôm ngay
                và nhận được khuyến mãi.
            </p><a class="btn btn-outline-light btn-lg" onclick="bookTicketNow()">Đặt vé ngay bây giờ</a>
        </div>
    </div>
</section>

<!-- CLIENT SECTION-->
<section class="py-5 bg-gray-200">
    <div class="container py-4">
        <header class="mb-5">
            <h2 class="text-uppercase lined lined-center mb-4">Tài trợ </h2>
        </header>
        <!-- Customer slider-->
        <div class="swiper-container customers-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide h-auto"><img class="img-fluid img-grayscale d-block mx-auto" src="img/customer-1.png" alt="..." width="140"></div>
                <div class="swiper-slide h-auto"><img class="img-fluid img-grayscale d-block mx-auto" src="img/customer-2.png" alt="..." width="140"></div>
                <div class="swiper-slide h-auto"><img class="img-fluid img-grayscale d-block mx-auto" src="img/customer-3.png" alt="..." width="140"></div>
                <div class="swiper-slide h-auto"><img class="img-fluid img-grayscale d-block mx-auto" src="img/customer-4.png" alt="..." width="140"></div>
                <div class="swiper-slide h-auto"><img class="img-fluid img-grayscale d-block mx-auto" src="img/customer-5.png" alt="..." width="140"></div>
                <div class="swiper-slide h-auto"><img class="img-fluid img-grayscale d-block mx-auto" src="img/customer-6.png" alt="..." width="140"></div>
            </div>
        </div>
    </div>
</section>

<script src="js/pages/welcome.js"></script>
@endsection