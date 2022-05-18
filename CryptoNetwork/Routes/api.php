<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\CryptoNetwork\Http\Controllers\Api\V1\CryptoNetworkController;


Route::group(['middleware' => 'auth', 'prefix' => 'v1/crypto/', 'as' => 'v1.crypto.'], function() {
   Route::post('address/generate', [CryptoNetworkController::class, 'generateAddress'])->name('address.generate');
});
