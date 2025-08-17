<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\DepositService;
use Illuminate\Support\Facades\Log;
use Validator;
use Illuminate\Support\Carbon;
use App\Http\Services\BankService;

class DepositController extends Controller
{
    protected $depositService;
    protected $bankService;
    protected $customMessages;

    public function __construct(DepositService $depositService, BankService $bankService)
    {
        $this->depositService = $depositService;
        $this->bankService = $bankService;
        $this->customMessages = [
            'un.required' => 'User name là bắt buộc.',
            'nn.required' => 'Nick name là bắt buộc.',
            'ps.required' => 'Mật khẩu là bắt buộc.',
            'na.required' => 'Name of agent là bắt buộc.',
        ];
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $carbonNow = Carbon::now();
        $result = $this->depositService->getListDeposit($params);
        if (!$result) {
            $error = env('CONTACT_SUPPORT');
            return view('topup.index', compact('error', 'carbonNow', 'params'));
        }
        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('page', 1);
        $data = $this->paginate($result['data']['data'], $result['totalRecords'], $perPage, $currentPage, ['path' => '']);
        return view('topup.index', ['data' => $data, 'carbonNow' => $carbonNow, 'params' => $params]);
    }

    public function withdrawList(Request $request)
    {
        $params = $request->all();
        $carbonNow = Carbon::now();
        $bankFrom = $this->bankService->getBanks();
        $result = $this->depositService->getListWithdraw($params);
        if (!$result) {
            $error = env('CONTACT_SUPPORT');
            return view('topup.withdraw', compact('error', 'carbonNow', 'bankFrom', 'params'));
        }
        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('page', 1);
        $data = $this->paginate($result['data']['data'], $result['totalRecords'], $perPage, $currentPage, ['path' => '']);
        return view('topup.withdraw', ['data' => $data, 'carbonNow' => $carbonNow, 'bankFrom' => $bankFrom, 'params' => $params]);
    }

    public function depositReject(Request $request)
    {
        $params = $request->all();
        $result = $this->depositService->reject($params['id']);
        if (empty($result['success'])) {
            session()->flash('alert-danger', empty($result['message']) ? 'Thất bại' : $result['message']);
            return $result;
        }
        session()->flash('alert-success', 'Thành công');
        return $result;
    }

    public function depositApprove(Request $request) {
        $params = $request->all();
        $result = $this->depositService->approve($params['id']);
        if (empty($result['success'])) {
            session()->flash('alert-danger', empty($result['message']) ? 'Thất bại' : $result['message']);
            return $result;
        }
        session()->flash('alert-success', 'Thành công');
        return $result;
    }

    public function withdrawReject(Request $request)
    {
        $params = $request->all();
        $result = $this->depositService->withdrawReject($params['id']);
        if (empty($result['success'])) {
            session()->flash('alert-danger', empty($result['message']) ? 'Thất bại' : $result['message']);
            return $result;
        }
        session()->flash('alert-success', 'Thành công');
        return $result;
    }

    public function withdrawApprove(Request $request) {
        $params = $request->all();
        $result = $this->depositService->withdrawApprove($params);
        Log::info('data withdrawApprove: ', $params);
        if (empty($result['success'])) {
            session()->flash('alert-danger', empty($result['message']) ? 'Thất bại' : $result['message']);
            return $result;
        }
        session()->flash('alert-success', 'Thành công');
        return $result;
    }


    public function topUpUser()
    {
        return view('topup.topUpUser');
    }

    public function storeTopUpUser(Request $request)
    {
        $params = $request->all();
        $result = $this->depositService->topUpUser($params);
        if (!empty($result['success'])) {
            session()->flash('alert-success', 'Thành công');
            return redirect(route('topup-user'));
        }
        session()->flash('alert-danger', empty($result['message']) ? 'Thất bại' : $result['message']);
        return redirect(route('topup-user'));
    }
}