<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class UserService
{
    public function getList(array $params)
    {
        try {
            if (!session('info.code', null)) {
                return;
            }
            $query = [
                'c' => '9425',
                'cd' => session('info.code'),
                'nn' => empty($params['nn']) ? null : $params['nn'],
                'pg' => empty($params['page']) ? 1 : $params['page'],
                'mi' => empty($params['perPage']) ? 10 : $params['perPage'],
            ];

            if (!empty($params['et']) && !empty($params['ft'])) {
                $query['ft'] = $params['ft'] . ' 00:00:00';
                $query['et'] = $params['et'] . ' 23:59:59';
            }

            $response = Http::get(env('BACKEND_AGENT') . 'api_agent', $query);
            if (!$response->ok()) {
                return;
            }
            $body = $response->body();
            if (empty($body)) {
                return;
            }
            $data = json_decode($body, true);
            if (!$data['success']) {
                return;
            }
            return $data;
        } catch (\Exception $e) {
            return;
        }
    }

    ////http://localhost:19082/api_agent?c=9461&nn=htun&na=name agent&adr=address&ph=Telephone&em=email&fa=Facebook
    public function updateUserInfo(array $params)
    {
        $query = [
            'c' => '9461',
            'nn' => session('info.nickname'),
            'na' => empty($params['na']) ? '' : $params['na'],
            'adr' => empty($params['adr']) ? '' : $params['adr'],
            'ph' => empty($params['ph']) ? '' : $params['ph'],
            'em' => empty($params['em']) ? '' : $params['em'],
            'fa' => empty($params['fa']) ? '' : $params['fa'],
        ];
        Log::info('updateUserInfo : ', $query);
        try {
            $response = Http::get(env('BACKEND_AGENT') . 'api_agent', $query);
            if (!$response->ok()) {
                return;
            }
            $body = $response->body();
            Log::info('updateUserInfo $body : ' . $body);
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

    public function getUserInfo() {
        $query = [
            'c' => '9424',
            'id' => session('info.id', 'null'),
        ];
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
            if (!empty($data['data'])) {
                return $data['data'];
            }
            return;
        } catch (\Exception $e) {
            Log::info('data : ' . $e->getMessage());
            return;
        }
    }
}