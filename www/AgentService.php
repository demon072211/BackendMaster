<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AgentService
{
    public function getList(array $params)
    {
        $query = [
            'c' => '9441',
            'code' => session('info.code'),
            //'code' => '367457',
            'pg' => $params['page'] ?? 1,
            'mi' => 20,
            'lv' => empty($params['level']) ? '' : $params['level'],
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

    public function store(array $params) {
        $query = [
            'c' => '9440',
            'code' => session('info.code'),
            'un' => $params['un'],
            'nn' => $params['nn'],
            'ps' => md5($params['ps']),
            'na' => $params['na'],
            'adr' => empty($params['adr']) ? '' : $params['adr'],
            'ph' => empty($params['ph']) ? '' : $params['ph'],
            'em' => empty($params['em']) ? '' : $params['em'],
            'fa' => empty($params['fa']) ? '' : $params['fa'],
            'sts' => '',
            'nb' => '',
            'sh' => 1,
            'ac' => 1,
            'cl' => 6,
        ];
        Log::info('Data query :', $query);
        try {
            $response = Http::get(env('BACKEND_AGENT') . 'api_agent', $query);
            if (!$response->ok()) {
                return;
            }
            $body = $response->body();
            Log::info('Data body :'. $body);
            if (empty($body)) {
                return;
            }
            $data = json_decode($body, true);
            if(empty($data['success'])) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::info('data : ' . $e->getMessage());
            return;
        }
    }
}