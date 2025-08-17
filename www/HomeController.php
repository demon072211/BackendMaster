<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('home', [
            'user' => 1
        ]);
    }

    public function locale(Request $request)
    {
        $locale = $request->get('locale');
        if (in_array($locale, ['en', 'vi', 'my'])) {
            $request->session()->put('website_language', $locale);
        }
        return ['success' => $locale];
    }
}
