<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Ticket;
use App\Models\Partner;
use App\Models\Payment;
use App\Models\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordRequest;

class FeatureController extends Controller
{
    public function viewWelcome()
    {
        $getCity = DB::table('station')->select('city')->groupBy('city')->get();

        $data = [];
        foreach ($getCity as $city) {
            $data[] = $city->city;
        }

        return view('pages/welcome', ['data' => $data]);
    }

    public function viewContact()
    {
        return view('pages/contact');
    }

    public function viewPartner()
    {
        return view('pages/partner');
    }

    public function viewRentCar()
    {
        $check = 0;
        if ($check == 0) {
            return view('pages/coming-soon');
        }
        return view('pages/rent-car');
    }

    public function sendContact(Request $request)
    {

        $contact = new Contact();

        $contact->first_name = $request->get('firstname');
        $contact->last_name = $request->get('lastname');
        $contact->subject = $request->get('subject');
        $contact->email = $request->get('email');
        $contact->message = $request->get('message');

        $contact->save();

        return 'success';
    }

    public function sendPartner(Request $request)
    {

        $partner = new Partner();

        $partner->name = $request->get('name');
        $partner->name_company = $request->get('name_company');
        $partner->phone = $request->get('phone');
        $partner->email = $request->get('email');
        $partner->message = $request->get('message');

        $partner->save();

        return 'success';
    }

    public function sendMailOnly(Request $request)
    {

        $mail = new Mail();
        $mail->email = $request->get('email');
        $partner->save();

        return 'success';
    }

    public function bookTicket(Request $request)
    {
        if ($request->date === null) {
            $request->date = date("Y-m-d");
        }

        $data['from'] = $request->from;
        $data['to'] = $request->to;
        $data['date'] = $request->date;
        $data['to_date_cover'] = date_format(date_create($request->date),"d-m-Y") ; 
      
        $data['text_null'] = '';
        $data['trips'] = [];

        $getStationFrom = DB::table('station')->where('city', $request->from)->get();
        $getStationTo = DB::table('station')->where('city', $request->to)->get();

        if ($getStationFrom->count() == 0 or $getStationTo->count() == 0) {
            $data['text_null'] = 'Không tìm thấy chuyền đi nào thuộc 2 thành phố bạn chọn trong ngày ' . $request->date;
            return view('pages.ticket', ['data' => $data]);
        }

        $arrayRoads = [];
        foreach ($getStationFrom as $stationFrom) {
            foreach ($getStationTo as $stationTo) {
                $getRoad = DB::table('roads')->where('garages_id_first', $stationFrom->id)->where('garages_id_second', $stationTo->id)->get();

                if ($getRoad->count() > 0) {
                    foreach ($getRoad as $road) {
                        $getNameStationFirst = DB::table('station')->where('id', $road->garages_id_first)->first();
                        $getNameStationSecond = DB::table('station')->where('id', $road->garages_id_second)->first();
                        $nameRoad = $getNameStationFirst->name . ' - ' . $getNameStationSecond->name;
                        $road->name = $nameRoad;
                        $arrayRoads[] = $road;
                    }
                }
            }
        }

        foreach ($arrayRoads as $record) {
            $getTrips = DB::table('trips')
                ->join('bus', 'bus.id', 'trips.bus_id')
                ->join('bus_type', 'bus.bus_type_id', 'bus_type.id')
                ->where('trips.roads_id', $record->id)
                ->where('trips.date', $request->date)
                ->select('trips.*', 'bus.name', 'bus.license_plate', 'bus.name as bus_name', 'bus_type.name_type', 'bus_type.seat', 'bus.path_of_img')
                ->get();
             
            foreach ($getTrips as $trip) {
                $getCost = DB::table('ticket')->where('trips_id', $trip->id)->first();
                if ($getCost->status == 1 or $getCost->status == 3) {
                    continue;
                }

                $getEstimate = DB::table('trips_estimate')->where('trips_id', $trip->id)->select('trips_estimate.station_id', 'trips_estimate.estimate')->get();
                $calTicketBuy = DB::table('ticket')->where('trips_id', $trip->id)->whereNotNull('name_customer')->whereNotNull('phone_customer')->count();
                $stock = $trip->seat - $calTicketBuy;
                $getgarage = DB::table('garages')->where('id',$trip->garages_id)->first(); 
                $trip->name_garages = $getgarage->name_garage ; 
                $arrayStationForTrips = [];
                foreach ($getEstimate as $estimate) {
                    if (isset($estimate)) {
                        $getNameStationForTrips = DB::table('station')->where('id', $estimate->station_id)->first();
                        $arrayStationForTrips[] = ['station' => $getNameStationForTrips->name, 'estimate' => $estimate->estimate];
                    }
                }

                $trip->stock = $stock;
                $trip->estimate = $arrayStationForTrips;
                $trip->nameRoad = $record->name;
                $trip->cost = $getCost->cost;
                $data['trips'][] = $trip;
            }
        }

        if (count($data['trips']) == 0) {
            $getCity = DB::table('station')->select('city')->groupBy('city')->get();

            $data['text_null'] = 'Không tìm thấy chuyền đi nào thuộc 2 thành phố bạn chọn trong ngày ' . $request->date;
            $data['city'] = [];
            foreach ($getCity as $city) {
                $data['city'][] = $city->city;
            }
            return view('pages.ticket', ['data' => $data]);
        }

        foreach ($data['trips'] as $tripRecord) {
            $getNameDriver = DB::table('users')->where('id', $tripRecord->driver)->first();
            $getNameDriverMate = DB::table('users')->where('id', $tripRecord->driver_mate)->first();
            $getNameGarage = DB::table('garages')->where('id', $tripRecord->garages_id)->first();
           
            $tripRecord->driver_mate = $getNameDriverMate->name;
            $tripRecord->driver = $getNameDriver->name;
            $tripRecord->name_garages = $getNameGarage->name_garage;
            $tripRecord->phone = $getNameGarage->phone;
        }

        $getCity = DB::table('station')->select('city')->groupBy('city')->get();
        $data['city'] = [];
        foreach ($getCity as $city) {
            $data['city'][] = $city->city;
        }

        return view('pages.ticket', ['data' => $data]);
    }

