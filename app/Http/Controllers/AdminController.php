<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Trips;
use App\Models\Ticket;
use App\Models\TripsEstimate;
use DateTime;
use App\Http\Requests\ChangePasswordRequest;

class AdminController extends Controller
{
    public function viewMapShare()
    {
        $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();

        $data = DB::table('bus')->join('bus_type', 'bus.bus_type_id', '=', 'bus_type.id')
        ->where('bus.status', true)
        ->where('bus.garages_id', $query->id)
        ->select('bus.*', 'bus_type.name_type', 'bus_type.seat')
        ->get();
        
        return view('map-share',['data' => $data]);
    }

    public function viewDashBoard()
    {
      
        $data['customers'] = [];
        $data['bus'] = [];
        $data['roads'] = [];
        $bus = DB::table('bus')->join('garages', 'garages.id', '=', 'bus.garages_id')
            ->where('garages.users_id', Auth::user()->id)
            // ->where('bus.status', true)
            ->select('bus.*')
            ->get();

        $roads = DB::table('roads')->join('garages', 'garages.id', '=', 'roads.garages_id')
            ->where('garages.users_id', Auth::user()->id)
            // ->select('bus.*')
            ->select('roads.*')
            ->get();
        foreach($roads as $road){

            $roadTotalMoney =0;//biến chứa tổng tiền đã thu được 
            $roadPercentPaid =0;//biến chứa phần trăm lấp đầy vé 

            $roadTicketsPaid = DB::table('ticket')->join('trips', 'trips.id', '=', 'ticket.trips_id') //đếm tổng số vé đã bán theo tuyến đường đã chọn trong tháng hiện tại
            ->where('trips.roads_id', $road->id)
            ->whereMonth('trips.date', date('m'))
            ->whereNotNull('phone_customer')
            ->whereNotNull('name_customer')
            ->count();

            $roadTicketTotals = DB::table('ticket')->join('trips', 'trips.id', '=', 'ticket.trips_id') //đếm tổng số vé của tuyến đường trong tháng hiện tại
            ->where('trips.roads_id', $road->id)
            ->whereMonth('trips.date', date('m'))
            ->count();
            $roadTripTotals = DB::table('trips') //đếm tổng số chuyến của tuyến đường trong tháng hiện tại
            ->where('trips.roads_id', $road->id)
            ->whereMonth('trips.date', date('m'))
            ->count();
            
            $roadTickets = DB::table('ticket')->join('trips', 'trips.id', '=', 'ticket.trips_id') //lấy tất cả các vé theo tuyến đường đã chọn trong tháng hiện tại
            ->where('trips.roads_id', $road->id)
            ->whereMonth('trips.date', date('m'))
            ->select('ticket.*')
            ->get();

            //tính tổng tiền đã bán được theo tuyến đường
            foreach($roadTickets as $item){
                if($item->name_customer != null && $item->phone_customer !=null){
                    $roadTotalMoney += $item->cost;
                }
            }
            
            //tính phần trăm số vé lấp đầy trên tổng số vé của tuyến đường đấy
            if($roadTicketTotals != 0){
                $roadPercentPaid = substr((($roadTicketsPaid/$roadTicketTotals) *100),0,5);
            }
            
            $road->roadTotalMoney =$roadTotalMoney;
            $road->roadTicketsPaid =$roadTicketsPaid;
            $road->roadPercentPaid =$roadPercentPaid;
            $road->roadTicketTotals =$roadTicketTotals;
            $road->roadTripTotals =$roadTripTotals;
        }

        $data['road'] =$roads->toarray();

        foreach ($bus as $record) {
            $diff = 0;
            $query = DB::table('ticket')->join('trips', 'trips.id', '=', 'ticket.trips_id')->where('trips.bus_id', $record->id)->whereNotNull('phone_customer')->whereNotNull('name_customer')->count();
            $queryCheck = DB::table('ticket')
                ->join('trips', 'trips.id', '=', 'ticket.trips_id')
                ->whereYear('ticket.created_at', date('Y'))
                ->whereMonth('ticket.created_at', date('m'))
                ->where('trips.bus_id', $record->id)
                // ->whereNotNull('phone_customer')
                // ->whereNotNull('name_customer')
                ->count();

            $getTicket = DB::table('ticket')
                ->join('trips', 'trips.id', '=', 'ticket.trips_id')
                ->whereYear('ticket.created_at', date('Y'))
                ->whereMonth('ticket.created_at', date('m'))
                ->where('trips.bus_id', $record->id)
                ->whereNotNull('phone_customer')
                ->whereNotNull('name_customer')
                ->get();

            $countMoney = 0;
            foreach ($getTicket as $ticket) {
                $countMoney += $ticket->cost;
            }
            
            if ($queryCheck != 0) {
                $diff = ($query / $queryCheck) * 100;
              
            }

            $record->totalcheck = $query;
            $record->total = $queryCheck;
            $record->diff =substr($diff,0,5);
            $record->countMoney = $countMoney;
        }

        $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();
        $getTrips = DB::table('trips')->where('garages_id', $query->id)->get();

        $data['pay'] = [];
        $arrayCustomerTotal = [];
        $onlineCount = 0;
        $offlineCount = 0;
        $bankCount = 0;
        foreach ($getTrips as $trip) {
            $getTicket = DB::table('ticket')->where('trips_id', $trip->id)->get();
            foreach ($getTicket as $ticket) {
                if (!empty($ticket->name_customer) and !empty($ticket->phone_customer)) {
                    $arrayCheck = [];
                    $getTotalBuy = DB::table('ticket')->where('name_customer', $ticket->name_customer)
                        ->where('phone_customer', $ticket->phone_customer)->where('trips_id', $ticket->trips_id)->count();

                    $arrayCheck = ['name_customer' => $ticket->name_customer, 'phone_customer' => $ticket->phone_customer, 'totalBuy' => $getTotalBuy, 'pay_status' => $ticket->pay_status];

                    if (in_array($arrayCheck, $arrayCustomerTotal)) {
                        continue;
                    } else {
                        $arrayCustomerTotal[] = ['name_customer' => $ticket->name_customer, 'phone_customer' => $ticket->phone_customer, 'totalBuy' => $getTotalBuy, 'pay_status' => $ticket->pay_status];
                    }
                }
            }
        }

        foreach ($arrayCustomerTotal as $customer) {
            if ($customer['pay_status'] == 1) {
                $onlineCount++;
            }

            if ($customer['pay_status'] == 2) {
                $offlineCount++;
            }

            if ($customer['pay_status'] == 3) {
                $bankCount++;
            }
        }
        $total =0;
        $onlinePercent =0;
        $offlinePercent =0;
        $bankPercent =0;
        $total = $onlineCount + $offlineCount + $bankCount; 

        if($total !=0) {
            $onlinePercent = ($onlineCount/$total) *100; 
            $offlinePercent = ($offlineCount/$total) *100; 
            $bankPercent = ($bankCount/$total) *100;
        }
        $data['pay'][] = ['type' => 'Thanh toán online', 'turn' => substr($onlinePercent,0,5)];
        $data['pay'][] = ['type' => 'Thanh toán trực tiếp', 'turn' => substr($offlinePercent,0,5)];
        $data['pay'][] = ['type' => 'Chuyển khoản', 'turn' => substr($bankPercent,0,5)];

        $data['bus'] = $bus->toArray();
        usort($data['bus'], fn ($a, $b) => strcmp($a->countMoney, $b->countMoney));

        return view('admin.dashboard', ['data' => $data]);
    }

