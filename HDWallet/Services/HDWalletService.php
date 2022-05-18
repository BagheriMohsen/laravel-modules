<?php

namespace Modules\HDWallet\Services;


use BitWasp\Bitcoin\Key\Deterministic\HierarchicalKeyFactory;
use Elliptic\EC;
use InvalidArgumentException;
use kornrunner\Keccak;

class HDWalletService implements HDWalletServiceInterface
{
    protected EC $secp256k1;

    protected string $sha3NullHash;

    protected string $hdWalletPrivate;

    public function __construct(public HierarchicalKeyFactory $hierarchicalKeyFactory)
    {
        $this->secp256k1 = new EC('secp256k1');
        $this->sha3NullHash = config('HDWallet.sha3_null_hash');
        $this->hdWalletPrivate = config('HDWallet.hd_wallet_private');
    }

    public function generateAddress(int $coinType, int|string $account=0, $change=0, $index='', string $addressType='public'): array
    {
        $masterExtend = $this->hierarchicalKeyFactory->fromExtended($this->hdWalletPrivate);

        /**
         *  path => purpose/coin-type/account/change/address-index
         *  purpose => 44 // hd wallet
         *  coin type => https://github.com/satoshilabs/slips/blob/master/slip-0044.md
         *  account => you can create multi account
         *  change => internal is 0 and external is 1
         *  address index => you can set everything
         **/
        $path = sprintf("%s/%s/%s/%s/%s", 44, $coinType, $account, $change, $index);
        $hierarchicalKey = $masterExtend->derivePath($path);
        $publicKey = $this->getPublicKey($hierarchicalKey->getPrivateKey()->getHex());

        if ($addressType == 'private') {
            return [
                'address' => $this->getAddress($publicKey),
                'private' => $hierarchicalKey->getPrivateKey()->getHex(),
                'public' => $hierarchicalKey->getPublicKey()->getHex(),
            ];
        }

        return [
            'address' => $this->getAddress($publicKey)
        ];
    }

    protected function getPublicKey(string $privateKey): string
    {
        if ($this->isHex($privateKey) === false) {
            throw new InvalidArgumentException('Invalid private key format.');
        }
        $privateKey = $this->stripZero($privateKey);

        if (strlen($privateKey) !== 64) {
            throw new InvalidArgumentException('Invalid private key length.');
        }
        $privateKey = $this->secp256k1->keyFromPrivate($privateKey, 'hex');
        $publicKey = $privateKey->getPublic(false, 'hex');

        return '0x' . $publicKey;
    }

    protected function getAddress(string $publicKey): string
    {
        if ($this->isHex($publicKey) === false) {
            throw new InvalidArgumentException('Invalid public key format.');
        }
        $publicKey = $this->stripZero($publicKey);

        if (strlen($publicKey) !== 130) {
            throw new InvalidArgumentException('Invalid public key length.');
        }
        return '0x' . substr($this->sha3(substr(hex2bin($publicKey), 1)), 24);
    }

    protected function isHex(string $value): bool
    {
        return (preg_match('/^(0x)?[a-fA-F0-9]+$/', $value) === 1);
    }

    protected function stripZero(string $value): array|string
    {
        if (str_starts_with($value, '0x')) {
            $count = 1;
            return str_replace('0x', '', $value, $count);
        }
        return $value;
    }

    protected function sha3(string $value): ?string
    {
        $hash = Keccak::hash($value, 256);

        if ($hash === $this->sha3NullHash) {
            return null;
        }

        return $hash;
    }

}
