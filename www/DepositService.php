<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class DepositService
{
    protected $homeService;
    public function __construct(
        HomeService $homeService
    )
    {
        $this->homeService = $homeService;
    }
    public function getListDeposit(array $params)
    {
        $carbonNow = Carbon::now();
        $query = [
            'c' => '9455',
            'code' => session('info.code'),
            //'code' => '367457',
            'pg' => $params['page'] ?? 1,
            'mi' => 10,
            'st' => (!isset($params['st']) || $params['st'] === '') ? '' : $params['st'],
            'nn' => empty($params['nn']) ? '' : $params['nn'],
            'ft' => empty($params['ft']) ? $carbonNow->startOfMonth()->toDateString() : $params['ft'],
            'et' => empty($params['et']) ? $carbonNow->endOfMonth()->toDateString() : $params['et'],
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

    public function getListWithdraw(array $params)
    {
        $carbonNow = Carbon::now();
        $query = [
            'c' => '9458',
            'code' => session('info.code'),
            'pg' => $params['page'] ?? 1,
            'mi' => 10,
            'st' => (!isset($params['st']) || $params['st'] === '') ? '' : $params['st'],
            'nn' => empty($params['nn']) ? '' : $params['nn'],
            'ft' => empty($params['ft']) ? $carbonNow->startOfMonth()->toDateString() : $params['ft'],
            'et' => empty($params['et']) ? $carbonNow->endOfMonth()->toDateString() : $params['et'],
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

    public function reject($id)
    {
        $query = [
            'c' => '9454',
            'code' => session('info.code'),
            'id' => $id,
            'ac' => 'Reject',
        ];
        try {
            $response = Http::get(env('BACKEND_AGENT') . 'api_agent', $query);
            if (!$response->ok()) {
                return ['success' => false, 'message' => 'failed.'];
            }
            $body = $response->body();
            Log::info('reject deposit : ' . $body);
            if (empty($body)) {
                return ['success' => false, 'message' => 'failed'];
            }
            $data = json_decode($body, true);
            if (empty($data['success'])) {
                return ['success' => false, 'message' => empty($data['message']) ? __('base.fail') : $data['message']];
            }
            return ['success' => true, 'message' => ''];
        } catch (\Exception $e) {
            Log::info('Exception : ' . $e->getMessage());
            return;
        }
    }

    public function approve($id)
    {
        //session()->put('balance', '');
        $query = [
            'c' => '9454',
            'code' => session('info.code'),
            'id' => $id,
            'ac' => 'Approved',
        ];
        try {
            $response = Http::get(env('BACKEND_AGENT') . 'api_agent', $query);
            if (!$response->ok()) {
                return ['success' => false, 'message' => 'failed.'];
            }
            $body = $response->body();
            Log::info('approve deposit : ' . $body);
            if (empty($body)) {
                return ['success' => false, 'message' => 'failed'];
            }
            $data = json_decode($body, true);
            if (empty($data['success'])) {
                return ['success' => false, 'message' => empty($data['message']) ? __('base.fail') : $data['message']];
            }
            $this->homeService->setBalance(true);
            return ['success' => true, 'message' => ''];
        } catch (\Exception $e) {
            Log::info('Exception : ' . $e->getMessage());
            return;
        }
    }

    public function withdrawReject($id)
    {
        $query = [
            'c' => '9457',
            'code' => session('info.code'),
            'id' => $id,
            'ac' => 'reject',
        ];
        try {
            $response = Http::get(env('BACKEND_AGENT') . 'api_agent', $query);
            if (!$response->ok()) {
                return ['success' => false, 'message' => 'failed.'];
            }
            $body = $response->body();
            Log::info('reject withdrawReject : ' . $body);
            if (empty($body)) {
                return ['success' => false, 'message' => 'failed'];
            }
            $data = json_decode($body, true);
            if (empty($data['success'])) {
                return ['success' => false, 'message' => empty($data['message']) ? __('base.fail') : $data['message']];
            }
            return ['success' => true, 'message' => ''];
        } catch (\Exception $e) {
            Log::info('Exception : ' . $e->getMessage());
            return;
        }
    }

    public function withdrawApprove($params)
    {
        $query = [
            'c' => '9457',
            'code' => session('info.code'),
            'id' => $params['id'],
            'ac' => 'Approved',
            'bn' => empty($params['bn']) ? '' : $params['bn'],
            'tid' => time(),
        ];
        try {
            $response = Http::get(env('BACKEND_AGENT') . 'api_agent', $query);
            if (!$response->ok()) {
                return ['success' => false, 'message' => 'failed.'];
            }
            $body = $response->body();
            if (empty($body)) {
                return ['success' => false, 'message' => 'failed'];
            }
            $data = json_decode($body, true);
            if (empty($data['success'])) {
                return ['success' => false, 'message' => empty($data['message']) ? __('base.fail') : $data['message']];
            }
            $this->homeService->setBalance(true);
            return ['success' => true, 'message' => ''];
        } catch (\Exception $e) {
            Log::info('Exception : ' . $e->getMessage());
            return;
        }
    }

    public function topUpUser($params)
    {
        $query = [
            'c' => '9462',
            'code' => session('info.code'),
            'nn' => empty($params['nn']) ? "" : $params['nn'],
            'am' => empty($params['am']) ? "" : $params['am'],
        ];

        try {
            $response = Http::get(env('BACKEND_AGENT') . 'api_agent', $query);
            if (!$response->ok()) {
                return ['success' => false, 'message' => 'failed.'];
            }
            $body = $response->body();
            Log::info('data11 : ' . $body);
            if (empty($body)) {
                return ['success' => false, 'message' => 'failed'];
            }
            $data = json_decode($body, true);
            if (empty($data['success'])) {
                return ['success' => false, 'message' => empty($data['message']) ? __('base.fail') : $data['message']];
            }
            return ['success' => true, 'message' => ''];
        } catch (\Exception $e) {
            Log::info('Exception : ' . $e->getMessage());
            return;
        }
    }
}