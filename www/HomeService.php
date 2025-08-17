<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class HomeService
{
    public function setBalance($isForce = false)
    {
        $query = [
            'c' => '9460',
            'rc' => session('info.code', 'null'),
        ];

        if (!$isForce && !empty(session('balance'))) {
            return;
        }
        try {
            $response = Http::get(env('BACKEND_AGENT') . 'api_agent', $query);
            if (!$response->ok()) {
                return;
            }
            $body = $response->body();
            if (empty($body)) {
                return;
            }
            $data = json_decode($body, true);
         //   Log::info('ddata : ', $data);
            if (!empty($data['transactions'][0]['vinTotal'])) {
                session()->put('balance', $data['transactions'][0]['vinTotal']);
            } else {
                session()->put('balance', '');
            }
            return;
        } catch (\Exception $e) {
            Log::info('data : ' . $e->getMessage());
            return;
        }
    }

    public function changePass(array $params)
    {
        if (empty($params['op']) || empty($params['np'])) {
            return;
        }
        $query = [
            'c' => '9426',
            'nn' => session('info.nickname'),
            'op' => md5($params['op']),
            'np' => md5($params['np']),
        ];
        try {
            $response = Http::get(env('BACKEND_AGENT') . 'api_agent', $query);
            if (!$response->ok()) {
                return;
            }
            $body = $response->body();
            $result = json_decode($body, true);
            if (empty($result['success'])) {
                return;
            }
            return true;
        } catch (\Exception $e) {
            Log::info('data : ' . $e->getMessage());
            return;
        }
    }
}