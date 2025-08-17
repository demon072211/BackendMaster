<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class IncomeService
{
    public function getDetail(array $params)
    {
        if (!session('info.code', null)) {
            return;
        }
        $date = date_create($params['t']);
        $query = [
            'c' => '75',
            'code' => session('info.code'),
            'pg' => 1,
            'mi' => 20,
            'y' => date_format($date, "Y"),
            'm' => date_format($date, "m"),
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