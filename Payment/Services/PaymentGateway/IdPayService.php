<?php

namespace Modules\Payment\Services\PaymentGateway;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Jobs\PaymentDetailJob;
use Modules\Payment\Repositories\PaymentRepositoryInterface;

class IdPayService extends BaseService implements PaymentGatewayInterface
{
    private string $apiKey;

    private bool $sandBox;

    public function __construct(public PaymentRepositoryInterface $paymentRepository)
    {
        parent::__construct($paymentRepository);
        $this->apiKey = config('payment.gateways.idpay.api_key');
        $this->sandBox = config('payment.gateways.idpay.sandbox');
    }

    public function provider(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-API-KEY' => $this->apiKey,
            'X-SANDBOX' => $this->sandBox
        ]);
    }
    public function request($payment): array
    {
        $response = $this->provider()->post('https://api.idpay.ir/v1.1/payment', [
            "order_id" => md5($payment->id),
            "amount" => $payment->amount, // Rial
            "name" => $payment->user->name,
            "phone" => $payment->user->cellphone,
            "mail" => $payment->user->email,
            "desc" => $payment->user_note,
            "callback" => $this->callbackUrl()
        ]);

        if($response->status() != Response::HTTP_CREATED && $response->status() != Response::HTTP_OK) {
            return $this->gatewayFailedResponse($payment->id, $response->json());
        }

        $responseJson = $response->json();

        return $this->successResponseForRedirectToGateway(
            $payment->id,
            'https://idpay.ir/p/ws-sandbox/'.$responseJson['id'],
            $responseJson['id'],
            $responseJson,
            $payment->card_number
        );
    }

    /**
     * @throws \Exception
     */
    public function callbackProcess(array $data): array
    {
        if(is_null($data['status'])) {
            throw new \Exception(__('Status is required'));
        }

        if(is_null($data['track_id'])) {
            throw new \Exception(__('Track id is required'));
        }

        if(is_null($data['id'])) {
            throw new \Exception(__('Id id is required'));
        }

        if(is_null($data['order_id'])) {
            throw new \Exception(__('Order id is required'));
        }

        $trackingCode  =    $data['id'];
        $paymentStatus =    $data['status'] == 100;

        if(!$paymentStatus) {
            return [
                'status' => false,
                'tracking_code' => $trackingCode
            ];
        }

        dispatch(new PaymentDetailJob($trackingCode));

        return $this->successResponseForVerify($trackingCode);
    }

    public function verify($data): void
    {
        $payment = $this->paymentRepository->firstOrFail('id', $data['payment_id']);

        $response = $this->provider()->post('https://api.idpay.ir/v1.1/payment/verify', [
            'id' => $payment->tracking_code,
            'order_id' => md5($payment->id)
        ]);

        $status = $response->status() == Response::HTTP_OK ? Payment::STATUS_SUCCESS : Payment::STATUS_FAILED;

        $this->paymentRepository->update($data['payment_id'], [
            'status' => $status,
            'props' => json_encode($response)
        ]);
    }

    public function detail($trackingCode): void
    {
        $payment = $this->paymentRepository->firstOrFail('tracking_code', $trackingCode);
        $response = $this->provider()->post('https://api.idpay.ir/v1.1/payment/inquiry', [
            'id' => $payment->tracking_code,
            'order_id' => md5($payment->id)
        ]);

        $this->paymentRepository->update($payment->id, ['receive_data', json_encode($response)]);
    }

}
