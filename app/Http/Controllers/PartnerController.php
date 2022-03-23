<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    public function viewPartner()
    {
        $data = DB::table('partner')->get();
        
        return view('admin.partner', ['data' => $data]);
    }
}
