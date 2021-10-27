<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function viewDashBoard() {
        return view('admin.dashboard');
    }

    public function viewEmployee() {
        return view('admin.employee');
    }

    public function viewGarages() {
        return view('admin.garages');
    }

    public function viewProfile() {
        return view('admin.profile');
    }
}
