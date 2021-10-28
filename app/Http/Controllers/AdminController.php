<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function viewDashBoard() {
        return view('admin.dashboard');
    }

    public function viewProfile() {
        return view('admin.profile');
    }
}
