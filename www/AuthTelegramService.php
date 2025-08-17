<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AuthTelegramService
{
    private $telegramEnv = '';

    public function authTelegram(array $params, $env = 'default')
    {
        switch ($env) {
            case "default":
                $this->telegramEnv = env('TELEGRAM_URL');
                break;
            case "DEV":
                $this->telegramEnv = env('TELEGRAM_URL_DEV');
                break;
            case "PRO":
                $this->telegramEnv = env('TELEGRAM_URL_PRO');
                break;
        }

        if (!$this->isHookTelegram($params)) {
            return;
        }
        if (!$this->isReceivedPhoneNumber($params)) {
            return $this->requestContact($params);
        } else {
            return $this->sendMessage($params, 'Số điện thoại của bạn chưa có trong hệ thống! Hãy cập nhật số diện thoại trong phần cài đặt đại lý.');
        }
    }

    public function sendMessage($params, $message)
    {
        $query = [
            'chat_id' => $params['message']['from']['id'],
            'text' => $message,
        ];
        return Http::get($this->telegramEnv . 'sendMessage', $query);
    }

    public function isReceivedPhoneNumber($data)
    {
        if (empty($data['message']['contact']['phone_number'])) {
            return false;
        }
        return true;
    }

    public function requestContact($params)
    {
        try {
            $message = array(
                'chat_id' => $params['message']['from']['id'],
                "text" => 'Bạn ấn vào nút gửi số điện thoại để xác thực thông tin Ro247',
                'reply_markup' => array(
                    'keyboard' => array(
                        array(
                            array(
                                'text' => "Gửi số điện thoại",
                                'request_contact' => true
                            )
                        )
                    ),

                    'one_time_keyboard' => true,
                    'resize_keyboard' => true
                )
            );
            Http::asJson()->post($this->telegramEnv . 'sendMessage', $message);
        } catch (\Exception $e) {
            Log::error('Message : ' . $e->getMessage());
        }
    }

    public function isHookTelegram($params)
    {
        if (empty($params)) {
            return false;
        }

        if (empty($params['update_id']) || empty($params['message'])) {
            return false;
        }

        if (empty($params['message']['from']['id'])) {
            return false;
        }
        return true;
    }

    public function redirectAuth($params)
    {
        Log::info("hook data " . env('APP_ENV') . " : ", $params);
        try {
            return Http::post(env('BACKEND_AGENT') . 'verify/telegram', $params);
        } catch (\Exception $e) {
            Log::error('Message : ' . $e->getMessage());
            return ['success'=>false];
        }
    }
}