    public function viewProfile()
    {
        $data['garages'] = DB::table('users')
            ->where('id', Auth::user()->sub_user)->first();

        return view('admin.profile', ['data' => $data]);
    }

    public function uploadAvatar(Request $request)
    {
        $path = '/uploads/profile/';
        $pathMove = 'uploads\profile';

        $imageName = 'avatar_' . time() . '._' . Auth::user()->name . '.' . $request->avatar->extension();
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $profile_photo_path = $path . '/' . $imageName;

        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['profile_photo_path' => $profile_photo_path]);

        $request->avatar->move(public_path($pathMove), $imageName);

        return redirect('/admin/profile');
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

    public function getDataTrips(Request $request)
    {
        $arrayWeek = $request->week;
        $year = $request->year;
        $roadsId = $request->roadsId;
        $data = [];
        $data['totalRecord'] = 0;

        if (Auth::user()->role == 2) {
            $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();
        } else {
            $query = DB::table('garages')->where('users_id', Auth::user()->sub_user)->first();
        }

        foreach ($arrayWeek as $week) {
            $date = $week . '/' . $year;
            $time = DateTime::createFromFormat('d/m/Y', $date);
            $dateFormat = $time->format('Y-m-d');

            if (Auth::user()->role == 2 or Auth::user()->sub_role == 3) {

                $getTrips = DB::table('trips')
                    ->where('garages_id', $query->id)->where('date', $dateFormat)->where('roads_id', $roadsId)->orderBy('start', 'asc')->get();

                foreach ($getTrips as $trip) {
                    $getStatus = DB::table('ticket')->where('trips_id', $trip->id)->first();
                    if ($getStatus->status == 1) {
                        $trip->status = 1;
                    }

                    if ($getStatus->status == 2) {
                        $trip->status = 2;
                    }

                    if ($getStatus->status == 3) {
                        $trip->status = 3;
                    }

                    $driver = DB::table('users')->where('id', $trip->driver)->first();
                    $driver_mate = DB::table('users')->where('id', $trip->driver_mate)->first();
                    $bus_name = DB::table('bus')->where('id', $trip->bus_id)->first();

                    $trip->driver = $driver->name;
                    $trip->driver_mate = $driver_mate->name;
                    $trip->bus_name = $bus_name->name;
                }
            } else {

                $getTrips = DB::table('trips')
                    ->where('driver', Auth::user()->id)->where('garages_id', $query->id)->where('date', $dateFormat)->where('roads_id', $roadsId)
                    ->orderBy('start', 'asc')->get();

                if ($getTrips->isEmpty()) {
                    $getTrips = DB::table('trips')
                        ->where('driver_mate', Auth::user()->id)->where('garages_id', $query->id)->where('date', $dateFormat)->where('roads_id', $roadsId)
                        ->orderBy('start', 'asc')->get();

                    foreach ($getTrips as $trip) {
                        $getStatus = DB::table('ticket')->where('trips_id', $trip->id)->first();
                        if ($getStatus->status == 1) {
                            $trip->status = 1;
                        }

                        if ($getStatus->status == 2) {
                            $trip->status = 2;
                        }

                        if ($getStatus->status == 3) {
                            $trip->status = 3;
                        }

                        $driver = DB::table('users')->where('id', $trip->driver)->first();
                        $driver_mate = DB::table('users')->where('id', $trip->driver_mate)->first();
                        $bus_name = DB::table('bus')->where('id', $trip->bus_id)->first();

                        $trip->driver = $driver->name;
                        $trip->driver_mate = $driver_mate->name;
                        $trip->bus_name = $bus_name->name;
                    }
                } else {
                    foreach ($getTrips as $trip) {
                        $getStatus = DB::table('ticket')->where('trips_id', $trip->id)->first();
                        if ($getStatus->status == 1) {
                            $trip->status = 1;
                        }

                        if ($getStatus->status == 2) {
                            $trip->status = 2;
                        }

                        if ($getStatus->status == 3) {
                            $trip->status = 3;
                        }

                        $driver = DB::table('users')->where('id', $trip->driver)->first();
                        $driver_mate = DB::table('users')->where('id', $trip->driver_mate)->first();
                        $bus_name = DB::table('bus')->where('id', $trip->bus_id)->first();

                        $trip->driver = $driver->name;
                        $trip->driver_mate = $driver_mate->name;
                        $trip->bus_name = $bus_name->name;
                    }
                }
            }

            $countTrips = count($getTrips);
            $data['column'][] = $getTrips;
            $data['totalRecord'] = $data['totalRecord'] + $countTrips;
        }

        $countArray = [];
        foreach ($data['column'] as $record) {
            $countArray[] = count($record);
        }
        sort($countArray);

        $data['total'] = end($countArray);

        return $data;
    }

