<?php

namespace Modules\Payment\Services\PaymentGateway;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Http;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Jobs\PaymentDetailJob;
use Modules\Payment\Repositories\PaymentRepositoryInterface;

class VandarService extends BaseService implements PaymentGatewayInterface
{
    private Application|UrlGenerator|string $callback;

    private array|null $vandar;

    public function __construct(public PaymentRepositoryInterface $paymentRepository,
                                public PaymentGatewayInterface $paymentGateway)
    {
        parent::__construct($paymentRepository);
        $this->callback = url("api/v1/transactions/payments/callback/");
        $this->vandar = config("payment.vandar");
    }

    public function request($payment): array
    {
        $response = Http::post($this->vandar["uri"] . "/api/v3/send", array(
            "api_key" => $this->vandar["api_key"],
            "amount" => $payment->amount * 10, // Rial
            "callback_url" => $this->callback,
            "mobile_number" => $payment->mobile,
            "factorNumber" => $payment->ref_code,
            "description" => $payment->description,
            "valid_card_number" => $payment->card_number
        ))->json();

        $response = json_decode($response, JSON_UNESCAPED_UNICODE);

        if (!$response["status"]) {
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
     * @param array $data
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function callbackProcess(array $data): array
    {
        if(is_null($data['token'])) {
            throw new \Exception(__('Token is required'));
        }

        if(is_null( $data["payment_status"])) {
            throw new \Exception(__('Status is required'));
        }

        $trackingCode  =    $data['token'];
        $paymentStatus =    $data['payment_status'];

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
        $response = Http::post($this->vandar["uri"] . "/api/v3/verify/", [
            "api_key" => $this->vandar["api_key"],
            "token" => $data['token']
        ])->json();

        $status = $response['status'] ? Payment::STATUS_SUCCESS : Payment::STATUS_FAILED;

        $this->paymentRepository->update($data['payment_id'], ['status' => $status]);
    }

    public function detail($trackingCode): void
    {
        $payment = $this->paymentRepository->firstOrFail('tracking_code', $trackingCode);
        $response = Http::post("https://vandar.io/api/ipg/2step/transaction", [
            "api_key" => $this->vandar["api_key"],
            "token" => $trackingCode
        ]);

        $this->paymentRepository->update($payment->id, ['receive_data', json_encode($response)]);
    }

}
