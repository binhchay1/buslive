<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GaragesController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\TestController;
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

Route::get('/testapi', [TestController::class, 'create']);
Route::post('/return-vnpay', [TestController::class, 'return']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    if (Auth::user()->role) {
        return redirect('admin/dashboard');
    } else {
        return view('pages/welcome');
    }
})->name('dashboard');

Route::get('/error/permission', [ErrorController::class, 'viewErrorPermission']);

Route::group(['middleware' => ['auth:sanctum', 'verified', 'permission.manager']], function () {
    Route::group(['prefix' => 'admin'], function () {

        Route::get('/dashboard', [AdminController::class, 'viewDashBoard']);
        Route::get('/profile', [AdminController::class, 'viewProfile']);
        Route::post('/avatar', [AdminController::class, 'uploadAvatar']);
        Route::post('/change/password', [AdminController::class, 'changePassword']);

        Route::group(['prefix' => 'employee'], function () {
            Route::get('/', [EmployeeController::class, 'viewEmployee']);
            Route::post('/add', [EmployeeController::class, 'addEmployee']);
            Route::post('/edit', [EmployeeController::class, 'editEmployee']);
            Route::post('/delete', [EmployeeController::class, 'deleteEmployee']);
        });

        Route::group(['prefix' => 'garages'], function () {
            Route::get('/', [GaragesController::class, 'viewGarages']);
            Route::post('/add', [GaragesController::class, 'addGarages']);
            Route::post('/edit', [GaragesController::class, 'editGarages']);
            Route::post('/delete', [GaragesController::class, 'deleteGarages']);
        });
        
        Route::group(['prefix' => 'bus'], function () {
            Route::get('/', [BusController::class, 'viewBus']);
            Route::post('/add', [BusController::class, 'addBus']);
            Route::post('/edit', [BusController::class, 'editBus']);
            Route::post('/delete', [BusController::class, 'deleteBus']);
        });    
    });
});

Route::group(['middleware' => ['permission.visiter']], function () {
    Route::get('/', [FeatureController::class, 'viewWelcome']);
    Route::get('/contact', [FeatureController::class, 'viewContact']);
    Route::post('/contact/send', [FeatureController::class, 'sendContact']);
});
