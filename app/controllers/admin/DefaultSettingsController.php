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
use DefaultSetting;
use Schema;

class DefaultSettingsController extends AdminController 
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
        $default_settings = DefaultSetting::orderBy('created_at', 'DESC')->paginate(Setting::getSettings()->per_page);
        
        
        foreach ($default_settings as $setting) {
           
            $setting->value = DB::table($setting->source_table)->where('id', $setting->value)->pluck('name');
            
        }
        // Show the page
        return View::make('backend/defaultsettings/index', compact('default_settings'));
    }
    
    public function getEdit($defaultsettingId = null)
    {
        
        // Check if the setting exists
        if (is_null($defaultsetting = DefaultSetting::find($defaultsettingId))) {
            // Redirect to the default settings  page
            return Redirect::to('admin/settings/defaultsettings')->with('error', Lang::get('admin/manufacturers/message.does_not_exist'));
        }

        // If the table is configured for soft deletes, discrd those results. Oterwise get all values
        if(Schema::hasColumn($defaultsetting->source_table, 'deleted_at'))
        {
            $option_list = array('' => '') + DB::table($defaultsetting->source_table)->whereNull('deleted_at')->lists('name', 'id');
        }
        else 
        {
            $option_list = array('' => '') + DB::table($defaultsetting->source_table)->lists('name', 'id');
        }
        // Show the page
        return View::make('backend/defaultsettings/edit', compact('defaultsetting'))->with('option_list',$option_list);
    }
    
    public function postEdit($defaultsettingId = null)
    {
                // Check if the setting exists
        if (is_null($defaultsetting = DefaultSetting::find($defaultsettingId))) {
            // Redirect to the default settings  page
            return Redirect::to('admin/settings/defaultsettings')->with('error', Lang::get('admin/defaultsettings/message.does_not_exist'));
        }
        
        $validator = Validator::make(Input::all(), $defaultsetting->validationRules($defaultsettingId));

        if ($validator->fails())
        {
            // The given data did not pass validation           
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        
        else {
        
            $defaultsetting->value = e(Input::get('value'));
            
            if($defaultsetting->save()) {
                // Redirect to the new manufacturer page
                return Redirect::to("admin/settings/defaultsettings")->with('success', Lang::get('admin/defaultsettings/message.update.success'));
            }
        } 

        // Redirect to the manufacturer management page
        return Redirect::to("admin/settings/manufacturers/$manufacturerId/edit")->with('error', Lang::get('admin/defaultsettings/message.update.error'));

            
        
    }
}
