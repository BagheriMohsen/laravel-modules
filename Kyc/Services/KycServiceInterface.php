<?php

namespace Modules\Kyc\Services;


interface KycServiceInterface
{
    public function ibanInfo($iban): object;

    public function cardInfo($cardNumber): object;

    public function getIbanFromCardNumber($card_number): object;

    public function matchCellphoneAndNationalCode($mobileNumber, $nationalCode): object;

    public function nameSimilarity($nationalCode, $birthDate, $fullName, $firstName, $lastName, $fatherName): object;

    public function getAddressFromPostalCode($postalCode): object;

    public function nameSimilarityAverage($jibitResponse): bool;
}
