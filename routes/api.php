<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\RegisterUserController;
use App\Http\Controllers\admin\AdminEmployeeController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Esp\EspController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'admin'], function () {
    Route::post('registerUser', [RegisterUserController::class, 'registerUser']);
    Route::post('addEsp', [AdminController::class, 'addEsp']);
    Route::post('searchUserByEmail', [AdminController::class, 'searchUserByEmail']);
    Route::post('searchESPById', [AdminController::class, 'searchESPById']);
    Route::post('addESPtoHome', [AdminController::class, 'addESPtoHome']);
    Route::post('addEmployee', [AdminEmployeeController::class, 'addEmployee']);
    Route::post('addTask', [AdminEmployeeController::class, 'addTask']);

});
Route::group(['prefix' => 'users'], function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('rooms', [UserController::class, 'getUserRooms']);
    Route::post('devices', [UserController::class, 'getDeviceRooms']);
    Route::post('updateDeviceState', [UserController::class, 'updateDeviceState']);
    Route::post('addSecondaryUser', [UserController::class, 'addSecondaryUser']);
    Route::post('addSecondaryRoom', [UserController::class, 'addSecondaryRoom']);
    Route::post('getUserDetails', [UserController::class, 'getUserDetails']);

});


Route::group(['prefix' => 'employee'], function () {
    Route::post('login', [EmployeeController::class, 'login']);
    Route::post('getEmployeeTasks', [EmployeeController::class, 'getEmployeeTasks']);
    Route::post('addRoom', [EmployeeController::class, 'addRoom']);
    Route::post('getUserIdEsp', [EmployeeController::class, 'getUserIdEsp']);
    Route::post('getAvailablePinsInput', [EmployeeController::class, 'getAvailablePinsInput']);
    Route::post('getAvailablePinsOutPut', [EmployeeController::class, 'getAvailablePinsOutPut']);
    Route::post('getUserRooms', [EmployeeController::class, 'getUserRooms']);
    Route::post('addDevice', [EmployeeController::class, 'addDevice']);



});


Route::group(['prefix' => 'Esp'], function () {
    Route::post('espDevices', [EspController::class, 'getDevicesByEspId']);
    Route::post('updateDeviceState', [EspController::class, 'updateDeviceState']);
    Route::post('getEspHomeId', [EspController::class, 'getEspHomeId']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
