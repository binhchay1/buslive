<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Models\Trips;
use App\Models\Ticket;
use App\Models\TripsClone;
use App\Models\TripsEstimate;
use DateTime;

class TripsController extends Controller
{
    public function viewTrips()
    {
        if (isset($_GET['current_roads_id'])) {
            $data['current_roads_id'] = $_GET['current_roads_id'];
        }

        if (isset($_GET['month'])) {
            $data['month'] = $_GET['month'];
        }

        if (isset($_GET['year'])) {
            $data['year'] = $_GET['year'];
        }

        if (isset($_GET['day'])) {
            $data['day'] = $_GET['day'];
        }

        if (Auth::user()->role == 2) {
            $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();
            $data['role'] = 2;
        } else {
            $query = DB::table('garages')->where('users_id', Auth::user()->sub_user)->first();
            $data['role'] = 3;
            $data['sub_role'] = Auth::user()->sub_role;
        }

        $data['roads'] = DB::table('roads')->where('garages_id', $query->id)->get();
        $data['station'] = DB::table('station')->where('garages_id', $query->id)->where('status', true)->get();
        $data['bus'] = DB::table('bus')->where('garages_id', $query->id)->get();
        $data['driver'] = DB::table('users')->where('sub_user', Auth::user()->id)->where('sub_role', 1)->get();
        $data['driver_mate'] = DB::table('users')->where('sub_user', Auth::user()->id)->where('sub_role', 2)->get();

        Artisan::call('ticket:status');

        return view('admin.trips', ['data' => $data]);
    }

