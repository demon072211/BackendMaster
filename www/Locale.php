<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use App\Http\Services\HomeService;
use Illuminate\Support\Facades\Log;

class Locale
{

    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $language = $request->session()->get('website_language', 'my');
        App::setLocale($language);
        $this->homeService->setBalance(true);
        Log::info('runn bb: ');
        return $next($request);
    }
}
