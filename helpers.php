<?php

use Symfony\Component\HttpFoundation\Response;

if (! function_exists('jsonResponse')) {
    function jsonResponse(bool $success = true,
                          string $message = '',
                          array $data = [],
                          $paginationInfo = null,
                          int $code = Response::HTTP_OK,
                          array $headers = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => $success,
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'pagination' => $paginationInfo
        ], $code, $headers);
    }
}


