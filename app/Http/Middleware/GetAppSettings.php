<?php

namespace App\Http\Middleware;

use App\Models\Setting;

use Closure;

class GetAppSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $app_settings = Setting::getSettings();
        view()->share('app_settings', $app_settings);
        return $next($request);
    }
}
