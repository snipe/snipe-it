<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Family;
use Redirect;
use Setting;
use DB;
use Sentry;
use Str;
use Validator;
use View;
use Country;
use Schema;

class CountriesController extends AdminController 
{
    /**
     * Show a list of all .
     *
     * @return View
     */

    public static $table = null;
    
    public function getIndex()
    {
        // Grab all the families
        $countries = Country::orderBy('created_at', 'DESC')->paginate(Setting::getSettings()->per_page);
               
        
        // Show the page
        return View::make('backend/countries/index', compact('countries'));
    }
    
    public function getView($countryID)
    {
        // Check if the entity exists
        if (is_null($country = Country::find($countryID))) {
            // Redirect to the error page
            return Redirect::to('admin/countries/entities')->with('error', Lang::get('admin/countries/message.not_found'));
        }
        
        return View::make('backend/countries/view', compact('country'));
    }
    
    
}
