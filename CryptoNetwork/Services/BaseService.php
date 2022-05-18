<?php

namespace Modules\CryptoNetwork\Services;

use Modules\HDWallet\Services\HDWalletServiceInterface;
use phpDocumentor\Reflection\ProjectFactory;

abstract class BaseService
{
    abstract public static function symbol(): string;

    /**
     * @url: https://github.com/satoshilabs/slips/blob/master/slip-0044.md
     * @return int
     */
    abstract protected function coinType(): int;

    public function generateAddress(int $account=0, int $change=0, string $addressIndex='', $addressType='private'): array
    {
        $hdWalletService = resolve(HDWalletServiceInterface::class);

        return $hdWalletService->generateAddres(
            $this->coinType(),
            $account,
            $change,
            $addressIndex,
            $addressType
        );
    }
}