    public function getDataStation(Request $request)
    {
        $getRoads = DB::table('roads')->where('id', $request->roadsId)->first();
        if (Auth::user()->role == 2) {
            $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();
        } else {
            $query = DB::table('garages')->where('users_id', Auth::user()->sub_user)->first();
        }

        $getStation = DB::table('station')->where('garages_id', $query->id)->get();

        $data = [];
        $arrayStation = explode(",", $getRoads->station);
        $count = 0;

        
            foreach ($arrayStation as $stop) {
                foreach ($getStation as $station) {
                if ($stop == $station->id) {
                    $data[$count]['id'] = $station->id;
                    $data[$count]['name'] = $station->name;
                    $count++;
                }
            }
            }
        
        return $data;
    }

    public function getInformationTrips(Request $request)
    {
        $getTrips = DB::table('trips')->where('id', $request->tripsId)->first();
        $getBus = DB::table('bus')->join('bus_type', 'bus.bus_type_id', '=', 'bus_type.id')->where('bus.id', $getTrips->bus_id)->select('bus.*', 'bus_type.name_type', 'bus_type.seat')->first();
        $getRoads = DB::table('roads')->where('id', $getTrips->roads_id)->first();
        $getTicket = DB::table('ticket')->where('trips_id', $getTrips->id)->get();
        $roadsName1 = DB::table('station')->where('id', $getRoads->garages_id_first)->first();
        $roadsName2 = DB::table('station')->where('id', $getRoads->garages_id_second)->first();
        $getDriver = DB::table('users')->where('id', $getTrips->driver)->first();
        $getDriverMate = DB::table('users')->where('id', $getTrips->driver_mate)->first();
        $getTripsEstimate = DB::table('trips_estimate')->where('trips_id', $getTrips->id)->get();

        $arrayEstimate = [];
        foreach ($getTripsEstimate as $estimate) {
            $getNameStation = DB::table('station')->where('id', $estimate->station_id)->first();
            $estimate->station_name = $getNameStation->name;
            $arrayEstimate[] = $estimate;
        }

        $arraySealed = [];
        $arrayBuyers = [];

        foreach ($getTicket as $ticket) {
            if (!empty($ticket->name_customer) and !empty($ticket->phone_customer)) {
                $arraySealed[] = $ticket;
                $arrayCheck = [];
                $getTotalBuy = DB::table('ticket')->where('name_customer', $ticket->name_customer)
                    ->where('phone_customer', $ticket->phone_customer)->where('trips_id', $ticket->trips_id)->where('pay_status',$ticket->pay_status)->count();

                if ($ticket->note == null) {
                    $ticket->note = '';
                }

                $arrayCheck = ['name_customer' => $ticket->name_customer, 'phone_customer' => $ticket->phone_customer, 'totalBuy' => $getTotalBuy, 'note' => $ticket->note, 'pay_status' => $ticket->pay_status];

                if (in_array($arrayCheck, $arrayBuyers)) {
                    continue;
                } else {
                    foreach ($arrayBuyers as $array) {
                        // if (strtoupper($array['name_customer']) == strtoupper($ticket->name_customer) && $array['phone_customer'] == $ticket->phone_customer) {
                        //     continue 2;
                        // }
                    }
                    $arrayBuyers[] = ['name_customer' => $ticket->name_customer, 'phone_customer' => $ticket->phone_customer, 'totalBuy' => $getTotalBuy, 'note' => $ticket->note, 'pay_status' => $ticket->pay_status];
                }
            }
        }

        $data['roads_name'] = $roadsName1->name . '-' . $roadsName2->name;
        $data['bus_name'] = $getBus->name;
        $data['bus_id'] = $getBus->id;
        $data['totalSeat'] = $getBus->seat;
        $data['sale'] = count($arraySealed);
        $data['stock'] = $data['totalSeat'] - $data['sale'];
        $data['cost'] = $getTicket[0]->cost;
        $data['statusIndex'] = $getTicket[0]->status;
        $data['buyers'] = $arrayBuyers;
        $data['tripsId'] = $getTrips->id;
        $data['driver'] = $getDriver;
        $data['driver_mate'] = $getDriverMate;
        $data['estimate'] = $arrayEstimate;
        if ($getTicket[0]->status == 1) {
            $data['status'] = 'Đã chạy';
        }
        if ($getTicket[0]->status == 2) {
            $data['status'] = 'Đã lên lịch';
        }
        if ($getTicket[0]->status == 3) {
            $data['status'] = 'Đã hủy';
        }

        return $data;
    }

