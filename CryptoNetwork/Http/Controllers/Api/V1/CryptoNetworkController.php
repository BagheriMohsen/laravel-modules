<?php

namespace Modules\CryptoNetwork\Http\Controllers\Api\V1;


use Illuminate\Routing\Controller;
use Modules\CryptoNetwork\Http\Requests\Api\V1\AssignAddressToUserRequest;
use Modules\CryptoNetwork\Repositories\CryptoNetworkAddressRepositoryInterface;
use Modules\CryptoNetwork\Services\CryptoNetworkServiceInterface;
use Modules\Currency\Repositories\CurrencyRepositoryInterface;

class CryptoNetworkController extends Controller
{
    public CryptoNetworkServiceInterface $cryptoNetworkService;

    public function __construct(public CurrencyRepositoryInterface $currencyRepository,
                                public CryptoNetworkAddressRepositoryInterface $cryptoNetworkAddressRepository)
    {
    }

    public function generateAddress(AssignAddressToUserRequest $assignAddressToUserRequest): \Illuminate\Http\JsonResponse
    {
        $user = auth('api')->user();
        $currencyName = $assignAddressToUserRequest->get('currency_name');
        $currency = $this->currencyRepository->firstOrFail('name', $currencyName);
        $this->cryptoNetworkService = resolve(CryptoNetworkServiceInterface::class, []);
        $address = $this->cryptoNetworkService->generateAddress();
        $this->cryptoNetworkAddressRepository->create([
            'user_id' => $user->id,
            'currency_id' => $currency->id,
            'network' => $assignAddressToUserRequest->network,
            'address' => $address['address'],
            'public_key' => $address['public_key'],
            'private_key' => $address['private_key']
        ]);

        return jsonResponse(message: __('Address successfully generated!'), data: [
            'address' => $address['address']
        ]);

    }
}
