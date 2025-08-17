<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    public function getList(array $params)
    {
        $query = [
            'c' => '9450',
            'code' => session('info.code'),
            'pg' => $params['page'] ?? 1,
            'mi' => 10,
            'ft' => empty($params['ft']) ? '' : $params['ft'],
            'et' => empty($params['et']) ? '' : $params['et'],
            'm' => empty($params['m']) ? '' : $params['m'],
            'st' => (!isset($params['st']) || $params['st'] === '') ? '' : $params['st'],
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
            return $data;
        } catch (\Exception $e) {
            Log::info('data : ' . $e->getMessage());
            return;
        }
    }

    public function store(array $params) {
        $query = [
            'c' => '9448',
            'code' => session('info.code'),
            'm' => $params['m'],
            'fbn' => $params['fbn'],
            'tbn' => $params['tbn'],

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
            /*$data = json_decode($body, true);
            if (empty($data['success'])) {
                return false;
            }*/
            return true;
        } catch (\Exception $e) {
            Log::info('Exception : ' . $e->getMessage());
            return;
        }
    }

    public function getDetail($id)
    {
        $query = [
            'c' => '9445',
            'code' => session('info.code'),
            'id' => $id,
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
            if (empty($data['success'])) {
                return;
            }
            return $data['data'];
        } catch (\Exception $e) {
            Log::info('Exception : ' . $e->getMessage());
            return;
        }
    }

    public function update($id, $params)
    {
        $query = [
            'c' => '9443',
            'code' => session('info.code'),
            'id' => $id,
            'ba' => $params['ba'],
            'bn' => $params['bn'],
            'bc' => $params['bc'],
            'br' => $params['br'],
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
            if (empty($data['success'])) {
                return;
            }
            return true;
        } catch (\Exception $e) {
            Log::info('Exception : ' . $e->getMessage());
            return;
        }
    }

    public function reject($id)
    {
        $query = [
            'c' => '9449',
            'code' => session('info.code'),
            'id' => $id,
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
            if (empty($data['success'])) {
                return;
            }
            return true;
        } catch (\Exception $e) {
            Log::info('Exception : ' . $e->getMessage());
            return;
        }
    }
}