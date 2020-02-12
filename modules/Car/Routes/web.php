<?php
use \Illuminate\Support\Facades\Route;

Route::group(['prefix'=>config('car.car_route_prefix')],function(){
    Route::get('/','CarController@index')->name('car.search'); // Search
    Route::get('/{slug}','CarController@detail')->name('car.detail');// Detail
});


Route::group(['prefix'=>'user/'.config('car.car_route_prefix')],function(){

    Route::match(['get','post'],'/','ManageCarController@manageCar')->name('car.vendor.index');
    Route::match(['get','post'],'/create','ManageCarController@createCar')->name('car.vendor.create');
    Route::match(['get','post'],'/edit/{slug}','ManageCarController@editCar')->name('car.vendor.edit');
    Route::match(['get','post'],'/del/{slug}','ManageCarController@deleteCar')->name('car.vendor.delete');
    Route::match(['post'],'/store/{slug}','ManageCarController@store')->name('car.vendor.store');
    Route::get('bulkEdit/{id}','ManageCarController@bulkEditCar')->name("car.vendor.bulk_edit");
    Route::get('/booking-report','ManageCarController@bookingReport')->name("car.vendor.booking_report");
    Route::get('/booking-report/bulkEdit/{id}','ManageCarController@bookingReportBulkEdit')->name("car.vendor.booking_report.bulk_edit");

    Route::group(['prefix'=>'availability'],function(){
        Route::get('/','AvailabilityController@index')->name('car.vendor.availability.index');
        Route::get('/loadDates','AvailabilityController@loadDates')->name('car.vendor.availability.loadDates');
        Route::match(['get','post'],'/store','AvailabilityController@store')->name('car.vendor.availability.store');
    });
});