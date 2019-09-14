<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', 'HomeController@index')->name('index');
Route::get('faq', 'FaqController@index')->name('faq');

Route::namespace('User')->group(function () {
    Route::any('api/gourlCallback', 'ApiController@gourlCallback')->name('gourlCallback');
});
/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        /*
         * User Dashboard Specific
         */
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::any('deposit', 'DashboardController@deposit')->name('deposit');

        /*
         * User Account Specific
         */
        Route::get('account', 'AccountController@index')->name('account');

        /*
         * User Profile Specific
         */
        Route::patch('profile/update', 'ProfileController@update')->name('profile.update');

        /**
         * Transactions
         */
        Route::get('api/getTransactions', 'ApiController@getTransactions')->name('getTransactions');

        Route::post('api/buyCoins', 'ApiController@buyCoins')->name('buyCoins');
        Route::post('api/manualWithdraw', 'ApiController@manualWithdraw')->name('manualWithdraw');
        Route::post('api/transactionCallback', 'ApiController@transactionCallback')->name('transactionCallback');

        /**
         * Support
         */
        Route::get('contact', 'ContactController@index')->name('contact');
        Route::post('contact/send', 'ContactController@send')->name('contact.send');
    });
});