    public function saveNote(Request $request)
    {
        $arrayData = explode('-', $request->id);
        $getTrips = DB::table('trips')->where('id', $arrayData[0])->first();
        $getTicket = DB::table('ticket')->where('trips_id', $getTrips->id)->where('name_customer', $arrayData[1])->where('phone_customer', $arrayData[2])->get();

        foreach ($getTicket as $ticket) {
            DB::table('ticket')->where('id', $ticket->id)->update(['note' => $arrayData[3]]);
        }

        return 'success';
    }

    public function cancelTrips(Request $request)
    {
        $getRoads = DB::table('trips')->where('id', $request->tripsId)->first();
       
        if ($request->acceptAll == 'on') {
            $date = new DateTime($request->date);
            $date->modify('last day of this month');
            $lastDate = $date->format('Y-m-d');
            $queryCheck = DB::table('trips')
                ->where('trips.roads_id', $getRoads->roads_id)
                ->where('trips.bus_id', $request->bus)
                ->where('trips.driver', $request->driver)
                ->where('trips.driver_mate', $request->driver_mate)
                ->where('trips.end' , $getRoads->end )
                ->where('trips.start', $request->start)
                ->where('trips.date', '>=', $request->date)
                ->where('trips.date', '<=', $lastDate)
                ->get();

            foreach ($queryCheck as $trip) {
                $checkCost = DB::table('ticket')->where('trips_id', $trip->id)->first();
                if ($checkCost->cost == $request->cost) {
                    $getTrips = DB::table('trips')->where('id', $trip->id)->first();
                    $getTicket = DB::table('ticket')->where('trips_id', $getTrips->id)->get();

                    foreach ($getTicket as $ticket) {
                        DB::table('ticket')->where('id', $ticket->id)->update(['status' => 3]);
                    }
                } else {
                    continue;
                }
            }
        } else {

            $getTrips = DB::table('trips')->where('id', $request->tripsId)->first();
            $getTicket = DB::table('ticket')->where('trips_id', $getTrips->id)->get();

            foreach ($getTicket as $ticket) {
                DB::table('ticket')->where('id', $ticket->id)->update(['status' => 3]);
            }
        }

        $explodeForUrl = explode("-", $request->date);
        $urlRedirect = '/admin/trips?current_roads_id=' . $getRoads->roads_id . '&year=' . $explodeForUrl[0] . '&month=' . $explodeForUrl[1] . '&day=' . $explodeForUrl[2];

        return redirect($urlRedirect)->with('status', 'Chuyến đi đã được hủy!');
    }

