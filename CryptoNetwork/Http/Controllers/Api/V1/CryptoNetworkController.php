<?php

namespace Modules\CryptoNetwork\Http\Controllers\Api\V1;


use Illuminate\Routing\Controller;
use Modules\CryptoNetwork\Http\Requests\Api\V1\AssignAddressToUserRequest;
use Modules\CryptoNetwork\Services\CryptoNetworkServiceInterface;

class CryptoNetworkController extends Controller
{
    public CryptoNetworkServiceInterface $cryptoNetworkService;

    public function __construct()
    {
    }

    public function assignAddressToUser(AssignAddressToUserRequest $assignAddressToUserRequest)
    {
        $this->cryptoNetworkService = resolve(CryptoNetworkServiceInterface::class);

    }
}
