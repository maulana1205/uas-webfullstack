<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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
    if(session()->has('username'))
    {
        return redirect('/dashboard');
    }
    else
    {
        return redirect('/auth/login');
    }
});

Route::get('/auth/login', function()
{
    if(session()->has('username'))
    {
        return redirect('/dashboard');
    }
    else
    {
        return view('auth.login');
    }
});

Route::get('/dashboard', function()
{
    if(session()->has('username'))
    {
        return view('dashboard.index', [
            'sub' => "Dashboard"
        ]);
    }
    else
    {
        return redirect('/auth/login');
    }
});

Route::get('/dashboard/input_data', function()
{
    if(session()->has('username'))
    {
        return view('dashboard.input_data', [
            'sub' => "Input Data"
        ]);
    }
    else
    {
        return redirect('/auth/login');
    }
});

Route::get('/dashboard/logout', function() 
{
    Session::flush();
    return redirect('/auth/login')->with('success', "Berhasil Logout.");
});

Route::get('/donut_chart/v1', [UserController::class, "DonutChart"]);
Route::get('/donut_chart/v2', [UserController::class, "DonutChartV2"]);
Route::post('/auth/login', [AuthController::class, "LoginController"]);
Route::post('/dashboard/input_data', [UserController::class, "InputDataController"]);