<?php

namespace App\Http\Controllers;

class ErrorController extends Controller
{
    public function viewErrorPermission() { 
        return view('permission');
    }

    public function viewErrorStatus() { 
        return view('status');
    }
}
