<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DailyReportService
{
    public function getDailyReport(array $params)
    {
        if (!session('info.code', null)) {
            return;
        }
        if (empty($params['t'])) {
            return;
        }

        $query = [
            'c' => '72',
            'code' => session('info.code'),
            't' => $params['t'],
            'mi' => 20,
            'pg' => $params['pg'] ?? 1,
            'nn' => $params['nn'] ?? null,
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