    public function rePick(Request $request)
    {
        $getRoads = DB::table('trips')->where('id', $request->tripsId_hidden)->first();
      
      
        if ($request->acceptAll == 'on') {
            $last_date = date("Y-m-t", strtotime($request->date));
            $queryCheck = DB::table('trips')
                ->where('trips.roads_id', $getRoads->roads_id)
                ->where('trips.bus_id', $request->currentBus)
                ->where('trips.driver', $request->currentDriver)
                ->where('trips.driver_mate', $request->currentDriverMate)
                ->where('trips.end' , $getRoads->end )
                ->where('trips.start', $request->currentStart)
                ->whereDate('trips.date', '<=', $last_date)
                ->whereDate('trips.date', '>=', $request->date)
                ->select('trips.*')
                ->get();
            
            foreach ($queryCheck as $trip) {
                $trips = new Trips();
                $trips->where('id', $trip->id)->update(['bus_id' => $request->bus, 'driver' => $request->driver, 'driver_mate' => $request->driver_mate]);

                $ticket = new Ticket();
                $ticket->where('trips_id', $trip->id)->update(['cost' => $request->cost]);
            }
        } else {
            $trips = new Trips();
            $trips->where('id', $request->tripsId_hidden)->update(['bus_id' => $request->bus, 'driver' => $request->driver, 'driver_mate' => $request->driver_mate]);

            $ticket = new Ticket();
            $ticket->where('trips_id', $request->tripsId_hidden)->update(['cost' => $request->cost]);
        }

        $explodeForUrl = explode("-", $request->date);
        $urlRedirect = '/admin/trips?current_roads_id=' . $getRoads->roads_id . '&year=' . $explodeForUrl[0] . '&month=' . $explodeForUrl[1] . '&day=' . $explodeForUrl[2];

        return redirect($urlRedirect)->with('status', 'Chuyến đi đã được thay đổi!');
    }

