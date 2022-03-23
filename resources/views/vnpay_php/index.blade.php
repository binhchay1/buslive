<?php

$vnp_TmnCode = "7WK4YW9H";
$vnp_HashSecret = "TRTHAHLXBYSUNSZWLRXAPZBITPGRWLYX";
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://localhost/vnpay_php/vnpay_return.php";
$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
$startTime = date("YmdHis");
$expire = date('YmdHis', strtotime('+30 minutes', strtotime($startTime)));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tạo mới đơn hàng</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- Bootstrap core CSS -->
</head>

<body style="display: none;">
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">VNPAY DEMO</h3>
        </div>
        <h3>Tạo mới đơn hàng</h3>
        <div class="table-responsive">
            <form action="/payment-process" id="create_form" method="post">
                @csrf
                <div class="form-group">
                    <label for="language">Loại hàng hóa </label>
                    <select name="order_type" id="order_type" class="form-control">
                        <option value="topup">Nạp tiền điện thoại</option>
                        <option value="billpayment">Thanh toán hóa đơn</option>
                        <option value="fashion">Thời trang</option>
                        <option value="other" selected>Khác - Xem thêm tại VNPAY</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="order_id">Mã hóa đơn</label>
                    <input class="form-control" id="order_id" name="order_id" type="text" value="{{ $data['payment_code'] }}" />
                </div>
                <div class="form-group">
                    <label for="amount">Số tiền</label>
                    <input class="form-control" id="amount" name="amount" type="number" value="{{ $data['cost'] }}" />
                </div>
                <div class="form-group">
                    <label for="order_desc">Nội dung thanh toán</label>
                    <textarea class="form-control" cols="20" id="order_desc" name="order_desc" rows="2">Thanh toán vé xe {{ $data['bus'] }}</textarea>
                </div>
                <div class="form-group">
                    <label for="bank_code">Ngân hàng</label>
                    <select name="bank_code" id="bank_code" class="form-control">
                        <option value="">Không chọn</option>
                        <option value="NCB"> Ngan hang NCB</option>
                        <option value="AGRIBANK"> Ngan hang Agribank</option>
                        <option value="SCB"> Ngan hang SCB</option>
                        <option value="SACOMBANK">Ngan hang SacomBank</option>
                        <option value="EXIMBANK"> Ngan hang EximBank</option>
                        <option value="MSBANK"> Ngan hang MSBANK</option>
                        <option value="NAMABANK"> Ngan hang NamABank</option>
                        <option value="VNMART"> Vi dien tu VnMart</option>
                        <option value="VIETINBANK">Ngan hang Vietinbank</option>
                        <option value="VIETCOMBANK"> Ngan hang VCB</option>
                        <option value="HDBANK">Ngan hang HDBank</option>
                        <option value="DONGABANK"> Ngan hang Dong A</option>
                        <option value="TPBANK"> Ngân hàng TPBank</option>
                        <option value="OJB"> Ngân hàng OceanBank</option>
                        <option value="BIDV"> Ngân hàng BIDV</option>
                        <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
                        <option value="VPBANK"> Ngan hang VPBank</option>
                        <option value="MBBANK"> Ngan hang MBBank</option>
                        <option value="ACB"> Ngan hang ACB</option>
                        <option value="OCB"> Ngan hang OCB</option>
                        <option value="IVB"> Ngan hang IVB</option>
                        <option value="VISA"> Thanh toan qua VISA/MASTER</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="language">Ngôn ngữ</label>
                    <select name="language" id="language" class="form-control">
                        <option value="vn" selected>Tiếng Việt</option>
                        <option value="en">English</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Thời hạn thanh toán</label>
                    <input class="form-control" id="txtexpire" name="txtexpire" type="text" value="<?php echo $expire; ?>" />
                </div>
                <div class="form-group">
                    <h3>Thông tin hóa đơn (Billing)</h3>
                </div>
                <div class="form-group">
                    <label>Họ tên (*)</label>
                    <input class="form-control" id="txt_billing_fullname" name="txt_billing_fullname" type="text" value="{{ $data['name_customer'] }}" />
                </div>
                <div class="form-group">
                    <label>Email (*)</label>
                    <input class="form-control" id="txt_billing_email" name="txt_billing_email" type="text" value="xonv@vnpay.vn" />
                </div>
                <div class="form-group">
                    <label>Số điện thoại (*)</label>
                    <input class="form-control" id="txt_billing_mobile" name="txt_billing_mobile" type="text" value="{{ $data['phone_customer'] }}" />
                </div>
                <div class="form-group">
                    <label>Địa chỉ (*)</label>
                    <input class="form-control" id="txt_billing_addr1" name="txt_billing_addr1" type="text" value="22 Lang Ha" />
                </div>
                <div class="form-group">
                    <label>Mã bưu điện (*)</label>
                    <input class="form-control" id="txt_postalcode" name="txt_postalcode" type="text" value="100000" />
                </div>
                <div class="form-group">
                    <label>Tỉnh/TP (*)</label>
                    <input class="form-control" id="txt_bill_city" name="txt_bill_city" type="text" value="Hà Nội" />
                </div>
                <div class="form-group">
                    <label>Bang (Áp dụng cho US,CA)</label>
                    <input class="form-control" id="txt_bill_state" name="txt_bill_state" type="text" value="" />
                </div>
                <div class="form-group">
                    <label>Quốc gia (*)</label>
                    <input class="form-control" id="txt_bill_country" name="txt_bill_country" type="text" value="VN" />
                </div>
                <div class="form-group">
                    <h3>Thông tin giao hàng (Shipping)</h3>
                </div>
                <div class="form-group">
                    <label>Họ tên (*)</label>
                    <input class="form-control" id="txt_ship_fullname" name="txt_ship_fullname" type="text" value="{{ $data['name_customer'] }}" />
                </div>
                <div class="form-group">
                    <label>Email (*)</label>
                    <input class="form-control" id="txt_ship_email" name="txt_ship_email" type="text" value="vinhnt@vnpay.vn" />
                </div>
                <div class="form-group">
                    <label>Số điện thoại (*)</label>
                    <input class="form-control" id="txt_ship_mobile" name="txt_ship_mobile" type="text" value="{{ $data['phone_customer'] }}" />
                </div>
                <div class="form-group">
                    <label>Địa chỉ (*)</label>
                    <input class="form-control" id="txt_ship_addr1" name="txt_ship_addr1" type="text" value="Phòng 315, Công ty VNPAY, Tòa nhà TĐL, 22 Láng Hạ, Đống Đa, Hà Nội" />
                </div>
                <div class="form-group">
                    <label>Mã bưu điện (*)</label>
                    <input class="form-control" id="txt_ship_postalcode" name="txt_ship_postalcode" type="text" value="1000000" />
                </div>
                <div class="form-group">
                    <label>Tỉnh/TP (*)</label>
                    <input class="form-control" id="txt_ship_city" name="txt_ship_city" type="text" value="Hà Nội" />
                </div>
                <div class="form-group">
                    <label>Bang (Áp dụng cho US,CA)</label>
                    <input class="form-control" id="txt_ship_state" name="txt_ship_state" type="text" value="" />
                </div>
                <div class="form-group">
                    <label>Quốc gia (*)</label>
                    <input class="form-control" id="txt_ship_country" name="txt_ship_country" type="text" value="VN" />
                </div>
                <div class="form-group">
                    <h3>Thông tin gửi Hóa đơn điện tử (Invoice)</h3>
                </div>
                <div class="form-group">
                    <label>Tên khách hàng</label>
                    <input class="form-control" id="txt_inv_customer" name="txt_inv_customer" type="text" value="{{ $data['name_customer'] }}" />
                </div>
                <div class="form-group">
                    <label>Công ty</label>
                    <input class="form-control" id="txt_inv_company" name="txt_inv_company" type="text" value="Công ty Cổ phần giải pháp Thanh toán Việt Nam" />
                </div>
                <div class="form-group">
                    <label>Địa chỉ</label>
                    <input class="form-control" id="txt_inv_addr1" name="txt_inv_addr1" type="text" value="22 Láng Hạ, Phường Láng Hạ, Quận Đống Đa, TP Hà Nội" />
                </div>
                <div class="form-group">
                    <label>Mã số thuế</label>
                    <input class="form-control" id="txt_inv_taxcode" name="txt_inv_taxcode" type="text" value="0102182292" />
                </div>
                <div class="form-group">
                    <label>Loại hóa đơn</label>
                    <select name="cbo_inv_type" id="cbo_inv_type" class="form-control">
                        <option value="I">Cá Nhân</option>
                        <option value="O">Công ty/Tổ chức</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" id="txt_inv_email" name="txt_inv_email" type="text" value="pholv@vnpay.vn" />
                </div>
                <div class="form-group">
                    <label>Điện thoại</label>
                    <input class="form-control" id="txt_inv_mobile" name="txt_inv_mobile" type="text" value="{{ $data['phone_customer'] }}" />
                </div>
                <input type="hidden" name="cost" id="cost">
                <input type="hidden" name="bus" id="bus">
                <input type="hidden" name="name_customer" id="name_customer">
                <input type="hidden" name="phone_customer" id="phone_customer">
                <input type="hidden" name="name" id="name">
                <input type="hidden" name="license_plate" id="license_plate">
                <input type="hidden" name="roads" id="roads">
                <input type="hidden" name="start" id="start">
                <input type="hidden" name="end" id="end">
                <input type="hidden" name="driver" id="driver">
                <input type="hidden" name="driver_mate" id="driver_mate">
                <input type="hidden" name="date" id="date">
                <input type="hidden" name="total_buy" id="total_buy">
                <input type="hidden" name="trips_id" id="trips_id">
                @if(isset($data['users_id']))
                <input type="hidden" name="users_id" id="users_id" value="{{ $data['users_id'] }}">
                @endif
                <button type="button" class="btn btn-primary" id="btnPopup">Thanh toán Post</button>
                <button type="button" name="redirect" id="redirect" class="btn btn-default">Thanh toán Redirect</button>
            </form>
        </div>
        <p>
            &nbsp;
        </p>
        <footer class="footer">
            <p>&copy; VNPAY <?php echo date('Y') ?></p>
        </footer>
    </div>
