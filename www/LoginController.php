<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Services\AuthTelegramService;
use App\Http\Services\HomeService;

class LoginController extends Controller
{
    protected $authTelegramService;
    protected $homeService;

    public function __construct(
        AuthTelegramService $authTelegramService,
        HomeService $homeService
    )
    {
        $this->authTelegramService = $authTelegramService;
        $this->homeService = $homeService;
    }

    public function index(Request $request)
    {
        if ($request->session()->has('info')) {
            return redirect('home');
        }
        return view('login');
    }

    public function auth(Request $request)
    {
        try {
            $response = Http::asForm()->post(env('BACKEND_AGENT') . 'api_agent', [
                    'c' => 9428,
                    'un' => $request->get('user_name', ''),
                    'ps' => $request->has('pass') ? md5($request->get('pass')) : null,
                ]);

            if (!$response->ok()) {
                return redirect()->route('login')->with('error', env('CONTACT_SUPPORT'));
            }
            $body = $response->body();
            if (empty($body)) {
                return redirect()->route('login')->with('error', env('CONTACT_SUPPORT'));
            }
            $data = json_decode($body, true);
            if (!$data['success']) {
                return redirect()->route('login')->with('error', 'Đăng nhập thất bại : ' . $data['message']);
            }
            $request->session()->put('info', $data['data']);
            Log::info('data : ' , $data);
            $this->homeService->setBalance();
            return redirect('home');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', env('CONTACT_SUPPORT'));
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('info');
        $request->session()->forget('balance');
        return redirect('/');
    }

    public function hook(Request $request)
    {
        return $this->authTelegramService->authTelegram($request->all());
    }

    public function hookPro(Request $request)
    {
//        return $this->authTelegramService->authTelegram($request->all(), 'DEV');
        /*if ($request->ip() != "91.108.6.94") {
            Log::info("hookDev hack ip : " . $request->ip());
            return ['message' => "Please dont hack"];
        }*/
        Log::info("hookPro  ip : " . $request->ip());
        return $this->authTelegramService->redirectAuth($request->all());
    }

    public function hookDev(Request $request)
    {
        return $this->authTelegramService->authTelegram($request->all(), 'PRO');
    }

    public function changePass()
    {
        return view('userInfo.changePass');
    }

    public function changePassWord(Request $request)
    {
        $result = $this->homeService->changePass($request->all());
        if ($result) {
            session()->flash('alert-success', 'Thành công');
            return redirect(route('change-pass'));
        }

        session()->flash('alert-warning', 'Thất bại');
        return redirect(route('change-pass'));
    }

    public function getDeposit()
    {
        echo "Search withdraw for agent admin : " . "<br>";
        //http://localhost:19082/api_agent?c=9426&nn=htun&op=<old_pass>&np=<neu_pass>
        /*$query = [
            'c' => '9461',
            'nn' => "thuylinh",
            'na' => "Agent Test",
            'adr' => "Yangon",
            'ph' => "1321321",
            'adr' => "Yangon",
            'em' => "testnewli@gmail.com",
            'fa' => "",
        ];*/
        $query = [
            'c' => '71',
            'startTime' => '2021-01-14 00:00:00',
            'endTime' => '2021-10-14 23:59:59',
            'nickname' => '',
        ];
        try {
            $response = Http::get(env('BACKEND_AGENT') . 'api_backend', $query);
            if (!$response->ok()) {
                return;
            }
            $body = $response->body();
            echo $body;
        } catch (\Exception $e) {
            Log::info('data : ' . $e->getMessage());
            return;
        }
        echo "<br>";
    }
}
