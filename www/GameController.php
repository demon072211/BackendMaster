<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\GameService;

class GameController extends Controller
{
    protected $gameService;

    public function __construct(
        GameService $gameService
    )
    {
        $this->gameService = $gameService;
    }


    public function index($type, Request $request)
    {
        $dateFrom = $request->has('ft') ? $request->get('ft') : date("Y-m-d", strtotime("-7 days"));
        $dateTo = $request->has('et') ? $request->get('et') : date("Y-m-d");
        $request->merge(['ft' => $dateFrom]);
        $request->merge(['et' => $dateTo]);
        $request->merge(['type' => $type]);
        $ft = strtotime($dateFrom);
        $et = strtotime($dateTo);
        if ($ft > $et) {
            $error = 'Ngày bắt đầu nhỏ hơn ngày kết thúc.';
            return view('gameStatic.index', compact('error', 'params'));
        }
        $params = $request->all();
        $result = $this->gameService->getGameType($params);
        if (!$result) {
            $error = env('CONTACT_SUPPORT');
            return view('gameStatic.miniGame', compact('error', 'params'));
        }

        if (!isset($result['total']) || !isset($result['data'])) {
            $error = env('CONTACT_SUPPORT');
            return view('gameStatic.miniGame', compact('error', 'params'));
        }
        
        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('page', 1);
        $data = $this->paginate($result['data'], $result['total'], $perPage, $currentPage, ['path' => '']);
        $firstItem = $data->firstItem();
        switch ($type) {
            case "MINIGAME":
                return view('gameStatic.miniGame', compact('data', 'firstItem', 'params'));
            case "POKER":
                return view('gameStatic.poker', compact('data', 'firstItem', 'params'));
            case "LIVECASINO":
                return view('gameStatic.livecasino', compact('data', 'firstItem', 'params'));
            case "SPORT":
                return view('gameStatic.sport', compact('data', 'firstItem', 'params'));
            case "NOHU":
                return view('gameStatic.nohu', compact('data', 'firstItem', 'params'));
        }
    }
}
