<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Station;
use Illuminate\Support\Facades\DB;

class StationController extends Controller
{
    public function viewStation()
    {
        $data['station'] = Station::paginate(10);
        $data['roads'] = DB::table('roads')->get();

        foreach ($data['station'] as $station) {
            foreach ($data['roads'] as $road) {
                if ($station->roads_id == $road->id) {
                    $garage1 = DB::table('garages')->where('id', $road->garages_id_first)->first();
                    $garage2 = DB::table('garages')->where('id', $road->garages_id_second)->first();
                    $station->road_name = $garage1->name_garage . ' <-> ' . $garage2->name_garage;
                    break;
                }
            }
        }

        foreach ($data['roads'] as $road) {
            $garage1 = DB::table('garages')->where('id', $road->garages_id_first)->first();
            $garage2 = DB::table('garages')->where('id', $road->garages_id_second)->first();
            $road->two_point = $garage1->name_garage . ' <-> ' . $garage2->name_garage;
        }

        return view('admin.station', ['data' => $data]);
    }

    public function addStation(Request $request)
    {
        $input = $request->all();

        $road = DB::table('roads')->where('id', $input['road'])->first();

        if ($input['cost_first'] + $input['cost_second'] != $road->cost) {
            return redirect('/admin/station')->with('status', 'Cost 1 plus Cost 2 not equal Road cost');
        }

        $station = new Station();

        $station->name = $input['name'];
        $station->address = $input['address'];
        $station->cost_first = $input['cost_first'];
        $station->cost_second = $input['cost_second'];
        $station->roads_id = $input['road'];

        $station->save();

        return redirect('/admin/station')->with('status', 'Stations added!');
    }

    public function editStation(Request $request)
    {
        $station = new Station();
        $station->where('id', $request->id)->update(['garages_id_first' => $request->garages_id_first, 'garages_id_second' => $request->garages_id_second, 'cost' => $request->cost]);

        return redirect('/admin/station')->with('status', 'Stations edited!');
    }

    public function deleteStation(Request $request)
    {
        $station = Station::where('id', $request->id)->first();
        $station->delete();

        return redirect('/admin/station')->with('status', 'Stations deleted!');
    }
}
