<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;

class VNPAYController extends Controller
{
    public function createPay(PaymentRequest $request)
    {   
       
        $payment_code = $this->generateRandomString(20);
        $calTicketBuy = DB::table('ticket')->where('trips_id', $request->trips_id)->whereNotNull('name_customer')->whereNotNull('phone_customer')->count();
        $totalSeat = DB::table('ticket')->where('trips_id', $request->trips_id)->count();
        $stock = $totalSeat - $calTicketBuy;

        if ($request->total_buy == 0) {
            $data = new \stdClass();
            $data->textError = 'Xin vui lòng nhập số vé cần mua. Xin cám ơn!';

            return view('pages.buy-fail', ['data' => $data]);
        }

        if ($request->total_buy > $stock) {
            $data = new \stdClass();
            $data->textError = 'Bạn không thể mua quá số ghế còn trống trên xe. Vui lòng thử lại!';

            return view('pages.buy-fail', ['data' => $data]);
        }

        $data['cost'] = $request->cost * $request->total_buy;
        $data['bus'] = $request->bus;
        $data['name_customer'] = $request->name_customer;
        $data['phone_customer'] = $request->phone_customer;
        $data['name'] = $request->name;
        $data['license_plate'] = $request->license_plate;
        $data['roads'] = $request->roads;
        $data['start'] = $request->start;
        $data['end'] = $request->end;
        $data['driver'] = $request->driver;
        $data['driver_mate'] = $request->driver_mate;
        $data['date'] = $request->date;
        $data['total_buy'] = $request->total_buy;
        $data['trips_id'] = $request->trips_id;
        $data['payment_code'] = $payment_code;
        if(isset($request->users_id)) {
            $data['users_id'] = $request->users_id;
        }

        return view('vnpay_php.index', ['data' => $data]);
    }

    public function paymentProcess(Request $request)
    {
        $getRequest = $request->all();
        $arrayCheckParam = ['cost', 'bus', 'name_customer', 'phone_customer', 'name', 'license_plate', 'roads', 'start', 'end', 'driver', 'driver_mate', 'date', 'total_buy', 'trips_id', 'order_id', 'users_id'];
        
        $payment = new Payment();
        foreach ($getRequest as $key => $value) {
            if (in_array($key, $arrayCheckParam)) {
                
                if($key == 'order_id') {
                    $key = 'payment_id';
                }
                $payment->$key = $value;
            }
        }
        $payment->status_payment = 'Đang thanh toán';

        $payment->save();

        $vnp_TmnCode = "7WK4YW9H";
        $vnp_HashSecret = "TRTHAHLXBYSUNSZWLRXAPZBITPGRWLYX";
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/payment-return?";

        $vnp_TxnRef = $_POST['order_id'];
        $vnp_OrderInfo = $_POST['order_desc'];
        $vnp_OrderType = $_POST['order_type'];
        $vnp_Amount = $_POST['amount'] * 100;
        $vnp_Locale = $_POST['language'];
        $vnp_BankCode = $_POST['bank_code'];
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_ExpireDate = $_POST['txtexpire'];
        $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
        $vnp_Bill_Email = $_POST['txt_billing_email'];
        $fullName = trim($_POST['txt_billing_fullname']);
        if (isset($fullName) && trim($fullName) != '') {
            $name = explode(' ', $fullName);
            $vnp_Bill_FirstName = array_shift($name);
            $vnp_Bill_LastName = array_pop($name);
        }
        $vnp_Bill_Address = $_POST['txt_inv_addr1'];
        $vnp_Bill_City = $_POST['txt_bill_city'];
        $vnp_Bill_Country = $_POST['txt_bill_country'];
        $vnp_Bill_State = $_POST['txt_bill_state'];
        $vnp_Inv_Phone = $_POST['txt_inv_mobile'];
        $vnp_Inv_Email = $_POST['txt_inv_email'];
        $vnp_Inv_Customer = $_POST['txt_inv_customer'];
        $vnp_Inv_Address = $_POST['txt_inv_addr1'];
        $vnp_Inv_Company = $_POST['txt_inv_company'];
        $vnp_Inv_Taxcode = $_POST['txt_inv_taxcode'];
        $vnp_Inv_Type = $_POST['cbo_inv_type'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
            "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
            "vnp_Bill_Email" => $vnp_Bill_Email,
            "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
            "vnp_Bill_LastName" => $vnp_Bill_LastName,
            "vnp_Bill_Address" => $vnp_Bill_Address,
            "vnp_Bill_City" => $vnp_Bill_City,
            "vnp_Bill_Country" => $vnp_Bill_Country,
            "vnp_Inv_Phone" => $vnp_Inv_Phone,
            "vnp_Inv_Email" => $vnp_Inv_Email,
            "vnp_Inv_Customer" => $vnp_Inv_Customer,
            "vnp_Inv_Address" => $vnp_Inv_Address,
            "vnp_Inv_Company" => $vnp_Inv_Company,
            "vnp_Inv_Taxcode" => $vnp_Inv_Taxcode,
            "vnp_Inv_Type" => $vnp_Inv_Type
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );

        if (isset($vnp_Returnurl)) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }

    public function paymentReturn()
    {
        return view('vnpay_php.vnpay_return');
    }

    public function paymentFail(Request $request)
    {
        $data = new \stdClass();
        $payment = Payment::where('payment_id', $request->paymentid)->first();
        $payment->update(['status_payment' => 'Thất bại']);

        $data->textError = 'Thanh toán thất bại. Vui lòng thử lại';

        return view('pages.buy-fail', ['data' => $data]);
    }

    function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
