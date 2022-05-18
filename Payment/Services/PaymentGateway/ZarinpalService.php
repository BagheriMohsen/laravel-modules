<?php

namespace Modules\Payment\Services\PaymentGateway;


use Illuminate\Support\Facades\Http;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Repositories\PaymentRepositoryInterface;

class ZarinpalService extends BaseService implements PaymentGatewayInterface
{

    public string $merchantId;

    public function __construct(public PaymentRepositoryInterface $paymentRepository)
    {
        parent::__construct($paymentRepository);
        $this->merchantId = config('payment.gateways.zarinpal.merchant_id');
    }

    public function request($payment): array
    {
        $response = Http::post('https://api.zarinpal.com/pg/v4/payment/request.json', [
            'merchant_id' => $this->merchantId,
            'amount' => $payment->amount, // Rial
            'description' => $payment->user_note,
            'callback_url' => $this->callbackUrl(),
            'metadata' => [
                'email' => $payment->user->email,
                'mobile' => $payment->user->mobile,
                'card_pan' => $payment->card_number
            ],
        ])->json();

        if($response['data']['code'] != 100) {
            return $this->gatewayFailedResponse($payment->id, $response);
        }

        return $this->successResponseForRedirectToGateway(
            $payment->id,
            'https://www.zarinpal.com/pg/StartPay/' . $response['data']["authority"],
            $response['data']['authority'],
            $response,
            $payment->card_number
        );
    }

    /**
     * @throws \Exception
     */
    public function callbackProcess(array $data): array
    {
        if(is_null($data['Authority'])) {
            throw new \Exception(__('Authority is required'));
        }

        if(is_null( $data["Status"])) {
            throw new \Exception(__('Status is required'));
        }

        $trackingCode  =    $data['Authority'];
        $paymentStatus =    $data['Status'] == 'OK';

        if(!$paymentStatus) {
            return [
                'status' => false,
                'tracking_code' => $trackingCode
            ];
        }

        return $this->successResponseForVerify($trackingCode);
    }

    public function verify($data): void
    {
        $payment = $this->paymentRepository->firstOrFail('id', $data['payment_id']);

        $response = Http::post('https://api.zarinpal.com/pg/v4/payment/verify.json', [
            'merchant_id' => $this->merchantId,
            'amount' => $payment->amount,
            'authority' => $payment->tracking_code
        ])->json();

        $status = $response['data']['message'] == 'Verified' ? Payment::STATUS_SUCCESS : Payment::STATUS_FAILED;

        $this->paymentRepository->update($data['payment_id'], [
            'status' => $status,
            'props' => json_encode($response)
        ]);
    }

    public function detail($trackingCode): void
    {
        //
    }

}