    public function getTime(Request $request)
    {
        $data['bus'] = DB::table('bus')->join('roads', 'bus.roads_id', '=', 'roads.id')
            ->where('bus.roads_id', $request->roads_id)
            ->select('bus.*', 'roads.cost')
            ->get();

        $data['station_from'] = DB::table('station')
            ->join('roads', 'station.roads_id', '=', 'roads.id')
            ->where('station.id', $request->station_id_from)
            ->select('station.*', 'roads.cost', 'roads.garages_id_first', 'roads.garages_id_second')->first();

        $data['station_to'] = DB::table('station')
            ->join('roads', 'station.roads_id', '=', 'roads.id')
            ->where('station.id', $request->station_id_to)
            ->select('station.*', 'roads.cost', 'roads.garages_id_first', 'roads.garages_id_second')->first();

        if ($data['station_from'] == null) {
            $data['station_from'] = false;
        }

        if ($data['station_to'] == null) {
            $data['station_to'] = false;
        }

        return $data;
    }

    public function printTicket(Request $request)
    {
        $data = new \stdClass();

        $payment = Payment::where('payment_id', $request->paymentid)->first();

        for ($i = 0; $i < $payment->total_buy; $i++) {
            $ticket = new Ticket();
            $ticket->where('trips_id', $payment->trips_id)->where('name_customer', null)->where('phone_customer', null)->first()->update(['name_customer' => $payment->name_customer, 'phone_customer' => $payment->phone_customer, 'pay_status' => 1, 'users_id' => $payment->users_id]);
        }

        $payment->update(['status_payment' => 'Thành công']);

        $data->cost = $payment->cost;
        $data->bus = $payment->bus;
        $data->name_customer = $payment->name_customer;
        $data->phone_customer = $payment->phone_customer;
        $data->name = $payment->name;
        $data->license_plate = $payment->license_plate;
        $data->roads = $payment->roads;
        $data->start = $payment->start;
        $data->end = $payment->end;
        $data->driver = $payment->driver;
        $data->driver_mate = $payment->driver_mate;
        $data->date = $payment->date;
        $data->total_buy = $payment->total_buy;
        $data->trips_id = $payment->trips_id;
        $data->payment_id = $payment->payment_id;

        return view('pages.buy-successful', ['data' => $data]);
    }

    public function viewProfile()
    {
        $dob = Auth::user()->dob;
        $explode = explode('-', $dob);

        $data['day'] = $explode[2];
        $data['year'] = $explode[0];
        $data['month'] = $explode[1];

        return view('pages.profile', ['data' => $data]);
    }

    public function viewHistory()
    {
        $query = DB::table('ticket')
            ->where('users_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')->get();

        $data = [];
        $total_cost = 0;
       
        foreach ($query as $history) {
            $getTrips = DB::table('trips')->where('id', $history->trips_id)->first();
            $getRoads = DB::table('roads')->where('id', $getTrips->roads_id)->first();
            $getStation1 = DB::table('station')->where('id', $getRoads->garages_id_first)->first();
            $getStation2 = DB::table('station')->where('id', $getRoads->garages_id_second)->first();
            $getCode = DB::table('payment')->where('trips_id', $history->trips_id)->where('users_id', Auth::user()->id)->first();
            $getgarage = DB::table('garages')->where('id',$getTrips->garages_id)->first(); 
            $history->name_garages =  $getgarage->name_garage ; 
            $history->code = $getCode->payment_id;
            $history->name_roads = $getStation1->name . ' - ' . $getStation2->name;
            $history->date = $getTrips->date;

            $history->total_buy = DB::table('ticket')->where('name_customer', $history->name_customer)
                ->where('phone_customer', $history->phone_customer)->where('trips_id', $history->trips_id)->count();

            if (count($data) == 0) {
                $data[$history->date][] = $history;
                continue;
            }

            if (isset($data[$history->date])) {
                foreach ($data[$history->date] as $trips) {
                    if ($trips->trips_id == $history->trips_id) {
                        continue 2;
                    }
                }
            }

            $data[$history->date][] = $history;
            $total_cost = $total_cost + $history->cost;
        }

        return view('pages.history-buy', ['data' => $data, 'total_cost' => $total_cost]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        $userPassword = $user->password;

        if (!Hash::check($request->current_password, $userPassword)) {
            return back()->withErrors(['current_password' => 'Xác nhận mật khẩu không trùng khớp']);
        }

        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->back()->with('success', 'Mật khẩu đã được thay đổi!');
    }

    public function updateProfile(Request $request)
    {
        $dob =  $request->year . '-' . $request->month . '-' . $request->day;

        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['name' => $request->name, 'phone' => $request->phone, 'cmt' => $request->cmt, 'gender' => $request->gender, 'dob' => $dob]);

        return redirect()->back()->with('success', 'Thông tin cá nhân thay đổi thành công!');
    }
}
