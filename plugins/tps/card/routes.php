<?php
Route::group(['prefix' => 'card-application'], function() {

    Route::get('payment-result', ['as'=>'paymentReturn','TPS\Card\Controllers\Applications@checkPayment'] );

});
