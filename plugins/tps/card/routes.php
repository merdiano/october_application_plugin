<?php
Route::group(['prefix' => 'card-application'], function() {

    Route::get('payment-result', 'TPS\Card\Controllers\Applications@checkPayment' )->name('paymentReturn');

});
