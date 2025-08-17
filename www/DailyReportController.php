<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\DailyReportService;

class DailyReportController extends Controller
{
    protected $dailyReportService;

    public function __construct(
        DailyReportService $dailyReportService
    )
    {
        $this->dailyReportService = $dailyReportService;
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $date = $request->has('t') ? $request->get('t') : date("Y-m-d");
        $request->merge(['t' => $date]);
        $result = $this->dailyReportService->getDailyReport($request->all());
        if (!$result) {
            $error = env('CONTACT_SUPPORT');
            return view('userInfo.index', compact('error', 'params'));
        }

        $perPage = $request->get('perPage', 20);
        $currentPage = $request->get('page', 1);
        $data = $this->paginate($result['data'], $result['total'], $perPage, $currentPage, ['path' => '']);
        $firstItem = $data->firstItem();
        return view('dailyReport.index', compact('data', 'firstItem', 'params'));
    }
}
