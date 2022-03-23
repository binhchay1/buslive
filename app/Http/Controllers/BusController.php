<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bus;
use App\Models\BusType;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BusRequest;

class BusController extends Controller
{
    public function viewBus()
    {
        $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();
        $data = DB::table('bus')->join('bus_type', 'bus.bus_type_id', '=', 'bus_type.id')->where('bus.status', true)->where('bus.garages_id', $query->id)->select('bus.*', 'bus_type.name_type', 'bus_type.seat')->get();

        return view('admin.bus', ['data' => $data]);
    }


    public function addBus(BusRequest $request)
    {
        if((filesize($request->img)/ 1024 / 1024) > 4) {
            return redirect('/admin/bus')->with('status', 'Dung lượng file upload vượt 4MB!');
        }

        $input = $request->all();

        $bus = new Bus();
        $bus_type = new BusType();
        $query = DB::table('garages')->where('users_id', Auth::user()->id)->first();
        $checkBusType = DB::table('bus_type')->where('name_type', $input['name_type'])->where('seat', $input['seat'])->first();
        $busTypeId = 0;

        $path = '/uploads/bus/';
        $pathMove = 'uploads\bus';

        $imageName = 'bus_' . time() . '._' . $request->name . '.' . $request->img->extension();
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $bus_photo_path = $path . $imageName;

        $request->img->move(public_path($pathMove), $imageName);

        if (count((array)$checkBusType) > 0) {
            $busTypeId = $checkBusType->id;
        } else {
            $bus_type->name_type = $input['name_type'];
            $bus_type->seat = $input['seat'];

            $bus_type->save();
            $busTypeId = $bus_type->id;
        }

        $bus->path_of_img = $bus_photo_path;
        $bus->name = $input['name'];
        $bus->license_plate = $input['license_plate'];
        $bus->garages_id = $query->id;
        $bus->bus_type_id = $busTypeId;

        $bus->save();

        return redirect('/admin/bus')->with('status', 'Xe khách đã được thêm!');
    }

    public function editBus(BusRequest $request)
    {   
        $bus = new Bus();
        $bus_type = new BusType();

        if((filesize($request->img)/ 1024 / 1024) > 4) {
            return redirect('/admin/bus')->with('status', 'Dung lượng tệp tin upload vượt 4MB!');
        }
      
        

        $checkBusType = DB::table('bus_Type')->where('name_type', $request->name_type)->where('seat', $request->seat)->first();
        $busTypeId = 0;

        if (isset($request->img)) {
            if(!is_array(getimagesize($request->img))) {
                return redirect('/admin/bus')->with('status','Tệp tin upload phải là ảnh!');
            }   
            $path = '/uploads/bus/';
            $pathMove = 'uploads\bus';

            $imageName = 'bus_' . time() . '._' . $request->name . '.' . $request->img->extension();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $bus_photo_path = $path . $imageName;

            $request->img->move(public_path($pathMove), $imageName);

            $bus->where('id', $request->id)->update(['path_of_img' => $bus_photo_path]);
        }

        if (count((array)$checkBusType) > 0) {
            $busTypeId = $checkBusType->id;
        } else {
            $bus_type->name_type = $request->name_type;
            $bus_type->seat = $request->seat;

            $bus_type->save();
            $busTypeId = $bus_type->id;
        }

        $bus->where('id', $request->id)->update(['name' => $request->name, 'license_plate' => $request->license_plate, 'bus_type_id' => $busTypeId]);

        return redirect('/admin/bus')->with('status', 'Xe khách đã được thay đổi!');
    }

    public function deleteBus(Request $request)
    {
        $bus = Bus::where('id', $request->id)->first();
        $bus->update(['status' => false]);

        return redirect('/admin/bus')->with('status', 'Xe khách đã bị xóa!');
    }

    public function hoursToMinutes($hours)
    {
        $minutes = 0;
        if (strpos($hours, ':') !== false) {
            list($hours, $minutes) = explode(':', $hours);
        }
        return $hours * 60 + $minutes;
    }
}
