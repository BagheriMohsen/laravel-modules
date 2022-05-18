<?php

namespace Modules\Payment\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Payment\Services\PaymentGateway\PaymentGatewayInterface;

class PaymentDetailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public $trackingCode)
    {
    }

    public function handle()
    {
        $paymentGatewayService = resolve(PaymentGatewayInterface::class);
        $paymentGatewayService->detail($this->trackingCode);
    }
}