    public function checkDeleteStation(Request $request)
    {
        $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();
        $checkRoads = DB::table('roads')->where('garages_id', $query->id)->where('status',true)->get();
        $status = 1;

        foreach ($checkRoads as $road) {
            if ($road->garages_id_first == $request->id or $road->garages_id_second == $request->id or strpos($road->station, $request->id)) {
                $status = 0;
            }
        }

        return $status;
    }

    public function checkDeleteEmployee(Request $request)
    {
        if ($request->sub_role == 1) {
            $getTrips = DB::table('trips')->join('ticket', 'trips.id', '=', 'ticket.trips_id')->where('trips.driver', $request->id)->whereDate('trips.date', '>=', date('Y-m-d'))->where('ticket.status', '2')->get();
        } else {
            $getTrips = DB::table('trips')->join('ticket', 'trips.id', '=', 'ticket.trips_id')->where('trips.driver_mate', $request->id)->whereDate('trips.date', '>=', date('Y-m-d'))->where('ticket.status', '2')->get();
        }
        $status = true;

        if ($getTrips->isEmpty()) {
            $status = false;
        }

        return $status;
    }

    public function checkDeleteBus(Request $request)
    {
        $getTrips = DB::table('trips')->join('ticket', 'trips.id', '=', 'ticket.trips_id')->where('trips.bus_id', $request->id)->whereDate('trips.date', '>=', date('Y-m-d'))->where('ticket.status', '2')->get();
        $status = true;

        if ($getTrips->isEmpty()) {
            $status = false;
        }

        return $status;
    }

    public function checkDeleteRoads(Request $request)
    {
        $getTrips = DB::table('trips')->join('ticket', 'trips.id', '=', 'ticket.trips_id')->where('trips.roads_id', $request->id)->whereDate('trips.date', '>=', date('Y-m-d'))->where('ticket.status', '2')->get();
        $status = true;

        if ($getTrips->isEmpty()) {
            $status = false;
        }

        return $status;
    }

    public function saveEstimate(Request $request)
    {
        $arrayData = explode('_', $request->id);
        $trips_estimate = new TripsEstimate();
        $trips_estimate->where('id', $arrayData[2])->update(['estimate' => $request->estimate]);

        return 'success';
    }

