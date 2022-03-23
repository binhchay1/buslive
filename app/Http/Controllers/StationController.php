<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Station;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StationController extends Controller
{
    public function viewStation()
    {
        $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();
        $data = Station::where('garages_id', $query->id)->where('status', true)->get();

        return view('admin.station', ['data' => $data]);
    }

    public function addStation(Request $request)
    {
        $input = $request->all();

        $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();
        $station = new Station();

        $station->name = $input['name'];
        $station->address = $input['address'];
        $station->city = $input['city'];
        $station->garages_id = $query->id;

        $station->save();

        return redirect('/admin/station')->with('status', 'Trạm dừng đã được thêm!');
    }

    public function editStation(Request $request)
    {
        $station = new Station();

        $station->where('id', $request->id)->update(['name' => $request->name, 'address' => $request->address, 'city' => $request->city]);

        return redirect('/admin/station')->with('status', 'Trạm dừng thay đổi thành công!');
    }

    public function deleteStation(Request $request)
    {
        $station = Station::where('id', $request->id)->first();
        $station->update(['status' => false]);

        return redirect('/admin/station')->with('status', 'Trạm dừng bị xóa!');
    }
}
