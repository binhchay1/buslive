<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoadsController extends Controller
{
    public function viewRoads()
    {
        $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();
        $data['roads'] = DB::table('roads')->where('garages_id', $query->id)->where('status', true)->get();
        $data['station'] = DB::table('station')->where('garages_id', $query->id)->where('status', true)->get();

        if (count($data['roads']) == 0) {
            return view('admin.roads', ['data' => $data]);
        }

        foreach ($data['roads'] as $road) {
            $road->arrStation = '';
            foreach ($data['station'] as $station) {
                if ($road->garages_id_first == $station->id) {
                    $road->name_first = $station->name;
                }
                if ($road->garages_id_second == $station->id) {
                    $road->name_second = $station->name;
                }
            }
        }

        foreach ($data['roads'] as $road) {
            $road->arrStation = '';
            $arrayStation = explode(",", $road->station);
            foreach ($arrayStation as $stop) {
                foreach ($data['station'] as $station) {
                    if ($stop == $station->id) {
                        $road->arrStation = $road->arrStation . $station->name . ', ';
                    }
                }
            }
            $road->arrStation = rtrim($road->arrStation, ', ');
        }

        return view('admin.roads', ['data' => $data]);
    }

    public function addRoads(Request $request)
    {
        $input = $request->all();
        $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();
        $road = new Roads();

        $road->name = $input['name'];
        $road->garages_id_first = $input['garage1'];
        $road->garages_id_second = $input['garage2'];
        $road->garages_id = $query->id;
        $road->station = $input['arrayStation'];

        $road->save();

        return redirect('/admin/roads')->with('status', 'Tuyến đường đã được thêm!');
    }

    public function editRoads(Request $request)
    {
        $road = new Roads();
        $road->where('id', $request->id)->update(['name' => $request->name, 'garages_id_first' => $request->garage1, 'garages_id_second' => $request->garage2, 'station' => $request->arrayStation]);

        return redirect('/admin/roads')->with('status', 'Tuyến đường thay đổi thành công!');
    }

    public function deleteRoads(Request $request)
    {
        $road = Roads::where('id', $request->id)->first();
        $road->update(['status' => false]);

        return redirect('/admin/roads')->with('status', 'Xóa tuyến đường thành công!');
    }
}
