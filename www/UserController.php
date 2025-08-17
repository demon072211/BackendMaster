<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\UserService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userService;

    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $userInfo = $this->userService->getUserInfo();
        return view('userInfo.info', [
            'userInfo' => $userInfo
        ]);
    }

    public function userInfo(Request $request)
    {
        $result = $this->userService->updateUserInfo($request->all());
        if ($result) {
            session()->flash('alert-success', 'Thành công');
            return redirect(route('info'));
        }

        session()->flash('alert-warning', 'Thất bại');
        return redirect(route('info'));
    }

    public function getList(Request $request)
    {
        $carbonNow = Carbon::now();
        if ($request->has('ft') && $request->has('et')) {
            $ft = strtotime($request->get('ft'));
            $et = strtotime($request->get('et'));
            if ($ft > $et) {
                $error = 'Ngày bắt đầu nhỏ hơn ngày kết thúc.';
                return view('userInfo.index', compact('error'));
            }
        }

        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('page', 1);
        $params = $request->all();
        $params['ft'] = $carbonNow->startOfMonth()->toDateString();
        $params['et'] = $carbonNow->endOfMonth()->toDateString();
        $result = $this->userService->getList($params);
        if (!$result) {
            $error = env('CONTACT_SUPPORT');
            return view('userInfo.index', compact('error'));
        }
        $data = $this->paginate($result['data']['listData'], $result['totalRecords'], $perPage, $currentPage, ['path' => '']);
        $totalData = [
            'total_doanhthu' => empty($result['data']['total_doanhthu']) ? 0 : $result['data']['total_doanhthu'],
            'total_rut' => empty($result['data']['total_rut']) ? 0 : $result['data']['total_rut'],
            'total_km' => empty($result['data']['total_km']) ? 0 : $result['data']['total_km'],
            'total_nap' => empty($result['data']['total_nap']) ? 0 : $result['data']['total_nap']
        ];
        $firstItem = $data->firstItem();
        return view('userInfo.index', compact('data', 'firstItem', 'params', 'totalData', 'carbonNow'));
    }
}