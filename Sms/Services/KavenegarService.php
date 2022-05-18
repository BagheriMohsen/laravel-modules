<?php

namespace Modules\Sms\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Kavenegar\KavenegarApi;

class KavenegarService extends BaseService implements SmsServiceInterface
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = config('sms.kavenegar.api_key');
    }

    public function provider(): KavenegarApi
    {
        return new KavenegarApi($this->apiKey);
    }

    public function send($phoneNumber, $message)
    {
        try {
            $this->provider()->Send(config('sms.kavenegar.sender'), $phoneNumber, $message);
            $this->createLog($phoneNumber, $message, __METHOD__);
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    public function call($phoneNumber, $message)
    {
        try {
            $url = "https://api.kavenegar.com/v1/" . $this->apiKey . "/call/maketts.json";
            Http::get($url, [
                "receptor" => $phoneNumber,
                "message" => $message
            ]);
            $this->createLog($phoneNumber, $message, __METHOD__);
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    public function sendWithTemplate($template, $phoneNumber, $data = [])
    {
        $this->provider()->VerifyLookup(
            $phoneNumber,
            $data[0] ?? '',
            $data[1] ?? '',
            $data[2] ?? '',
            $template
        );
        $this->createLog($phoneNumber, json_encode($data), __METHOD__);
    }
}
