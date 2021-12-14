<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdminController;
use View;
use Illuminate\Support\Facades\Log;


/**
 * This controller handles all actions related to the Admin Dashboard
 * for the Snipe-IT Asset Management application.
 *
 * @author A. Gianotto <snipe@snipe.net>
 * @version v1.0
 */
class DashboardController extends Controller
{
    /**
     * Check authorization and display admin dashboard, otherwise display
     * the user's checked-out assets.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function index()
    {
        // Show the page
        if (Auth::user()->hasAccess('admin')) {
            $asset_stats = null;

            $myArr = array();
            $userData = Auth::user()->isAdminofGroup();

            foreach($userData as $id => $group){
                array_push($myArr,$id);
            }

            if(Auth::user()->isSuperUser()){
                $counts['asset'] = \App\Models\Asset::count();
                $counts['accessory'] = \App\Models\Accessory::count();
                $counts['license'] = \App\Models\License::assetcount();
                $counts['consumable'] = \App\Models\Consumable::count();
		$counts['component'] = \App\Models\Component::count();
		$counts['user'] = \App\Models\User::count();
                $counts['grand_total'] =  $counts['asset'] +  $counts['accessory'] +  $counts['license'] +  $counts['consumable'];

            }else{

                $counts['asset'] = \App\Models\Asset::whereHas('groups', function($query) use ($myArr){
                    $query->whereIn('group_id', $myArr);
                })->count();

                $counts['accessory'] = \App\Models\Accessory::whereHas('groups', function($query) use ($myArr){
                    $query->whereIn('group_id', $myArr);
                })->count();

                $counts['license'] = \App\Models\License::assetcount();
                
                $counts['consumable'] = \App\Models\Consumable::whereHas('groups', function($query) use ($myArr){
                    $query->whereIn('group_id', $myArr);
                })->count();
		
		//most likely $counts['component'] and $counts['user'] has to be added here!

                $counts['grand_total'] =  $counts['asset'] +  $counts['accessory'] +  $counts['license'] +  $counts['consumable'];
            }
            if ((! file_exists(storage_path().'/oauth-private.key')) || (! file_exists(storage_path().'/oauth-public.key'))) {
                Artisan::call('migrate', ['--force' => true]);
                \Artisan::call('passport:install');
            }

            return view('dashboard')->with('asset_stats', $asset_stats)->with('counts', $counts);
        } else {
            // Redirect to the profile page
            return redirect()->intended('account/view-assets');
        }
    }
}
