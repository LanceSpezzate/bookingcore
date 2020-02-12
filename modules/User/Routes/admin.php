<?php
use \Illuminate\Support\Facades\Route;

Route::get('/roles/getForSelect2','RoleController@getForSelect2')->name('user.admin.role.getForSelect2');

Route::group(['prefix'=>'role'],function (){
    Route::get('/verifyFields','RoleController@verifyFields')->name('user.admin.role.verifyFields');
    Route::get('/verifyFieldsStore','RoleController@verifyFieldsStore')->name('user.admin.role.verifyFieldsStore');
    Route::get('/verifyFieldsEdit/{id}','RoleController@verifyFieldsEdit')->name('user.admin.role.verifyFieldsEdit');
});

Route::group(['prefix'=>'verification'],function (){
    Route::get('/','VerificationController@index')->name('user.admin.verification.index');
    Route::get('detail/{id}','VerificationController@detail')->name('user.admin.verification.detail');
    Route::get('store/{id}','VerificationController@store')->name('user.admin.verification.store');
});
