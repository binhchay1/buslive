<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordRequest;

class AdminController extends Controller
{
    public function viewDashBoard()
    {
        return view('admin.dashboard');
    }

    public function viewProfile()
    {
        $data['subuser'] = DB::table('users')->where('id', Auth::user()->subuser)->first();

        $data['garages'] = DB::table('users')->join('garages', 'users.garages_id', '=', 'garages.id')
            ->select('garages.name_garage')->first();

        return view('admin.profile', ['data' => $data]);
    }

    public function uploadAvatar(Request $request)
    {
        $path = '/uploads/profile/';
        $pathMove = 'uploads\profile';

        $imageName = 'avatar_' . time() . '._' . Auth::user()->name . '.' . $request->avatar->extension();
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $profile_photo_path = $path . '/' . $imageName;

        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['profile_photo_path' => $profile_photo_path]);

        $request->avatar->move(public_path($pathMove), $imageName);

        return redirect('/admin/profile');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        $userPassword = $user->password;

        if (!Hash::check($request->current_password, $userPassword)) {
            return back()->withErrors(['current_password' => 'Password not match']);
        }

        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->back()->with('success', 'password successfully updated');
    }
}