    public function addTrips(Request $request)
    {
        $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();
        $date = DateTime::createFromFormat('d/m/Y', $request->date);

        $getBus = DB::table('bus')->join('bus_type', 'bus.bus_type_id', '=', 'bus_type.id')->where('bus.id', $request->bus)->first();

        if (isset($request->duplicate)) {

            $dateFormat = $date->format('Y-m-d');
            $arraySpecialDate = [];
            foreach ($request->duplicate as $key => $value) {
                $specialDay = $this->changeTextDate($key);
                $getSpecialDay = $this->getSpecialDayInRange($dateFormat, date("Y-m-t", strtotime($dateFormat)), $specialDay);
                if (count($getSpecialDay) > 0) {
                    foreach ($getSpecialDay as $spd) {
                        $arraySpecialDate[] = $spd;
                    }
                }
            }

            sort($arraySpecialDate);
            

            foreach ($arraySpecialDate as $spdInList) {
                $trips = new Trips();
                $trips_clone = new TripsClone();

                $queryCheck = DB::table('trips')->where('bus_id', $request->bus)->where('date', $spdInList)->where('roads_id', $request->roads)->where('start', $request->start)->where('end', $request->end)->where('garages_id', $query->id)->first();
                if (!empty($queryCheck)) {
                    continue;
                }

                if (strtotime(date('d/m/Y')) == strtotime($spdInList)) {
                    if (date('H:i') > $request->start) {
                        continue;
                    }
                }

                $getTripsForCheckDriver = DB::table('trips')->where('date', $spdInList)->where('driver', $request->driver)->orWhere('driver_mate', $request->driver_mate)->get();
                $dateFormat = date ("Y-m-d", strtotime($spdInList));
            foreach ($getTripsForCheckDriver as $trip) {
                if ($trip->start <= $request->start and  $request->start <= $trip->end and $trip->date == $dateFormat) {
                    $searchStatusTicket = DB::table('ticket')->where('trips_id', $trip->id)->first();
                    if ($searchStatusTicket->status == 2) {
                       continue  2; 
                    }
                }elseif($trip->start > $request->start and $trip->start < $request->end and  ($request->end <= $trip->end or $request->end > $trip->end )  and $trip->date == $dateFormat){
                    $searchStatusTicket = DB::table('ticket')->where('trips_id', $trip->id)->first();
                    if ($searchStatusTicket->status == 2) {
                       continue 2 ; 
                    }
                }
            }

                $getTripsForCheckBus = DB::table('trips')->where('date', $spdInList)->where('bus_id', $request->bus)->get();
                foreach ($getTripsForCheckBus as $trip) {
                    if ($trip->start <= $request->start and $request->start <= $trip->end) {
                        $searchStatusTicket = DB::table('ticket')->where('trips_id', $trip->id)->first();
                        if ($searchStatusTicket->status == 2) {
                            continue 2;
                        }
                    }
                }
    
                $trips->date = $spdInList;
                $trips_clone->date = $spdInList;

                $trips->name = $request->name;
                $trips->bus_id = $request->bus;
                $trips->roads_id = $request->roads;
                $trips->roads_clone_id = $request->roads;
                $trips->start = $request->start;
                $trips->end = $request->end;
                $trips->garages_id = $query->id;
                $trips->driver = $request->driver;
                $trips->driver_mate = $request->driver_mate;

                $trips_clone->name = $request->name;
                $trips_clone->bus_id = $request->bus;
                $trips_clone->roads_id = $request->roads;
                $trips_clone->roads_clone_id = $request->roads;
                $trips_clone->start = $request->start;
                $trips_clone->end = $request->end;
                $trips_clone->garages_id = $query->id;
                $trips_clone->driver = $request->driver;
                $trips_clone->driver_mate = $request->driver_mate;

                $trips_clone->save();
                $trips->save();

                if (is_array($request->estimate) || is_object($request->estimate)) {
                    foreach ($request->estimate as $estimate) {
                        foreach ($estimate as $key => $value) {
                            $trips_estimate = new TripsEstimate();

                            $trips_estimate->station_id = $key;
                            $trips_estimate->estimate = $value;
                            $trips_estimate->trips_id = $trips->id;

                            $trips_estimate->save();
                        }
                    }
                }

                for ($i = 0; $i < $getBus->seat; $i++) {
                    $ticket = new Ticket();

                    $ticket->cost = $request->cost;
                    $ticket->trips_id = $trips->id;
                    $ticket->status = 2;

                    $ticket->save();
                }
            }
        } else {
            $getTripsForCheckDriver = DB::table('trips')->where('date', $date->format('Y-m-d'))->where('driver', $request->driver)->orWhere('driver_mate', $request->driver_mate)->get();
            $getTripsForCheckBus = DB::table('trips')->where('date', $date->format('Y-m-d'))->where('bus_id', $request->bus)->get();

            if ($request->driver == $request->driver_mate) {
                return redirect('/admin/trips')->with('status', 'Tài xế và phụ xe trùng nhau!');
            }

            if (date('d/m/Y') == $request->date and !isset($request->duplicate)) {
                $checkStart = $request->start . ':00';
                if (strtotime(date('H:i:s')) >= strtotime($checkStart)) {
                    return redirect('/admin/trips')->with('status', 'Không thể tạo chuyến đi trong quá khứ!');
                }
            }

            
            $dateFormat = $date->format('Y-m-d');
            foreach ($getTripsForCheckDriver as $trip) {
            
                if ($trip->start <= $request->start and  $request->start <= $trip->end and $trip->date == $dateFormat) {
                    $searchStatusTicket = DB::table('ticket')->where('trips_id', $trip->id)->first();
                    if ($searchStatusTicket->status == 2) {
                        return redirect('/admin/trips')->with('status', 'Tài xế hoặc phụ xe đã được phân công trong thời gian đó!');
                    }
                }elseif($trip->start > $request->start and $trip->start < $request->end and  ($request->end <= $trip->end or $request->end > $trip->end )  and $trip->date == $dateFormat){
                    $searchStatusTicket = DB::table('ticket')->where('trips_id', $trip->id)->first();
                    if ($searchStatusTicket->status == 2) {
                        return redirect('/admin/trips')->with('status', 'Tài xế hoặc phụ xe đã được phân công trong thời gian đó!');
                    }
                }
            }

            foreach ($getTripsForCheckBus as $trip) {
                if ($trip->start <= $request->start and $request->start <= $trip->end) {
                    $searchStatusTicket = DB::table('ticket')->where('trips_id', $trip->id)->first();
                    if ($searchStatusTicket->status == 2) {
                        return redirect('/admin/trips')->with('status', 'Xe đã được phân công trong thời gian đó!');
                    }
                }
            }

            $dateFormat = $date->format('Y-m-d');

            $queryCheck = DB::table('trips')->where('bus_id', $request->bus)->where('date', $dateFormat)->where('roads_id', $request->roads)->where('start', $request->start)->where('end', $request->end)->where('garages_id', $query->id)->first();
            if (!empty($queryCheck)) {
                return redirect('/admin/trips')->with('status', 'Chuyến đi đã tồn tại!');
            }

            $trips = new Trips();
            $trips_clone = new TripsClone();

            $trips->name = $request->name;
            $trips->bus_id = $request->bus;
            $trips->roads_id = $request->roads;
            $trips->roads_clone_id = $request->roads;
            $trips->start = $request->start;
            $trips->end = $request->end;
            $trips->garages_id = $query->id;
            $trips->date = $dateFormat;
            $trips->driver = $request->driver;
            $trips->driver_mate = $request->driver_mate;

            $trips_clone->name = $request->name;
            $trips_clone->bus_id = $request->bus;
            $trips_clone->roads_id = $request->roads;
            $trips_clone->roads_clone_id = $request->roads;
            $trips_clone->start = $request->start;
            $trips_clone->end = $request->end;
            $trips_clone->garages_id = $query->id;
            $trips_clone->date = $dateFormat;
            $trips_clone->driver = $request->driver;
            $trips_clone->driver_mate = $request->driver_mate;

            $trips_clone->save();
            $trips->save();
            if (is_array($request->estimate) || is_object($request->estimate)) {
                foreach ($request->estimate as $estimate) {
                    foreach ($estimate as $key => $value) {
                        $trips_estimate = new TripsEstimate();

                        $trips_estimate->station_id = $key;
                        $trips_estimate->estimate = $value;
                        $trips_estimate->trips_id = $trips->id;

                        $trips_estimate->save();
                    }
                }
            }

            for ($i = 0; $i < $getBus->seat; $i++) {
                $ticket = new Ticket();

                $ticket->cost = $request->cost;
                $ticket->trips_id = $trips->id;
                $ticket->status = 2;

                $ticket->save();
            }
        }

        $explodeForUrl = explode("/", $request->date);
        $urlRedirect = '/admin/trips?current_roads_id=' . $request->roads . '&year=' . $explodeForUrl[2] . '&month=' . $explodeForUrl[1] . '&day=' . $explodeForUrl[0];

        return redirect($urlRedirect)->with('status', 'Chuyến đi đã được thêm!');
    }

    public function getSpecialDayInRange($dateFromString, $dateToString, $day)
    {
        $endDate = strtotime($dateToString);
        $dates = [];
        for ($i = strtotime($day, strtotime($dateFromString)); $i <= $endDate; $i = strtotime('+1 week', $i)) {

            $dates[] = date('Y-m-d', $i);
        }

        return $dates;
    }

    public function changeTextDate($date)
    {

        if ($date == 't2') {
            $date = 'Monday';
        }

        if ($date == 't3') {
            $date = 'Tuesday';
        }

        if ($date == 't4') {
            $date = 'Wednesday';
        }

        if ($date == 't5') {
            $date = 'Thursday';
        }

        if ($date == 't6') {
            $date = 'Friday';
        }

        if ($date == 't7') {
            $date = 'Saturday';
        }

        if ($date == 'cn') {
            $date = 'Sunday';
        }

        return $date;
    }
}
