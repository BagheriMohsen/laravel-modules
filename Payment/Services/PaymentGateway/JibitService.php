<?php

namespace Modules\Payment\Services\PaymentGateway;

use Modules\Payment\Repositories\PaymentRepositoryInterface;

class JibitService extends BaseService implements PaymentGatewayInterface
{
    public function __construct(public PaymentRepositoryInterface $paymentRepository)
    {
        parent::__construct($this->paymentRepository);
    }

    public function request($payment): array
    {
        // TODO: Implement request() method.
    }

    public function callbackProcess(array $data): array
    {
        // TODO: Implement callbackProcess() method.
    }

    public function verify($data): void
    {
        // TODO: Implement verify() method.
    }

    public function detail($trackingCode): void
    {
        // TODO: Implement detail() method.
    }

}
