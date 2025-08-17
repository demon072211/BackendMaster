<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\IncomeService;

class IncomeController extends Controller
{
    protected $incomeService;

    public function __construct(
        IncomeService $incomeService
    )
    {
        $this->incomeService = $incomeService;
    }

    public function index(Request $request)
    {
        $params = $request->all();
        if (empty($request->get('t'))) {
            $request->merge(['t' => date('Y-m')]);
        }
//        $data = $this->incomeService->getDetail($request->all());
        $data = $this->incomeService->getDetail(['t' => date('Y-m')]);
        return view('income.index', [
            'data' => $data['data'] ?? null,
            'params' => $params
        ]
        );
    }
}
