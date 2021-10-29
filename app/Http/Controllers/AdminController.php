<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function viewDashBoard()
    {
        return view('admin.dashboard');
    }

    public function viewProfile()
    {
        return view('admin.profile');
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
}
