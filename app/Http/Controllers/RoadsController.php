<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roads;
use App\Models\Station;
use App\Models\Bus;
use Illuminate\Support\Facades\DB;

class RoadsController extends Controller
{
    public function viewRoads()
    {
        $data['roads'] = Roads::paginate(10);
        $data['garages'] = DB::table('garages')->get();

        foreach ($data['roads'] as $road) {
            foreach($data['garages'] as $garage) {
                if($road->garages_id_first == $garage->id) {
                    $road->name_first = $garage->name_garage;
                }
                if($road->garages_id_second == $garage->id) {
                    $road->name_second = $garage->name_garage;
                }
            }
        }

        return view('admin.roads', ['data' => $data]);
    }

    public function addRoads(Request $request)
    {
        $input = $request->all();

        if($input['garage1'] == $input['garage2']) {
            return redirect('/admin/roads')->with('status', 'Garage 1 same Garage 2!');
        }

        $query1 = DB::table('roads')->where('garages_id_first', $input['garage1'])->where('garages_id_second', $input['garage2'])->get();
        $query2 = DB::table('roads')->where('garages_id_first', $input['garage2'])->where('garages_id_second', $input['garage1'])->get();
        if($query1->count() > 0 or $query2->count() > 0) {
            return redirect('/admin/roads')->with('status', 'Roads exists!');
        }

        $road = new Roads();

        $road->garages_id_first = $input['garage1'];
        $road->garages_id_second = $input['garage2'];
        $road->cost = $input['cost'];

        $road->save();

        return redirect('/admin/roads')->with('status', 'Roads added!');
    }

    public function editRoads(Request $request)
    {
        $road = new Roads();
        $road->where('id', $request->id)->update(['garages_id_first' => $request->garages_id_first, 'garages_id_second' => $request->garages_id_second, 'cost' => $request->cost]);

        return redirect('/admin/roads')->with('status', 'Roads edited!');
    }

    public function deleteRoads(Request $request)
    {
        $road = Roads::where('id', $request->id)->first();
        $station = Station::where('roads_id', $request->id)->delete();
        $bus = Bus::where('roads_id', $request->id)->delete();
        $road->delete();

        return redirect('/admin/roads')->with('status', 'Roads deleted!');
    }
}
