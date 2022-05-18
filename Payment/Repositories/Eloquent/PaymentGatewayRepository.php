<?php

namespace Modules\Payment\Repositories\Eloquent;

use Modules\Payment\Entities\PaymentGateway;
use Modules\Payment\Repositories\PaymentGatewayRepositoryInterface;

class PaymentGatewayRepository extends BaseRepository implements PaymentGatewayRepositoryInterface
{

    public function getFieldsSearchable(): array
    {
        return [];
    }

    public function model(): string
    {
        return PaymentGateway::class;
    }
}
