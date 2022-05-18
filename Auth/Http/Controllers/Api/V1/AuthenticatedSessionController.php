<?php

namespace Modules\Auth\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\Api\V1\LoginRequest;

class AuthenticatedSessionController extends Controller
{

    public function store(LoginRequest $loginRequest): \Illuminate\Http\JsonResponse
    {
        $loginRequest->authenticate();

        $loginRequest->session()->regenerate();

        return jsonResponse(__('User successfully logged in!'));
    }

    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return jsonResponse(__('User successfully logout!'), Response::HTTP_NO_CONTENT);
    }
}
