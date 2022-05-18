<?php

namespace Modules\Kyc\Services;

use Illuminate\Support\Facades\Http;
use Modules\Kyc\Repositories\KycRepositoryInterface;

class JibitService extends BaseService implements KycServiceInterface
{

    private string $apiKey;

    private string $secretKey;

    private string $baseUrl;

    private string $token;

    private int $cacheExpireTime = ((60 * 60) * 20);

    const CACHE_ACCESS_TOKEN_KEY = 'JIBIT_ACCESS_TOKEN';

    const CACHE_REFRESH_TOKEN_KEY = 'JIBIT_REFRESH_TOKEN';

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __construct(public KycRepositoryInterface $kycRepository)
    {
        $this->apiKey = config('app.jibit.apiKey');
        $this->secretKey = config('app.jibit.secret');
        $this->baseUrl = config('app.jibit.base_url');
        $this->setToken();

    }

    public function create($userId, $sentData, $receiveData): \Illuminate\Database\Eloquent\Model
    {
        return $this->kycRepository->create([
            'user_id' => $userId,
            'sent_data' => json_encode($sentData),
            'receive_data' => json_encode($receiveData)
        ]);
    }

    /**
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    private function setToken(): void
    {
        $accessToken = cache()->get(self::CACHE_ACCESS_TOKEN_KEY);
        $refreshToken = cache()->get(self::CACHE_REFRESH_TOKEN_KEY);

        if (!is_null($accessToken) && !is_null($refreshToken)) {
            return;
        }

        $this->token = cache()->remember(self::CACHE_ACCESS_TOKEN_KEY, $this->cacheExpireTime, function () {
            $response = Http::post($this->baseUrl . '/tokens/generate', [
                "apiKey" => $this->apiKey,
                "secretKey" => $this->secretKey
            ]);

            $response = (object)json_decode($response);

            return $response->accessToken;
        });

    }

    public function ibanInfo($iban): object
    {
        $response = Http::withToken($this->token)->post($this->baseUrl . '/services/ibanInfo', [
            'iban' => $iban,
        ]);

        return (object)json_decode($response);
    }

    public function cardInfo($cardNumber): object
    {
        $response = Http::withToken($this->token)->post($this->baseUrl . '/services/cardInfo', [
            'cardNumber' => $cardNumber,
        ]);
        $response = (object)json_decode($response);
        $response->ownerName = $this->convertFullNameToValidFormat($response->ownerName);

        return $response;
    }

    public function getIbanFromCardNumber($card_number): object
    {
        $response = Http::withToken($this->token)->get($this->baseUrl . '/cards?number=' . $card_number . '&iban=true');

        return (object)json_decode($response);
    }

    public function matchCellphoneAndNationalCode($mobileNumber, $nationalCode): object
    {
        $response = Http::withToken($this->token)->post($this->baseUrl . '/services/matchNationalCodeAndMobileNumber', [
            'mobile' => $mobileNumber,
            'nationalCode' => $nationalCode,
        ]);

        return (object)json_decode($response);
    }

    public function nameSimilarity($nationalCode, $birthDate, $fullName, $firstName, $lastName, $fatherName): object
    {
        $response = Http::withToken($this->token)->get($this->baseUrl . '/services/identity/similarity', [
            'nationalCode' => $nationalCode,
            'birthDate' => $birthDate,
            'fullName' => $fullName,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'fatherName' => $fatherName
        ]);

        return (object)json_decode($response);
    }

    public function getAddressFromPostalCode($postalCode): object
    {
        $response = Http::withToken($this->token)->post($this->baseUrl . '/services/postalCodeToAddress', [
            'postalCode' => $postalCode,
        ]);
        $response = json_decode($response);

        return (object)$response;
    }

    public function nameSimilarityAverage($jibitResponse): bool
    {
        $jibitPercent = config('app.jibit_percent');

        return isset(
            $jibitResponse->fullNameSimilarityPercentage) &&
            (
                $jibitResponse->fullNameSimilarityPercentage >= $jibitPercent &&
                $jibitResponse->firstNameSimilarityPercentage >= $jibitPercent &&
                $jibitResponse->lastNameSimilarityPercentage >= $jibitPercent &&
                $jibitResponse->fatherNameSimilarityPercentage >= $jibitPercent
            );
    }

}
