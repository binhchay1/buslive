<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Garages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use File;

class GaragesController extends Controller
{
    public function viewGarages()
    {
        $data = Garages::paginate(10);
        return view('admin.garages', ['data' => $data]);
    }

    public function addGarages(Request $request)
    {
        $input = $request->all();

        if ($request->banner) {
            $path = '/uploads/garages/';
            $pathMove = 'uploads\garages';

            $imageName = 'banner_' . time() . '._' . $input['name'] . '.' . $request->banner->extension();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $request->banner->move(public_path($pathMove), $imageName);
        } else {
            $imageName = '';
            $path = '';
        }

        $garage = new Garages();

        $garage->name_garage = $input['name'];
        $garage->path_of_banner = $path . $imageName;
        $garage->phone = $input['phone'];
        $garage->address = $input['address'];

        $garage->save();

        return redirect('/admin/garages')->with('status', 'Garage added!');
    }

    public function editGarages(Request $request)
    {
        if ($request->banner) {
            $path = '/uploads/garages/';
            $pathMove = 'uploads\garages';

            $imageName = 'banner_' . time() . '._' . $input['name'] . '.' . $request->banner->extension();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $request->banner->move(public_path($pathMove), $imageName);

            $garage = new Garages();
            $garage->where('id', $request->id)->update(['name_garage' => $request->name, 'path_of_banner' => $path . $imageName, 'phone' => $request->phone, 'address' => $request->address]);

            if (file_exists(public_path($path))) {
                unlink(public_path($path));
            }

        } else {
            $imageName = '';
            $path = '';

            $garage = new Garages();
            $garage->where('id', $request->id)->update(['name_garage' => $request->name, 'phone' => $request->phone, 'address' => $request->address]);
        }


        return redirect('/admin/garages')->with('status', 'Garage edited!');
    }

    public function deleteGarages(Request $request)
    {
        $users = Garages::where('id', $request->id)->first();
        $users->delete();

        return redirect('/admin/garages')->with('status', 'Garage deleted!');
    }
}
