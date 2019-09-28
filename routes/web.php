<?php

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
    return redirect()->route('home');
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/staff-amount', 'StaffController@totalAmount')->name('staff-amount');
    //Route::match(['get','post'], '/salary', 'SalaryController@index')->name('salary');
	//Route::post('/salary', 'SalaryController@store')->name('salary-add');
	//Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::resource('bus', 'BusController');
    Route::resource('staff', 'StaffController');
    Route::resource('salary', 'SalaryController');
    Route::resource('expense', 'ExpenseController');
    Route::resource('work', 'WorkController');
});

