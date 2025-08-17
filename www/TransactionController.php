<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\BankService;
use App\Http\Services\TransactionService;
use Illuminate\Support\Facades\Log;
use Validator;
use Illuminate\Support\Carbon;

class TransactionController extends Controller
{
    protected $bankService;
    protected $transactionService;
    protected $customMessages;

    public function __construct(BankService $bankService, TransactionService $transactionService)
    {
        $this->bankService = $bankService;
        $this->transactionService = $transactionService;
        $this->customMessages = [
            'm.required' => 'Số tiền là bắt buộc.',
            'fbn.required' => 'Tài khoản nguồn là bắt buộc.',
            'tbn.required' => 'Tài khoản đích là bắt buộc.',
        ];
    }

    public function index(Request $request)
    {
        $carbonNow = Carbon::now();
        $params = $request->all();
        $result = $this->transactionService->getList($params);
        if (!$result) {
            $error = env('CONTACT_SUPPORT');
            return view('transaction.index', compact('error', 'carbonNow', 'params'));
        }
        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('page', 1);
        $data = $this->paginate($result['data']['transactions'], $result['totalRecords'], $perPage, $currentPage, ['path' => '']);
        return view('transaction.index', [
            'data' => $data,
            'carbonNow' => $carbonNow,
            'params' => $params,
        ]);
    }

    public function create()
    {
        $banks =  config('agent.banks');
        $bankFrom = $this->bankService->getBanks();
        return view('transaction.create', compact('banks', 'bankFrom'));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'm' => 'required|string',
            'fbn' => 'required|string',
            'tbn' => 'required|string',
        ], $this->customMessages);
        if ($validator->fails()) {
            return view('transaction.create', [
                'error' => $validator->messages()->first(),
            ]);
        }
        $result = $this->transactionService->store($params);
        if ($result) {
            session()->flash('alert-success', 'Thành công');
            return redirect(route('transactions'));
        }
        session()->flash('alert-warning', 'Thất bại');
        return redirect(route('transactions'));
    }


    public function reject(Request $request)
    {
        $params = $request->all();
        $result = $this->transactionService->reject($params['id']);
        if (!$result) {
            abort(500);
        }
        session()->flash('alert-success', 'Xóa thành công');
        return ['success' => true];
    }
}
