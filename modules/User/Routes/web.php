<?php

	use Illuminate\Support\Facades\Auth;
	use \Illuminate\Support\Facades\Route;
	Auth::routes(['verify' => true]);
Route::group(['prefix'=>'user','middleware' => ['verified']],function(){
    Route::match(['get','post'],'/dashboard','UserController@dashboard')->name("vendor.dashboard");
    Route::post('/reloadChart','UserController@reloadChart');

    Route::match(['get','post'],'/profile','UserController@profile')->name("user.profile.index");
    Route::match(['get','post'],'/profile/change-password','UserController@changePassword')->name("user.change_password");
    Route::get('/booking-history','UserController@bookingHistory')->name("vendor.booking_history");

    Route::post('/wishlist','UserWishListController@handleWishList')->name("user.wishList.handle");
    Route::get('/wishlist','UserWishListController@index')->name("user.wishList.index");
    Route::get('/wishlist/remove','UserWishListController@remove')->name("user.wishList.remove");

    Route::group(['prefix'=>'verification'],function(){
        Route::match(['get'],'/','VerificationController@index')->name("user.verification.index");
        Route::match(['get'],'/update','VerificationController@update')->name("user.verification.update");
        Route::post('/store','VerificationController@store')->name("user.verification.store");
    });

});

Route::group(['prefix'=>'profile'],function(){
    Route::match(['get'],'/{id}','ProfileController@profile')->name("user.profile");
    Route::match(['get'],'/{id}/reviews','ProfileController@allReviews')->name("user.profile.reviews");
    Route::match(['get'],'/{id}/services','ProfileController@allServices')->name("user.profile.services");
});

//Newsletter
Route::post('newsletter/subscribe','UserController@subscribe')->name('newsletter.subscribe');
