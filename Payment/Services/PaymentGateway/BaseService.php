<?php

namespace Modules\Payment\Services\PaymentGateway;

use JetBrains\PhpStorm\ArrayShape;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Repositories\PaymentRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseService
{

    public function __construct(public PaymentRepositoryInterface $paymentRepository)
    {
    }

    public function cacheAndUpdatePaymentInfo($trackingCode, $paymentId, $cardNumber): bool
    {
        $paymentRepository = resolve(PaymentRepositoryInterface::class);
        $paymentRepository->update($paymentId, [
            'tracking_code' => $trackingCode
        ]);

        return cache()->set(Payment::cacheKeyPaymentData($trackingCode), json_encode([
            'payment_id' => $paymentId,
            'card_number' => $cardNumber,
        ]), now()->addMinutes(15));
    }

    public function getPaymentByTrackingCode($trackingCode): ?Payment
    {
        $data = cache()->get(Payment::cacheKeyPaymentData($trackingCode));
        abort_if(is_null($data), Response::HTTP_NOT_FOUND);

        return $this->paymentRepository->firstOrFail('tracking_code', $trackingCode);
    }

    public function callbackUrl(): string
    {
        return route('payments.callback');
    }

    public function cardIsValid($userSelectedCard, $card): bool
    {
        $userSelectedCard = substr($userSelectedCard, 0, 6) . str_repeat('*', strlen($userSelectedCard) - 10) . substr($userSelectedCard, -4);

        return $card == $userSelectedCard;
    }

    #[ArrayShape(['status' => "bool"])]
    public function gatewayFailedResponse($paymentId, array $receiveData): array
    {
        $this->paymentRepository->update($paymentId, [
            'receive_data' => json_encode($receiveData)
        ]);

        return [
            'status' => false
        ];
    }

    #[ArrayShape(['status' => "bool", 'url' => "string", 'tracking_code' => "string", 'receive_data' => "string"])]
    public function successResponseForRedirectToGateway($paymentId, string $url, string $trackingCode, array $receiveData, $cardNumber=''): array
    {
        $this->paymentRepository->update($paymentId, [
            'tracking_code' => $trackingCode,
            'receive_data' => json_encode($receiveData)
        ]);

        $this->cacheAndUpdatePaymentInfo(['data']['authority'], $paymentId, $cardNumber);

        return [
            'status' => true,
            'url' => $url,
            'tracking_code' => $trackingCode,
            'receive_data' => $receiveData
        ];
    }

    #[ArrayShape(['status' => "bool", 'payment_id' => "int", 'tracking_code' => "string"])]
    public function successResponseForVerify($trackingCode): array
    {
        $payment = $this->getPaymentByTrackingCode($trackingCode);

        return [
            'status' => true,
            'payment_id' => $payment->id,
            'tracking_code' => $trackingCode
        ];
    }
}
