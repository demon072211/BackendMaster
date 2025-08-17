<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\BankService;
use Validator;

class BankController extends Controller
{
    protected $bankService;
    protected $customMessages;

    public function __construct(BankService $bankService)
    {
        $this->bankService = $bankService;
        $this->customMessages = [
            'ba.required' => 'Tài khoản ngân hàng là bắt buộc.',
            'bc.required' => 'Mã ngân hàng là bắt buộc.',
            'bn.required' => 'Số tài khoản  là bắt buộc.',
            'br.required' => 'Tên ngân hàng là bắt buộc.',
        ];
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $result = $this->bankService->getList($params);
        if (!$result) {
            $error = env('CONTACT_SUPPORT');
            return view('bank.index', compact('error', 'params'));
        }
        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('page', 1);
        $data = $this->paginate($result['data'], $result['totalRecords'], $perPage, $currentPage, ['path' => '']);
        return view('bank.index', ['data' => $data, 'params' => $params]);
    }

    public function create()
    {
        $listCodeBank = $this->bankService->getCodeBanks();
        if (!$listCodeBank) {
            $error = env('CONTACT_SUPPORT');
            return view('bank.create', compact('error'));
        }
        return view('bank.create', compact('listCodeBank'));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'ba' => 'required|string',
            'bc' => 'required|string',
            'bn' => 'required|string',
            'br' => 'required|string',
        ], $this->customMessages);
        if ($validator->fails()) {
            return view('bank.create', [
                'error' => $validator->messages()->first(),
            ]);
        }
        $result = $this->bankService->store($params);
        if($result) {
            session()->flash('alert-success', 'Thành công');
            return redirect(route('banks'));
        }
        session()->flash('alert-warning', 'Thất bại');
        return redirect(route('banks'));
    }

    public function edit($id)
    {
        $bank = $this->bankService->getDetail($id);
        if (!$bank) {
            return route('banks');
        }
        $listCodeBank = $this->bankService->getCodeBanks();
        if (!$listCodeBank) {
            $error = env('CONTACT_SUPPORT');
            return view('bank.edit', compact('error'));
        }
        return view('bank.edit', [
            'data' => $bank,
            'listCodeBank' => $listCodeBank,
        ]);
    }

    public function update($id, Request $request)
    {
        $params = $request->all();
        $bank = $this->bankService->getDetail($id);
        if (!$bank) {
            session()->flash('alert-warning', 'Không tồn tại.');
            return route('banks');
        }
        $result = $this->bankService->update($id, $params);
        if ($result) {
            session()->flash('alert-success', 'Thành công');
            return redirect(route('banks'));
        }
        session()->flash('alert-success', 'Thất bại');
        return redirect(route('banks'));
    }

    public function delete(Request $request)
    {
        $params = $request->all();
        $result = $this->bankService->delete($params['id']);
        if (!$result) {
            abort(500);
        }
        session()->flash('alert-success', 'Xóa thành công');
        return ['success' => true];
    }
}
