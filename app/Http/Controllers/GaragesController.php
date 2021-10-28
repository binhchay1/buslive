<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Garages;

class GaragesController extends Controller
{
    public function viewGarages() {
        $data = Garages::paginate(10);
        return view('admin.garages', ['data' => $data]);
    }

    public function addGarages(Request $request) {
        dd($request);
    }
}
