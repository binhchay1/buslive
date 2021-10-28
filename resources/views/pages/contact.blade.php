@extends('layouts.website')

@section('content')
<!-- HEADING BREADCRUMB-->
<section class="bg-pentagon py-4">
    <div class="container py-3">
        <div class="row d-flex align-items-center gy-4">
            <div class="col-md-7">
                <h1 class="h2 mb-0 text-uppercase">Contact</h1>
            </div>
            <div class="col-md-5">
                <!-- Breadcrumb-->
                <ol class="text-sm justify-content-start justify-content-lg-end mb-0 breadcrumb undefined">
                    <li class="breadcrumb-item"><a class="text-uppercase" href="/">Home</a></li>
                    <li class="breadcrumb-item text-uppercase active">Contact </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- CONTACT SECTION-->
<section class="py-5">
    <div class="container py-4">
        <h2 class="text-uppercase lined mb-4">We are here to help you</h2>
        <p class="lead mb-5">Are you curious about something? Do you have some kind of problem with our products? As am hastily invited settled at limited civilly fortune me. Really spring in extent an by. Judge but built gay party world. Of so am he remember although required. Bachelor unpacked be advanced at. Confined in declared marianne is vicinity.</p>
        <p class="text-sm mb-5">Please feel free to contact us, our customer service center is working for you 24/7.</p>
        <div class="row gy-5 mb-5">
            <div class="col-lg-4 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-map-marker-alt"></i></div>
                <h4 class="text-uppercase mb-3">Address</h4>
                <p class="text-gray-600 text-sm">5 Lê Thánh Tông, Phan Chu Trinh, Hoàn Kiếm, Hà Nội</strong></p>
            </div>
            <div class="col-lg-4 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-map-marker-alt"></i></div>
                <h4 class="text-uppercase mb-3">Call center</h4>
                <p class="text-gray-600 text-sm">Phone: <strong>024.3976.3585</strong></p>
                <p class="text-gray-600 text-sm">Fax: <strong>024.3976.1996</strong></p>
            </div>
            <div class="col-lg-4 block-icon-hover text-center">
                <div class="icon icon-outlined icon-outlined-primary icon-thin mx-auto mb-3"><i class="fas fa-map-marker-alt"></i></div>
                <h4 class="text-uppercase mb-3">Electronic support</h4>
                <p class="text-gray-600 text-sm">Please feel free to write an email to us or to use our electronic ticketing system.</p>
                <ul class="list-unstyled text-sm mb-0">
                    <li><strong><a href="mailto:">admin@buslive.com</a></strong></li>
                </ul>
            </div>
        </div>
        <!-- CONTACT FORM    -->
        <div class="row">
            <div class="col-lg-7 mx-auto">
                <h2 class="lined lined-center text-uppercase mb-4">Contact form</h2>
                <form action="#">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="firstname">First Name</label>
                            <input class="form-control" id="firstname" type="text">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="lastname">Last Name</label>
                            <input class="form-control" id="lastname" type="text">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="emailaddress">Email Address</label>
                            <input class="form-control" id="emailaddress" type="email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="subject">Subject</label>
                            <input class="form-control" id="subject" type="text">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="message">Message</label>
                            <textarea class="form-control" id="message" rows="4"></textarea>
                        </div>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-outline-primary" type="submit"><i class="far fa-envelope me-2"></i>Send message</button>
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
<!-- MAP SECTION-->
<script src="plugins/leaflet/leaflet.js"></script>
@endsection