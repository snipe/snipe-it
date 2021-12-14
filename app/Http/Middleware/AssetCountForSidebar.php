<?php

namespace App\Http\Middleware;

use App\Models\Asset;
use Auth;
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
        $myArr = array();
        if(Auth::user()){
            $userData = Auth::user()->groups;

            foreach($userData as $userGroup){
                array_push($myArr,$userGroup->id);
            }
            try
            {
                $total_rtd_sidebar = Asset::whereHas('groups', function($query) use ($myArr){
                    $query->whereIn('group_id', $myArr);
                })->RTD()->count();
                view()->share('total_rtd_sidebar', $total_rtd_sidebar);
            } catch (\Exception $e) {
                \Log::debug($e);
            }
    
            try {
                $total_deployed_sidebar = Asset::whereHas('groups', function($query) use ($myArr){
                    $query->whereIn('group_id', $myArr);
                })->Deployed()->count();
                view()->share('total_deployed_sidebar', $total_deployed_sidebar);
            } catch (\Exception $e) {
                \Log::debug($e);
            }
    
            try {
                $total_archived_sidebar = Asset::whereHas('groups', function($query) use ($myArr){
                    $query->whereIn('group_id', $myArr);
                })->Archived()->count();
                view()->share('total_archived_sidebar', $total_archived_sidebar);
            } catch (\Exception $e) {
                \Log::debug($e);
            }
    
            try {
                $total_pending_sidebar = Asset::whereHas('groups', function($query) use ($myArr){
                    $query->whereIn('group_id', $myArr);
                })->Pending()->count();
                view()->share('total_pending_sidebar', $total_pending_sidebar);
            } catch (\Exception $e) {
                \Log::debug($e);
            }
    
            try {
                $total_undeployable_sidebar = Asset::whereHas('groups', function($query) use ($myArr){
                    $query->whereIn('group_id', $myArr);
                })->Undeployable()->count();
                view()->share('total_undeployable_sidebar', $total_undeployable_sidebar);
            } catch (\Exception $e) {
                \Log::debug($e);
            }
        }

        return $next($request);
    }
}
