<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>config('news.news_route_prefix')],function(){
    Route::get('/'.config('news.news_category_route_prefix').'/{slug}', 'CategoryNewsController@index');
    Route::get('/'.config('news.news_tag_route_prefix').'/{slug}', 'TagNewsController@index');
    Route::get('/','NewsController@index')->name('news.index');// News Page
    Route::get('/{slug}','NewsController@detail')->name('news.detail');// Detail
});