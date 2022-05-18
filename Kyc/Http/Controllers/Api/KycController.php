<?php

namespace Modules\Kyc\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use Modules\Kyc\Http\Requests\CardInfoRequest;
use Modules\Kyc\Http\Requests\GetAddressFromPostalCodeRequest;
use Modules\Kyc\Http\Requests\GetIbanFromCardRequest;
use Modules\Kyc\Http\Requests\IbanInfoRequest;
use Modules\Kyc\Http\Requests\MatchCellphoneAndNationalCodeRequest;
use Modules\Kyc\Http\Requests\NameSimilarityRequest;
use Modules\Kyc\Services\KycServiceInterface;

class KycController extends BaseApiController
{

    public function __construct(public KycServiceInterface $kycService)
    {
    }

    public function ibanInfo(IbanInfoRequest $ibanInfoRequest): object
    {
        $info = $this->kycService->ibanInfo($ibanInfoRequest->iban);

        return $this->storeInDatabaseAndResponse($ibanInfoRequest->all(), $info);
    }

    public function cardInfo(CardInfoRequest $cardInfoRequest): object
    {
        $info = $this->kycService->cardInfo($cardInfoRequest->card_number);

        return $this->storeInDatabaseAndResponse($cardInfoRequest->all(), $info);
    }

    public function getIbanFromCardNumber(GetIbanFromCardRequest $getIbanFromCardRequest): object
    {
        $info = $this->kycService->getIbanFromCardNumber($getIbanFromCardRequest->card_number);

        return $this->storeInDatabaseAndResponse($getIbanFromCardRequest->all(), $info);
    }

    public function matchCellphoneAndNationalCode(MatchCellphoneAndNationalCodeRequest $matchCellphoneAndNationalCodeRequest): object
    {
        $info = $this->kycService->matchCellphoneAndNationalCode(
            $matchCellphoneAndNationalCodeRequest->cellphone,
            $matchCellphoneAndNationalCodeRequest->national_code
        );

        return $this->storeInDatabaseAndResponse($matchCellphoneAndNationalCodeRequest->all(), $info);
    }

    public function nameSimilarity(NameSimilarityRequest $nameSimilarityRequest): object
    {
        $info = $this->kycService->nameSimilarity(
            $nameSimilarityRequest->national_code,
            $nameSimilarityRequest->birth_day,
            $nameSimilarityRequest->full_name,
            $nameSimilarityRequest->first_name,
            $nameSimilarityRequest->last_name,
            $nameSimilarityRequest->father_name
        );

        return $this->storeInDatabaseAndResponse($nameSimilarityRequest->all(), $info);
    }

    public function getAddressFromPostalCode(GetAddressFromPostalCodeRequest $getAddressFromPostalCodeRequest): object
    {
        $info = $this->kycService->getAddressFromPostalCode($getAddressFromPostalCodeRequest->postal_code);

        return $this->storeInDatabaseAndResponse($getAddressFromPostalCodeRequest->all(), $info);
    }

    public function storeInDatabaseAndResponse($requestAll, $info): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $this->kycService->create($user->id, $requestAll, $info);

        return $this->sendResponse($info);
    }
}
