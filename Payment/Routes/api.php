<?php


use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\Api\PaymentApiController;

Route::group(['middleware' =>'auth:api', 'prefix' => '/payments/', 'as' => 'payments.'], function () {
    Route::post('request/', [PaymentApiController::class, 'request'])->name('request');
    Route::get('callback/', [PaymentApiController::class, 'callback'])->name('callback');
});
