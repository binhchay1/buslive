<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

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
}
