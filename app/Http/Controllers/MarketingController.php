<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
load em up 
incase they're in use
*/
use App\Helpers\Helper;
use App\Models\Marketing;
use App\Models\Company;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Config;
use DB;
use Gate;
use Input;
use Lang;
use Redirect;
use Slack;
use Str;
use View;
use Image;
use App\Http\Requests\ImageUploadRequest;

class MarketingController extends Controller
{
    public function index(Request $request)
    {
        //$this->authorize('index', Marketing::class);
        
                // Show the page
        if (Auth::user()->hasAccess('admin')) {

            $asset_stats=null;

            $counts['asset'] = \App\Models\Asset::count();
            $counts['accessory'] = \App\Models\Accessory::count();
            $counts['license'] = \App\Models\License::assetcount();
            $counts['consumable'] = \App\Models\Consumable::count();
            $counts['grand_total'] =  $counts['asset'] +  $counts['accessory'] +  $counts['license'] +  $counts['consumable'];

            if ((!file_exists(storage_path().'/oauth-private.key')) || (!file_exists(storage_path().'/oauth-public.key'))) {
                \Artisan::call('migrate', ['--force' => true]);
                \Artisan::call('passport:install');
            }

            return view('marketing-dashboard')->with('asset_stats', $asset_stats)->with('counts', $counts)->with('userinfo',Auth::user());
        } else {
        // Redirect to the profile page
            return redirect()->intended('account/view-assets');
        }
    }


}
