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
use Illuminate\Support\Facades\Route;
// Vendor Manage Tour
Route::group(['prefix'=>'user/'.config('tour.tour_route_prefix')],function(){
    Route::match(['get',],'/','ManageTourController@manageTour')->name('tour.vendor.index');
    Route::match(['get',],'/create','ManageTourController@createTour')->name('tour.vendor.create');
    Route::match(['get',],'/edit/{slug}','ManageTourController@editTour')->name('tour.vendor.edit');
    Route::match(['get','post'],'/del/{slug}','ManageTourController@deleteTour')->name('tour.vendor.delete');
    Route::match(['post'],'/store/{slug}','ManageTourController@store')->name('tour.vendor.store');
    Route::get('bulkEdit/{id}','ManageTourController@bulkEditTour')->name("tour.vendor.bulk_edit");

    Route::get('clone/{id}','ManageTourController@cloneTour')->name("tour.vendor.clone");




    Route::get('/booking-report','ManageTourController@bookingReport')->name("tour.vendor.booking_report");
    Route::get('/booking-report/bulkEdit/{id}','ManageTourController@bookingReportBulkEdit')->name("tour.vendor.booking_report.bulk_edit");

    Route::group(['prefix'=>'availability'],function(){
        Route::get('/','AvailabilityController@index')->name('tour.vendor.availability.index');
        Route::get('/loadDates','AvailabilityController@loadDates')->name('tour.vendor.availability.loadDates');
        Route::match(['get','post'],'/store','AvailabilityController@store')->name('tour.vendor.availability.store');
    });
});

// Tour
Route::group(['prefix'=>config('tour.tour_route_prefix')],function(){
    Route::get('/','\Modules\Tour\Controllers\TourController@index')->name('tour.search'); // Search
    Route::get('/{slug}','\Modules\Tour\Controllers\TourController@detail');// Detail
});
