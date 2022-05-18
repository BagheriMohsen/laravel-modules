<?php

namespace Modules\Payment\Services\PaymentGateway;

use Illuminate\Support\Facades\Http;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Repositories\PaymentRepositoryInterface;

class ZibalService extends BaseService implements PaymentGatewayInterface
{
    private string $merchantId;

    private bool $sendLinkToMobileWithSms;

    public function __construct(public PaymentRepositoryInterface $paymentRepository)
    {
        parent::__construct($this->paymentRepository);
        $this->merchantId = config('payment.gateways.zibal.merchant_id');
        $this->sendLinkToMobileWithSms = config('payment.gateways.zibal.send_link_to_mobile');
    }

    public function request($payment): array
    {
        $response = Http::post('ttps://gateway.zibal.ir/v1/request', [
            'merchant_id' => $this->merchantId,
            'amount' => $payment->amount, // Rial
            'callbackUrl' => $this->callbackUrl(),
            'description' => $payment->user_note,
            'orderId' => md5($payment->id),
            'mobile' => $payment->user->cellphone,
            'allowedCards' => [
                $payment->card_number
            ],
            'linkToPay' => true,
            'sms' => $this->sendLinkToMobileWithSms
        ])->json();

        if($response['result'] != 100) {
            return $this->gatewayFailedResponse($payment->id, $response);
        }

        return $this->successResponseForRedirectToGateway(
            $payment->id,
            $response['payLink'] ?? 'https://gateway.zibal.ir/start/'. $response['trackId'],
            $response['trackId'],
            $response,
            $payment->card_number
        );
    }

    /**
     * @throws \Exception
     */
    public function callbackProcess(array $data): array
    {
        if(is_null($data['success'])) {
            throw new \Exception(__('Success is required'));
        }

        if(is_null($data['trackId'])) {
            throw new \Exception(__('Track id is required'));
        }

        if(is_null($data['orderId'])) {
            throw new \Exception(__('Order id is required'));
        }

        if(is_null($data['status'])) {
            throw new \Exception(__('Status is required'));
        }

        $trackingCode  =    $data['trackId'];
        $paymentStatus =    $data['success'] && $data['status'] == 1;

        if(!$paymentStatus) {
            return [
                'status' => false,
                'tracking_code' => $trackingCode
            ];
        }

        return $this->successResponseForVerify($trackingCode);
    }

    /**
     * @throws \Exception
     */
    public function verify($data): void
    {
        $payment = $this->paymentRepository->firstOrFail('id', $data['payment_id']);

        $response = Http::post('https://gateway.zibal.ir/v1/verify', [
            'merchant_id' => $this->merchantId,
            'trackId' => $payment->tracking_code
        ])->json();

        $status = $response['status'] == 1 ? Payment::STATUS_SUCCESS : Payment::STATUS_FAILED;

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
