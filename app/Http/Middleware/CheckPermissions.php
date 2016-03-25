<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Route;

class CheckPermissions
{
  /**
   * Handle the ACLs for permissions.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  $guard
   * @return mixed
   */
    public function handle($request, Closure $next, $section = null, $guard = null)
    {

        if (($request->user()->hasAccess($section)) || ($request->user()->isSuperUser())) {
            return $next($request);
        }

        return response()->view('layouts/basic', [
          'content' => view('errors/403')
        ]);

    }
}
