<?php

namespace Modules\Payment\Services\PaymentGateway;

use Modules\Payment\Entities\Payment;

interface PaymentGatewayInterface
{
    public function request(Payment $payment): array;

    public function callbackProcess(array $data): array;

    public function verify(array $data): void;

    public function detail($trackingCode): void;

    public function cardIsValid($userSelectedCard, $card): bool;
}
