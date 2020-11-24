<?php

namespace App\Http\Middleware;

use Auth;
use App\Models\Asset;
use Closure;

class AssetCountForSidebar
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
        $total_rtd_sidebar = Asset::RTD()->count();
        $total_deployed_sidebar = Asset::Deployed()->count();
        $total_archived_sidebar = Asset::Archived()->count();
        $total_pending_sidebar = Asset::Pending()->count();
        $total_undeployable_sidebar = Asset::Undeployable()->count();
        view()->share('total_rtd_sidebar', $total_rtd_sidebar);
        view()->share('total_deployed_sidebar', $total_deployed_sidebar);
        view()->share('total_archived_sidebar', $total_archived_sidebar);
        view()->share('total_pending_sidebar', $total_pending_sidebar);
        view()->share('total_undeployable_sidebar', $total_undeployable_sidebar);

        return $next($request);
    }
}