    public function saveNewCustomer(Request $request)
    {
        for ($i = 0; $i < $request->total_buy; $i++) {
            $ticket = new Ticket();
            if ($request->note === null) {
                $request->note = '';
            }
            $ticket->where('trips_id', $request->tripsId)->where('name_customer', null)->where('phone_customer', null)->first()->update(['name_customer' => $request->name, 'phone_customer' => $request->phone, 'note' => $request->note, 'pay_status' => $request->pay_status]);
        }

        $getTrips = DB::table('trips')->where('id', $request->tripsId)->first();
        $stock = DB::table('ticket')->where('trips_id', $request->tripsId)->where('name_customer', null)->where('phone_customer', null)->count();
        $getBus = DB::table('bus')->join('bus_type', 'bus.bus_type_id', '=', 'bus_type.id')->where('bus.id', $getTrips->bus_id)->select('bus.*', 'bus_type.name_type', 'bus_type.seat')->first();
        $sell = $getBus->seat - $stock;

        $data['sell'] = $sell;
        $data['stock'] = $stock;
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['pay_status'] = $request->pay_status;
        $data['note'] = $request->note;
        $data['total_buy'] = $request->total_buy;
        $data['tripsId'] = $request->tripsId;

        $data['status_add'] = 1;
        return $data;
    }

    public function checkNull($element)
    {
        if ($element == '' or empty($element)) {
            return false;
        }

        return true;
    }

    public function getAnalystOrder()
    {
        $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();

        for ($i = 0; $i < 12; $i++) {
            $count = 0;
            $getTicket = DB::table('ticket')->join('trips', 'trips.id', '=', 'ticket.trips_id')
                ->whereYear('ticket.created_at', date('Y'))->whereMonth('ticket.created_at', $i + 1)
                ->whereNotNull('phone_customer')->whereNotNull('name_customer')->where('trips.garages_id', $query->id)->get();

            if ($getTicket->count() > 0) {
                foreach ($getTicket as $record) {
                    $count = $count + $record->cost;
                }
            }

            $data['each_month'][$i] = [$count, ($count * 40) / 100];
        }

        $getAllOderOfYear = DB::table('ticket')->join('trips', 'trips.id', '=', 'ticket.trips_id')
            ->where('garages_id', $query->id)
            ->whereYear('ticket.created_at', date('Y'))->whereNotNull('phone_customer')->whereNotNull('name_customer')->get();

        $total = 0;
        foreach ($getAllOderOfYear as $record) {
            $total = $total + $record->cost;
        }

        $data['total'] = $total;

        return $data;
    }

    public function getDataAnalysis(Request $request)
    {

        $getGarages = DB::table('garages')->where('users_id', Auth::user()->id)->first();
        $getRoads = DB::table('roads')->where('garages_id', $getGarages->id)->where('status', true)->get();
        $pieData = new \stdClass();
        $pieData->datasets[] = new \stdClass();
        foreach ($getRoads as $road) {
            $pieData->labels[] = $road->name;
            $getTrips = DB::table('trips')->where('roads_id', $road->id);
            if ($request->type == 'month') {
                $getTrips = $getTrips->whereMonth('created_at', $request->date)->get();
            }

            if ($request->type == 'year') {
                $getTrips = $getTrips->whereYear('created_at', $request->date)->get();
            }

            $total = 0;
            foreach ($getTrips as $trip) {
                $getTicket = DB::table('ticket')->where('trips_id', $trip->id)->whereNotNull('name_customer')->whereNotNull('phone_customer')->get();
                foreach ($getTicket as $ticket) {
                    $total += $ticket->cost;
                }
            }
            $pieData->datasets[0]->data[] = $total;
            $pieData->datasets[0]->backgroundColor[] = $this->random_color();
        }

        return $pieData;
    }

    public function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    public function random_color()
    {
        return '#' . $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
}
