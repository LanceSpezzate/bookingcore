<?php
use \Illuminate\Support\Facades\Route;

Route::group(['prefix'=>config('space.space_route_prefix')],function(){
    Route::get('/','SpaceController@index')->name('space.search'); // Search
    Route::get('/{slug}','SpaceController@detail')->name('space.detail');// Detail
});


Route::group(['prefix'=>'user/'.config('space.space_route_prefix')],function(){

    Route::match(['get','post'],'/','ManageSpaceController@manageSpace')->name('space.vendor.index');
    Route::match(['get','post'],'/create','ManageSpaceController@createSpace')->name('space.vendor.create');
    Route::match(['get','post'],'/edit/{slug}','ManageSpaceController@editSpace')->name('space.vendor.edit');
    Route::match(['get','post'],'/del/{slug}','ManageSpaceController@deleteSpace')->name('space.vendor.delete');
    Route::match(['post'],'/store/{slug}','ManageSpaceController@store')->name('space.vendor.store');
    Route::get('bulkEdit/{id}','ManageSpaceController@bulkEditSpace')->name("space.vendor.bulk_edit");
    Route::get('/booking-report','ManageSpaceController@bookingReport')->name("space.vendor.booking_report");
    Route::get('/booking-report/bulkEdit/{id}','ManageSpaceController@bookingReportBulkEdit')->name("space.vendor.booking_report.bulk_edit");
	Route::get('clone/{id}','ManageSpaceController@cloneSpace')->name("space.vendor.clone");


	Route::group(['prefix'=>'availability'],function(){
        Route::get('/','AvailabilityController@index')->name('space.vendor.availability.index');
        Route::get('/loadDates','AvailabilityController@loadDates')->name('space.vendor.availability.loadDates');
        Route::match(['get','post'],'/store','AvailabilityController@store')->name('space.vendor.availability.store');
    });
});