<?php

namespace Modules\Auth\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Auth\Http\Requests\Api\V1\RegisterRequest;
use \Modules\User\Entities\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{

    public function store(RegisterRequest $registerRequest): \Illuminate\Http\JsonResponse
    {
        $data = $registerRequest->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::query()->create($data);

        event(new Registered($user));

        Auth::guard('api')->login($user);

        return jsonResponse(message: __("User successfully registered!"), code: Response::HTTP_CREATED);
    }
}
