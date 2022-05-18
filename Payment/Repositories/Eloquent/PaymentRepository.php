<?php

namespace Modules\Payment\Repositories\Eloquent;

use Modules\Payment\Entities\Payment;
use Modules\Payment\Repositories\PaymentRepositoryInterface;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{

    public function getFieldsSearchable(): array
    {
        return [];
    }

    public function model(): string
    {
        return Payment::class;
    }
}
