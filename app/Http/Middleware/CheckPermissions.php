<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Route;
use Gate;

class CheckPermissions
{
  /**
   * Handle the ACLs for permissions.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  $section
   * @return mixed
   */
    public function handle($request, Closure $next, $section = null)
    {

        if (Gate::allows($section)) {
            return $next($request);
        }

        return response()->view('layouts/basic', [
            'content' => view('errors/403')
        ]);




    }
}