</body>

<script>
    $(document).ready(function() {

        let cost = <?php echo json_encode($data['cost']) ?>;
        let bus = <?php echo json_encode($data['bus']) ?>;
        let name_customer = <?php echo json_encode($data['name_customer']) ?>;
        let phone_customer = <?php echo json_encode($data['phone_customer']) ?>;
        let name = <?php echo json_encode($data['name']) ?>;
        let license_plate = <?php echo json_encode($data['license_plate']) ?>;
        let roads = <?php echo json_encode($data['roads']) ?>;
        let start = <?php echo json_encode($data['start']) ?>;
        let end = <?php echo json_encode($data['end']) ?>;
        let driver = <?php echo json_encode($data['driver']) ?>;
        let driver_mate = <?php echo json_encode($data['driver_mate']) ?>;
        let date = <?php echo json_encode($data['date']) ?>;
        let total_buy = <?php echo json_encode($data['total_buy']) ?>;
        let trips_id = <?php echo json_encode($data['trips_id']) ?>;
        
        $('#cost').val(cost);
        $('#bus').val(bus);
        $('#name_customer').val(name_customer);
        $('#phone_customer').val(phone_customer);
        $('#name').val(name);
        $('#license_plate').val(license_plate);
        $('#roads').val(roads);
        $('#start').val(start);
        $('#end').val(end);
        $('#driver').val(driver);
        $('#driver_mate').val(driver_mate);
        $('#date').val(date);
        $('#total_buy').val(total_buy);
        $('#trips_id').val(trips_id);

        $('form#create_form').submit();
    });
</script>

</html>