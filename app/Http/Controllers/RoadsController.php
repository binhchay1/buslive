<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roads;

class RoadsController extends Controller
{
    public function viewGarages()
    {
        $data = Roads::paginate(10);
        return view('admin.roads', ['data' => $data]);
    }

    public function addGarages(Request $request)
    {
        $input = $request->all();

        $road = new Roads();

        $road->name_garage = $input['name'];
        $road->phone = $input['phone'];
        $road->address = $input['address'];
        $road->city = $input['city'];

        $road->save();

        return redirect('/admin/garages')->with('status', 'Garage added!');
    }

    public function editGarages(Request $request)
    {
        if ($request->banner) {
            $path = '/uploads/garages/';
            $pathMove = 'uploads\garages';

            $imageName = 'banner_' . time() . '._' . $request->name . '.' . $request->banner->extension();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $request->banner->move(public_path($pathMove), $imageName);

            $road = new Roads();
            $road->where('id', $request->id)->update(['name_garage' => $request->name, 'path_of_banner' => $path . $imageName, 'phone' => $request->phone, 'address' => $request->address, 'city' => $request->city]);
        } else {
            $imageName = '';
            $path = '';

            $road = new Roads();
            $road->where('id', $request->id)->update(['name_garage' => $request->name, 'phone' => $request->phone, 'address' => $request->address, 'city' => $request->city]);
        }


        return redirect('/admin/garages')->with('status', 'Garage edited!');
    }
}
