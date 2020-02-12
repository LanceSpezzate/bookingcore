<?php
use Illuminate\Support\Facades\Route;

Route::match(['get'],'translations/loadTranslateJson','TranslationsController@loadTranslateJson')->name('language.admin.loadTranslateJson');