<?php

namespace Modules\Auth\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return jsonResponse(message: __('Email has been verified!'));
        }

        $request->user()->sendEmailVerificationNotification();

        return jsonResponse(message: __('Verification link sent'));
    }
}
