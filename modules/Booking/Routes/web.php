<?php
use Illuminate\Support\Facades\Route;
// Booking
Route::group(['prefix'=>config('booking.booking_route_prefix')],function(){
    Route::post('/addToCart','BookingController@addToCart')->middleware('auth');
    Route::post('/doCheckout','BookingController@doCheckout')->middleware('auth');
    Route::get('/confirm/{gateway}','BookingController@confirmPayment');
    Route::get('/cancel/{gateway}','BookingController@cancelPayment');
    Route::get('/{code}','BookingController@detail')->middleware('auth');
    Route::get('/{code}/checkout','BookingController@checkout')->middleware('auth');
    Route::get('/{code}/check-status','BookingController@checkStatusCheckout')->middleware('auth');

//    ical
	Route::get('/export-ical/{type}/{id}','BookingController@exportIcal')->name('booking.admin.export-ical');
});
