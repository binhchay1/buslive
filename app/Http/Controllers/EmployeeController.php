<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeEditRequest;
use App\Models\User;

class EmployeeController extends Controller
{
    public function viewEmployee()
    {
        $data = DB::table('users')->where('sub_user', Auth::user()->id)->where('status_delete', true)->paginate(10);

        return view('admin.employee', ['data' => $data]);
    }

    public function addEmployee(EmployeeRequest $request)
    {
        $input = $request->all();

        $users = new User();
        $dob = $input['year'] . '-' . $input['month'] . '-' . $input['day'];

        $users->name = $input['name'];
        $users->email = $input['email'];
        $users->password = Hash::make($input['password']);
        $users->email_verified_at = date("Y-m-d H:i:s");
        $users->role = '3';
        $users->sub_user = Auth::user()->id;
        $users->address = $input['address'];
        $users->phone = $input['phone'];
        $users->gender = $input['gender'];
        $users->sub_role = $input['sub_role'];
        $users->dob = $dob;

        $users->save();

        return redirect('/admin/employee')->with('status', 'Nhân viên đã được thêm!');
    }

    public function editEmployee(EmployeeEditRequest $request)
    {
        $users = new User();
        $dob = $request->year . '-' . $request->month . '-' . $request->day;
        $users->where('id', $request->id)->update(['name' => $request->name, 'phone' => $request->phone, 'gender' => $request->gender, 'address' => $request->address, 'dob' => $dob, 'sub_role' => $request->sub_role]);

        return redirect('/admin/employee')->with('status', 'Thông tin nhân viên đổi thành công!');
    }

    public function deleteEmployee(Request $request)
    {
        $users = User::where('id', $request->id)->first();
        $users->update(['email' => NULL, 'status_delete' => false]);

        return redirect('/admin/employee')->with('status', 'Nhân viên xóa thành công!');
    }
}
