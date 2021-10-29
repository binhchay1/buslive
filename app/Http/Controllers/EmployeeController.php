<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class EmployeeController extends Controller
{
    public function viewEmployee()
    {
        $data['employee'] = DB::table('users')->join('garages', 'users.garages_id', '=', 'garages.id')
            ->select('users.*', 'garages.name_garage')
            ->paginate(15);
        $data['garages'] = DB::table('garages')->get();

        return view('admin.employee', ['data' => $data]);
    }

    public function addEmployee(EmployeeRequest $request)
    {
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

    public function editEmployee(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:100',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/employee')
                ->withErrors($validator)
                ->withInput();
        }

        $users = new User();
        $users->where('id', $request->id)->update(['name' => $request->name, 'role' => $request->role, 'garages_id' => $request->garages]);

        return redirect('/admin/employee')->with('status', 'Employee edited!');
    }

    public function deleteEmployee(Request $request)
    {
        $users = User::where('id', $request->id)->first();
        $users->delete();

        return redirect('/admin/employee')->with('status', 'Employee deleted!');
    }
}
