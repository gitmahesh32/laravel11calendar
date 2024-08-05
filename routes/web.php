<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HolidayController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/holiday-list',[HolidayController::class, 'list'])->name('holiday-list');
Route::get('/calendar',[HolidayController::class, 'calendarList'])->name('calendar');
Route::post('/createvent',[HolidayController::class, 'creatEvent'])->name('creatEvent');
Route::post('/deleteholiday',[HolidayController::class, 'deleteHoliday'])->name('deleteholiday');

Route::get('/showholidaydetail/{id}',[HolidayController::class, 'showHolidayDetail'])->name('showholidaydetail');




