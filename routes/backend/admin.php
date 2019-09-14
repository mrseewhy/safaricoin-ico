<?php

/**
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::get('transactions', 'TransactionsController@index')->name('transactions');
Route::post('transactions/search', 'TransactionsController@search')->name('transactions.search');
Route::get('transactions/{id}', 'TransactionsController@info')->name('transactions.info');
Route::get('support', 'SupportController@index')->name('support');
Route::post('support/search', 'SupportController@search')->name('support.search');
Route::get('withdraw', 'WithdrawController@index')->name('withdraw');
Route::post('withdraw/search', 'WithdrawController@search')->name('withdraw.search');
Route::post('withdraw/status', 'WithdrawController@setStatus')->name('withdraw.status');
Route::get('offerings', 'OfferingsController@index')->name('offerings');
Route::post('offerings/search', 'OfferingsController@search')->name('offerings.search');
Route::any('offerings/edit/{id?}', 'OfferingsController@edit')->name('offerings.edit');
Route::post('offerings/delete', 'OfferingsController@delete')->name('offerings.delete');