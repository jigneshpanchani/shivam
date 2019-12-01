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

if(time() < env('ACTIVATION_KEY')){

    Route::get('/', function () {
        return redirect()->route('home');
        return view('auth.login');
    });

    Auth::routes();

    Route::group(['middleware' => ['auth']], function () {

        Route::get('/home', 'HomeController@index')->name('home');
        Route::post('/staff-amount', 'StaffController@totalAmount')->name('staff-amount');
        //Route::match(['get','post'], '/report', 'ReportController@index')->name('report');
        Route::get('/history', 'HistoryController@index')->name('history');
        Route::post('/remove-history', 'HistoryController@remove')->name('remove-history');
        Route::get('/report', 'ReportController@index')->name('report');
        Route::post('/report-generate', 'ReportController@generate')->name('report-generate');
        Route::post('/partner-buses', 'AccountController@getBusList')->name('partner-buses');


        Route::resource('bus', 'BusController');
        Route::resource('staff', 'StaffController');
        Route::resource('salary', 'SalaryController');
        Route::resource('expense', 'ExpenseController');
        Route::resource('work', 'WorkController');
        Route::resource('partner', 'PartnerController');
        Route::resource('company', 'CompanyController');
        Route::resource('account', 'AccountController');
    });

}else{
    abort('404');
}
