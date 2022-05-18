<?php

namespace Modules\Payment\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Modules\Payment\Http\Requests\Api\PaymentRequest;
use Modules\Payment\Repositories\PaymentRepositoryInterface;
use Modules\Payment\Services\PaymentGateway\PaymentGatewayInterface;


class PaymentApiController extends BaseApiController
{
    public function __construct(public PaymentRepositoryInterface $paymentRepository,
                                public PaymentGatewayInterface $paymentGateway)
    {
    }

    private function callbackUrlForFront($tracking_code): string
    {
        return  config("payment.callback_to_front")."?tracking_code=".$tracking_code;
    }

    public function request(PaymentRequest $paymentRequest): \Illuminate\Http\JsonResponse
    {
        $user = auth('api')->user();
        $paymentGatewayId = cache()->get('payment_gateway_default_id');

        $payment = $this->paymentRepository->create([
            'user_id' => $user->id,
            'payment_gateway_id' => $paymentGatewayId,
            'amount' => $paymentRequest->amount,
            'card_number' => $paymentRequest->card_number,
            'sent_date' => json_encode($paymentRequest->all()),
            'user_note' => $paymentRequest->description
        ]);

        $response = $this->paymentGateway->request($payment);

        if($response['status']) {
            return $this->sendResponse([
                'url' => $response['url']
            ], __("Transferring to the payment gateway"));
        }

        return $this->sendError(__('Something is wrong.Please try later'));
    }

    public function callback(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $this->paymentGateway->callbackProcess($request->all());
        if(!$data['status']) {
            return redirect($this->callbackUrlForFront($data['tracking_code']));
        }

        return $this->verify($data);
    }

    public function verify($data): \Illuminate\Http\RedirectResponse
    {
        $this->paymentGateway->verify($data);

        return redirect($this->callbackUrlForFront($data['tracking_code']));
    }

}
