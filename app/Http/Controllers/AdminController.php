<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function viewDashBoard() {
        return view('admin.dashboard');
    }

    public function viewEmployee() {
        $data = DB::table('users')->paginate(10);
        return view('admin.employee', ['data' => $data]);
    }

    public function viewGarages() {

        return view('admin.garages');
    }

    public function viewProfile() {
        return view('admin.profile');
    }
}
