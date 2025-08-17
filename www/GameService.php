<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GameService
{
    public function getGameAggregate(array $params)
    {
        if (!session('info.code', null)) {
            return;
        }
        if (empty($params['ft']) || empty($params['et'])) {
            return;
        }
        $query = [
            'c' => '71',
            'cd' => session('info.code'),
            'startTime' => $params['ft'] . ' 00:00:00',
            'endTime' => $params['et'] . ' 23:59:59',
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
            return;
        }
    }

    public function getGameType(array $params)
    {
        if (!session('info.code', null)) {
            return;
        }
        if (empty($params['ft']) || empty($params['et'])) {
            return;
        }

        $query = [
            'c' => '73',
            'code' => session('info.code'),
            'ft' => $params['ft'],
            'et' => $params['et'],
            'type' => $params['type'],
            'nn' => $params['nn'] ?? null,
            'pg' => empty($params['page']) ? 1 : $params['page'],
            'mi' => empty($params['perPage']) ? 10 : $params['perPage'],
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
            return;
        }
    }
}