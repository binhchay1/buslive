<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Garages;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\GaragesRequest;
use App\Http\Requests\GaragesEditRequest;
use Illuminate\Support\Facades\DB;

class GaragesController extends Controller
{
    public function viewGarages()
    {
        $data = DB::table('garages')->join('users', 'garages.users_id', '=', 'users.id')->select('garages.*', 'users.email', 'users.name', 'users.status', 'users.id as users_id')->paginate(10);

        return view('admin.garages', ['data' => $data]);
    }

    public function addGarages(GaragesRequest $request)
    {
        $input = $request->all();

        $garage = new Garages();
        $users = new User();

        $garage->name_garage = $input['name_garage'];
        $garage->phone = $input['phone'];
        $garage->address = $input['address'];

        $users->name = $input['name'];
        $users->email = $input['email'];
        $users->password = Hash::make($input['password']);
        $users->email_verified_at = date("Y-m-d H:i:s");
        $users->role = '2';
        $users->address = $input['address'];
        $users->phone = $input['phone'];
        $users->status = 2;

        $users->save();

        $garage->users_id = $users->id;
        $garage->save();

        return redirect('/admin/garages')->with('status', 'Hãng xe đã được thêm!');
    }

    public function editGarages(GaragesEditRequest $request)
    {
        $garage = new Garages();
        $users = new User();
        $garage->where('id', $request->id)->update(['name_garage' => $request->name_garage, 'phone' => $request->phone, 'address' => $request->address]);

        $users->where('id', $request->users_id)->update(['name' => $request->name]);

        return redirect('/admin/garages')->with('status', 'Hãng xe thay đổi thành công!');
    }

    public function deleteGarages(Request $request)
    {
        $users = User::where('id', $request->users_id)->first();
        $users->delete();

        $garage = Garages::where('id', $request->id)->first();
        $garage->delete();

        $getEmployees = DB::table('users')->where('sub_user', $request->id)->get();
        foreach ($getEmployees as $employee) {
            $employee = User::where('id', $employee->id)->first();
            $employee->delete();
        }

        return redirect('/admin/garages')->with('status', 'Hãng xe xóa thành công!');
    }

    public function statusGarages(Request $request)
    {
        if ($request->type == 'active') {
            $users = new User();
            $users->where('id', $request->id)->update(['status' => 1]);
        } else {
            $users = new User();
            $users->where('id', $request->id)->update(['status' => 2]);
        }

        return redirect('/admin/garages')->with('status', 'Hãng xe thay đổi trạng thái thành công!');
    }
}
