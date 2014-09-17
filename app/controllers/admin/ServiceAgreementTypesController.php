<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Model;
use Redirect;
use Setting;
use Sentry;
use DB;
use Depreciation;
use Manufacturer;
use Str;
use Validator;
use View;
use License;
use Location;


class ServiceAgreementTypesController extends AdminController 
{ 
    public function getIndex()
    {
        // Grab all the manufacturers
        $serviceagreementtypes = \ServiceAgreementType::all();

        // Show the page
        return View::make('backend/serviceagreementtypes/index', compact('serviceagreementtypes'));
    }
    
     public function getView($serviceagreementtypeId = null)
    {
        if (is_null($serviceagreementtype = \ServiceAgreementType::find($serviceagreementtypeId))) {
            // Redirect to the blogs management page
            return Redirect::to('backend/serviceagreementtypes/index')->with('error', Lang::get('admin/serviceagreementtypes/message.does_not_exist'));
        }
        
        return View::make('backend/serviceagreementtypes/view', compact('serviceagreementtype'));
    }
    
    public function getEdit($serviceagreementtypeId = null)
    {        
        if (is_null($serviceagreementtype = \ServiceAgreementType::find($serviceagreementtypeId))) {
            // Redirect to the blogs management page
            return Redirect::to('backend/serviceagreementtypess/index')->with('error', Lang::get('admin/serviceagreementtypess/message.does_not_exist'));
        }
       
        
        return View::make('backend/serviceagreementtypes/edit', compact('serviceagreementtype'));
    }
    
     public function postEdit($serviceagreementtypeId = null)
    {
        // Check if the model exists
        if (is_null($serviceagreementtype = \ServiceAgreementType::find($serviceagreementtypeId))) {
            // Redirect to the blogs management page
            return Redirect::to('backend/serviceagreementtypes/index')->with('error', Lang::get('admin/serviceagreementtypes/message.does_not_exist'));
        }

          //attempt to validate
        $validator = Validator::make(Input::all(), $serviceagreementtype->validationRules($serviceagreementtypeId));

        if ($validator->fails())
        {
            // The given data did not pass validation           
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {
            
            // Update the model data
            $serviceagreementtype->name            	= e(Input::get('name'));
            $serviceagreementtype->notes  = e(Input::get('notes'));
           
            
            // Was it created?
            if($serviceagreementtype->save()) {
                // Redirect to the new model  page                
                return Redirect::to('admin/serviceagreementtypes/')->with('success', Lang::get('message.update.success'));
            }
        } 

        // Redirect to the model create page
        return Redirect::to("admin/serviceagreementtypes/view", compact('serviceagreement'))->with('error', Lang::get('message.update.error'));

    }
    
    
    
    ///////////////////////////////////////////////////////////
    
    public function getDelete($serviceagreementtypeId = null)
    {
         // Check if the model exists
        if (is_null($serviceagreementtype = \ServiceAgreementType::find($serviceagreementtypeId))) {
            // Redirect to the blogs management page
            return Redirect::to('backend/serviceagreementtypes/index')->with('error', Lang::get('admin/serviceagreementtypes/message.does_not_exist'));
        }
        
        if($serviceagreementtype->delete())
        {
            return Redirect::to('admin/serviceagreementtypes/')->with('success', Lang::get('message.delete.success'));
        }
        else 
        {
            return Redirect::to('backend/serviceagreementtypes/')->with('error', Lang::get('message.delete.error'));
            
        }
    }
    
    public function getCreate()
    {
           
        
        return View::make('backend/serviceagreementtypes/edit')->with('serviceagreementtype', new \ServiceAgreementType);
           
    }

    public function postCreate()
    {

        // get the POST data
        $new = Input::all();

        // Create a new manufacturer
        $serviceagreementtype = new \ServiceAgreementType;

        // attempt validation
        if ($serviceagreementtype->validate($new)) {

            // Save the location data            
            $serviceagreementtype->user_id                      = Sentry::getId();
            $serviceagreementtype->name                         = e(Input::get('name'));
            $serviceagreementtype->notes              = e(Input::get('notes'));
            
            // Was it created?
            if($serviceagreementtype->save()) {
                // Redirect to the new manufacturer  page
                return Redirect::to('admin/serviceagreementtypes/')->with('success', Lang::get('message.delete.success'));
            }
        } else {
            // failure
            $errors = $serviceagreementtype->errors();
            return Redirect::back()->withInput()->withErrors($errors);
        }

        // Redirect to the manufacturer create page
        return Redirect::to('admin/serviceagreementtypes/create')->with('error', Lang::get('admin/serviceagreementtypes/message.create.error'));

    }
}