<?php
use \Illuminate\Support\Facades\Route;

Route::get('term/getForSelect2','TermController@index')->name('core.admin.term.getForSelect2');
Route::group(['prefix'=>'updater'],function (){
    Route::get('/','UpdaterController@index')->name('core.admin.updater.index');
    Route::post('/store_license','UpdaterController@storeLicense')->name('core.admin.updater.store_license');
    Route::post('/check_update','UpdaterController@checkUpdate')->name('core.admin.updater.check_update');
    Route::post('/do_update','UpdaterController@doUpdate')->name('core.admin.updater.do_update');
});


Route::group(['prefix'=>'plugins'],function (){
    Route::get('/','PluginsController@index')->name('core.admin.plugins.index');
    Route::post('/','PluginsController@bulkEdit')->name('core.admin.plugins.bulkEdit');
});