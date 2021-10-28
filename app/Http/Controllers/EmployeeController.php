<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    public function viewEmployee() {
        $data['employee'] = DB::table('users')->join('garages', 'users.garages_id', '=', 'garages.id')->paginate(15);
        $data['garages'] = DB::table('garages')->get();

        return view('admin.employee', ['data' => $data]);
    }

    public function addEmployee(EmployeeRequest $request) {
        $input = $request->all();

        $users = new User();

        $users->name = $input['name'];
        $users->email = $input['email'];
        $users->password = Hash::make($input['password']);
        $users->role = $input['role'];
        $users->garages_id = $input['garages'];

        $users->save();

        return redirect('/admin/employee')->with('status', 'Employee added!');
    }
}
