<?php
use Illuminate\Support\Facades\Route;

Route::get('/','TourController@index')->name('tour.admin.index');

Route::match(['get'],'/create','TourController@create')->name('tour.admin.create');
Route::match(['get'],'/edit/{id}','TourController@edit')->name('tour.admin.edit');

Route::post('/store/{id}','TourController@store')->name('tour.admin.store');

Route::get('/getForSelect2','TourController@getForSelect2')->name('tour.admin.getForSelect2');
Route::post('/bulkEdit','TourController@bulkEdit')->name('tour.admin.bulkEdit');

Route::match(['get'],'/category','CategoryController@index')->name('tour.admin.category.index');
Route::match(['get'],'/category/edit/{id}','CategoryController@edit')->name('tour.admin.category.edit');
Route::post('/category/store/{id}','CategoryController@store')->name('tour.admin.category.store');

Route::match(['get'],'/attribute','AttributeController@index')->name('tour.admin.attribute.index');
Route::match(['get'],'/attribute/edit/{id}','AttributeController@edit')->name('tour.admin.attribute.edit');
Route::post('/attribute/store/{id}','AttributeController@store')->name('tour.admin.attribute.store');

Route::match(['get'],'/attribute/term_edit','AttributeController@terms')->name('tour.admin.attribute.term.index');
Route::match(['get'],'/attribute/term_edit/edit/{id}','AttributeController@term_edit')->name('tour.admin.attribute.term.edit');
Route::post('/attribute/term_store/{id}','AttributeController@term_store')->name('tour.admin.attribute.term.store');


Route::group(['prefix'=>'availability'],function(){
    Route::get('/','AvailabilityController@index')->name('tour.admin.availability.index');
    Route::get('/loadDates','AvailabilityController@loadDates')->name('tour.admin.availability.loadDates');
    Route::get('/store','AvailabilityController@store')->name('tour.admin.availability.store');
});
