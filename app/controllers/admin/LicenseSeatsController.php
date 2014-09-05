<?php namespace Controllers\Admin;

use Actionlog;
use AdminController;
use Asset;
use DB;
use Depreciation;
use Family;
use Input;
use Lang;
use License;
use LicenseSeat;
use Manufacturer;
use Redirect;
use Setting;
use Sentry;
use Supplier;
use User;
use Validator;
use View;


class LicenseSeatsController extends AdminController{
    
    public function getIndex()
    {
        $seats = LicenseSeat::orderBy('created_at', 'DESC');
        
        if (Input::get('withTrashed')) {
            $seats = $seats->withTrashed();    
        } elseif (Input::get('onlyTrashed')) {	
            $seats = $seats->onlyTrashed();  
        }
        
        if (Input::get('available')) {
            $seats = $seats->whereNull('asset_id');
        }
        
        $seats = $seats->paginate(Setting::getSettings()->per_page);  
        
        // Show the page
        return View::make('backend/licenseseats/index', compact('seats'));
    }
}
