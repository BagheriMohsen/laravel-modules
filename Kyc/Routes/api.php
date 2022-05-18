<?php


use Illuminate\Support\Facades\Route;
use Modules\Kyc\Http\Controllers\Api\KycController;

Route::group(['middleware' => 'auth:api', 'prefix' => '/kyc/', 'as' => 'kyc.'], function () {

    Route::group(['prefix' => 'info/', 'as' => 'info.'], function () {
        Route::post('iban/', [KycController::class, 'ibanInfo']);
        Route::post('card/', [KycController::class, 'cardInfo']);
    });

    Route::group(['prefix' => 'find/', 'as' => 'find.'], function () {
        Route::post('iban/', [KycController::class, 'getIbanFromCardNumber']);
        Route::post('address/', [KycController::class, 'getAddressFromPostalCode']);
    });

    Route::post('match', [KycController::class, 'matchMobileNumberAndNationalCode']);
    Route::post('find/iban', [KycController::class, 'nameSimilarity']);

});
