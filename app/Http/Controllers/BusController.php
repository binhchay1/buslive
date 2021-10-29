<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;
use Illuminate\Support\Facades\DB;

class BusController extends Controller
{
    public function viewBus()
    {
        $data['bus'] = DB::table('bus')->join('garages', 'bus.garages_id', '=', 'garages.id')
            ->select('bus.*', 'garages.name_garage')
            ->paginate(15);

        $data['garages'] = DB::table('garages')->get();

        return view('admin.bus', ['data' => $data]);
    }

    public function addBus(Request $request)
    {
        $input = $request->all();

        $bus = new Bus();

        $bus->name = $input['name'];
        $bus->license_plate = $input['license_plate'];
        $bus->garages_id = $input['garages'];

        $bus->save();

        return redirect('/admin/bus')->with('status', 'Bus added!');
    }

    public function editBus(Request $request)
    {
        $bus = new Bus();
        $bus->where('id', $request->id)->update(['name' => $request->name, 'license_plate' => $request->license_plate, 'garages_id' => $request->garages]);
        return redirect('/admin/bus')->with('status', 'Bus edited!');
    }

    public function deleteBus(Request $request)
    {
        $bus = Bus::where('id', $request->id)->first();
        $bus->delete();

        return redirect('/admin/bus')->with('status', 'Bus deleted!');
    }
}
