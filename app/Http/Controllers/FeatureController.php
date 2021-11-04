<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class FeatureController extends Controller
{
    public function viewWelcome() { 
        return view('pages/welcome');
    }

    public function viewContact() { 
        return view('pages/contact');
    }

    public function sendContact(Request $request) { 

        $contact = new Contact();

        $contact->first_name = $request->get('firstname');
        $contact->last_name = $request->get('lastname');
        $contact->subject = $request->get('subject');
        $contact->email = $request->get('email');
        $contact->message = $request->get('message');

        $contact->save();
        
        return 'success';
    }

    public function getCity() {

        $citys = DB::table('garages')->select('city')->groupBy('city')->get();
        $data = [];
        foreach($citys as $city) {
            $data[] = $city->city;
        }
        
        return $data;
    }

    public function bookTicket(Request $request) {
        
        $data['from'] = $request->from;
        $data['to'] = $request->to;
        $data['date'] = $request->date;

        $data['allGarageFrom'] = DB::table('garages')->where('city', $data['from'])->get();
        $data['allGarageTo'] = DB::table('garages')->where('city', $data['to'])->get();
        $data['station'] = DB::table('station')->get();
        
        $data['roads'] = DB::table('roads')->get();

        return view('pages.ticket', ['data' => $data]);
    }

    public function getTime(Request $request) {
        $data = DB::table('bus')->where('roads_id', $request->roads_id)->get();

        return $data;
    }
}
