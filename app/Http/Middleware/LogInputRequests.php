<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;

class LogInputRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(isset($request->updates)) {
            foreach($request->updates as $update)
                if(isset($update['payload']['method']) &&
                $update['payload']['method']=='submit'
                ) {
                    $userId = $request->user() ? $request->user()->id : 'NA';

                    Log::info(
                        "User: $userId, Path: $request->path(), 
                  Submission:" . json_encode($request->updates)
                    );
                    break;
                }
        }

        return $next($request);
    }
}
