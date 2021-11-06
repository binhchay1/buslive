<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class FeatureController extends Controller
{
    public function viewWelcome()
    {
        return view('pages/welcome');
    }

    public function viewContact()
    {
        return view('pages/contact');
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

    public function getCity()
    {

        $citys = DB::table('garages')->select('city')->groupBy('city')->get();
        $data = [];
        foreach ($citys as $city) {
            $data[] = $city->city;
        }

        return $data;
    }

    public function bookTicket(Request $request)
    {
        if($request->date === null) {
            $request->date = date("Y-m-d");
        }

        $data['from'] = $request->from;
        $data['to'] = $request->to;
        $data['date'] = $request->date;
        $data['allGarageFrom'] = DB::table('garages')->where('city', $data['from'])->get();
        $data['allGarageTo'] = DB::table('garages')->where('city', $data['to'])->get();
        $data['station'] = DB::table('station')->get();
        $data['ticket'] = DB::table('ticket')->get();
        $data['roads'] = DB::table('roads')->get();
        $data['disable_seat'] = DB::table('ticket')->where('date', $request->date)->get();

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

    public function takeTicket(Request $request) {
        $ticket = new Ticket();

        $ticket->date = $request->date;
        $ticket->from = $request->from;
        $ticket->to = $request->to_number;
        $ticket->station_from = $request->station_from;
        $ticket->station_to = $request->station_to;
        $ticket->time_go = $request->time_go;
        $ticket->code = $request->code;
        $ticket->seat = $request->seat;
        $ticket->bus_id = $request->bus_id;
        $ticket->cost = $request->cost;
        $ticket->users_id = $request->users_id;

        $ticket->save();

        $data = $ticket;
        $data->bus_name = $request->name_of_bus;
        $data->place_from = $request->place_from;
        $data->place_to = $request->place_to;
        $data->license_plate = $request->license_plate_of_bus;

        return view('pages.buy-successful', ['data' => $data]);
    }
}
