<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class BankService
{
    public function getList(array $params)
    {
        $query = [
            'c' => '9446',
            'code' => session('info.code'),
            'pg' => $params['page'] ?? 1,
            'mi' => 20,
            'key' => empty($params['key']) ? '' : $params['key'],
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

    public function getBanks()
    {
        $banks = $this->getList([]);
        if (!$banks) {
            return [];
        }

        if (empty($banks['data'])) {
            return [];
        }

        return $banks['data'];
    }

    public function store(array $params) {
        $query = [
            'c' => '9442',
            'code' => session('info.code'),
            'ba' => $params['ba'],
            'bn' => $params['bn'],
            'br' => $params['br'],
            'bc' => $params['bc'],
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
            if(empty($data['success'])) {
                return false;
            }
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

    public function delete($id)
    {
        $query = [
            'c' => '9444',
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

    public function getCodeBanks()
    {
        $query = [
            'c' => '9447',
            'pn' => 1,
            'l' => 10000,
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
            if (empty($data['success']) || empty($data['data'])) {
                return;
            }
            return $data['data'];
        } catch (\Exception $e) {
            Log::info('Exception : ' . $e->getMessage());
            return;
        }
    }
}