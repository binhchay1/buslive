<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    if (Auth::user()->role) {
        return redirect('admin/dashboard');
    } else {
        return view('welcome');
    }
})->name('dashboard');

Route::group(['middleware' => ['auth:sanctum', 'verified', 'permission.manager']], function () {

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/dashboard', [AdminController::class, 'viewDashBoard']);
        Route::get('/employee', [AdminController::class, 'viewEmployee']);
        Route::get('/garages', [AdminController::class, 'viewGarages']);
        Route::get('/profile', [AdminController::class, 'viewProfile']);
    });
});
