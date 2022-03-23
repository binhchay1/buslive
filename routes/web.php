<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GaragesController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\RoadsController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\TripsController;
use App\Http\Controllers\VNPAYController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ContactController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    if (Auth::user()->role) {
        if(Auth::user()->role <= 2) {
            if(Auth::user()->role == 1) {
                return redirect('admin/garages');
            } else {
                return redirect('admin/dashboard');
            }
        }
        return redirect('admin/trips');
        
    } else {
        return redirect('/');
    }
})->name('dashboard');

Route::get('/error/permission', [ErrorController::class, 'viewErrorPermission']);
Route::get('/error/status', [ErrorController::class, 'viewErrorStatus']);

Route::group(['middleware' => ['auth:sanctum', 'verified', 'permission.manager']], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['middleware' => 'permission.subrole'], function () {
            Route::get('/dashboard', [AdminController::class, 'viewDashBoard']);
        });
      
        Route::get('/profile', [AdminController::class, 'viewProfile']);
        Route::post('/avatar', [AdminController::class, 'uploadAvatar']);
        Route::post('/change/password', [AdminController::class, 'changePassword']);
        Route::get('/getanalystorder', [AdminController::class, 'getAnalystOrder']);
        Route::get('/getdatatrips', [AdminController::class, 'getDataTrips']);
        Route::get('/getdatastation', [AdminController::class, 'getDataStation']);
        Route::get('/getinformationtrips', [AdminController::class, 'getInformationTrips']);
        Route::get('/canceltrips', [AdminController::class, 'cancelTrips']);
        Route::get('/savenote', [AdminController::class, 'saveNote']);
        Route::post('/repick', [AdminController::class, 'rePick']);
        Route::get('/mapshare', [AdminController::class, 'viewMapShare']);
        Route::get('/checkdeletestation', [AdminController::class, 'checkDeleteStation']);
        Route::get('/checkdeleteemployee', [AdminController::class, 'checkDeleteEmployee']);
        Route::get('/checkdeletebus', [AdminController::class, 'checkDeleteBus']);
        Route::get('/checkdeleteroads', [AdminController::class, 'checkDeleteRoads']);
        Route::get('/saveestimate', [AdminController::class, 'saveEstimate']);
        Route::get('/savenewcustomer', [AdminController::class, 'saveNewCustomer']);
        Route::get('/getdataanalysis', [AdminController::class, 'getDataAnalysis']);

        Route::group(['prefix' => 'employee', 'middleware' => 'permission.subrole'], function () {
            Route::get('/', [EmployeeController::class, 'viewEmployee']);
            Route::post('/add', [EmployeeController::class, 'addEmployee']);
            Route::post('/edit', [EmployeeController::class, 'editEmployee']);
            Route::post('/delete', [EmployeeController::class, 'deleteEmployee']);
        });

        Route::group(['prefix' => 'garages', 'middleware' => 'permission.admin'], function () {
            Route::get('/', [GaragesController::class, 'viewGarages']);
            Route::post('/add', [GaragesController::class, 'addGarages']);
            Route::post('/edit', [GaragesController::class, 'editGarages']);
            Route::post('/delete', [GaragesController::class, 'deleteGarages']);
            Route::post('/status', [GaragesController::class, 'statusGarages']);
        });

        Route::group(['prefix' => 'roads', 'middleware' => 'permission.subrole'], function () {
            Route::get('/', [RoadsController::class, 'viewRoads']);
            Route::post('/add', [RoadsController::class, 'addRoads']);
            Route::post('/edit', [RoadsController::class, 'editRoads']);
            Route::post('/delete', [RoadsController::class, 'deleteRoads']);
        });

        Route::group(['prefix' => 'bus', 'middleware' => 'permission.subrole'], function () {
            Route::get('/', [BusController::class, 'viewBus']);
            Route::post('/add', [BusController::class, 'addBus']);
            Route::post('/edit', [BusController::class, 'editBus']);
            Route::post('/delete', [BusController::class, 'deleteBus']);
        });

        Route::group(['prefix' => 'station', 'middleware' => 'permission.subrole'], function () {
            Route::get('/', [StationController::class, 'viewStation']);
            Route::post('/add', [StationController::class, 'addStation']);
            Route::post('/edit', [StationController::class, 'editStation']);
            Route::post('/delete', [StationController::class, 'deleteStation']);
        });

        Route::group(['prefix' => 'partner'], function () {
            Route::get('/', [PartnerController::class, 'viewPartner']);
        });

        Route::group(['prefix' => 'contact'], function () {
            Route::get('/', [ContactController::class, 'viewContact']);
        });
        
        Route::group(['prefix' => 'trips','middleware' => 'permission.non.admin'], function () {
            Route::get('/', [TripsController::class, 'viewTrips']);
            Route::post('/add', [TripsController::class, 'addTrips']);
        });
    });
});

Route::group(['middleware' => ['permission.visiter']], function () {
    Route::get('/', [FeatureController::class, 'viewWelcome']);
    Route::get('/contact', [FeatureController::class, 'viewContact']);
    Route::post('/contact/send', [FeatureController::class, 'sendContact']);
    Route::get('/ticket', [FeatureController::class, 'bookTicket']);
    Route::get('/gettime', [FeatureController::class, 'getTime']);
    Route::get('/print-ticket', [FeatureController::class, 'printTicket']);
    Route::get('/profile', [FeatureController::class, 'viewProfile']);
    Route::get('/history', [FeatureController::class, 'viewHistory']);
    Route::post('/change-password', [FeatureController::class, 'changePassword']);
    Route::post('/update-profile', [FeatureController::class, 'updateProfile']);
    Route::post('/createPay', [VNPAYController::class, 'createPay']);
    Route::post('/payment-process', [VNPAYController::class, 'paymentProcess']);
    Route::get('/payment-return', [VNPAYController::class, 'paymentReturn']);
    Route::get('/payment-fail', [VNPAYController::class, 'paymentFail']);
    Route::get('/rentcar', [FeatureController::class, 'viewRentCar']);
    Route::get('/partner', [FeatureController::class, 'viewPartner']);
    Route::post('/partner/send', [FeatureController::class, 'sendPartner']);
    Route::post('/sendmailonly', [FeatureController::class, 'viewPartner']);
});
