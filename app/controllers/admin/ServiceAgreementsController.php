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


class ServiceAgreementsController extends AdminController 
{ 
    public function getIndex()
    {
        // Grab all the manufacturers
        $serviceagreements = \ServiceAgreement::all();

        // Show the page
        return View::make('backend/serviceagreements/index', compact('serviceagreements'));
    }
    
    public function getEdit($serviceagreementId = null)
    {        
        if (is_null($serviceagreement = \ServiceAgreement::find($serviceagreementId))) {
            // Redirect to the blogs management page
            return Redirect::to('backend/serviceagreements/index')->with('error', Lang::get('admin/serviceagreements/message.does_not_exist'));
        }
        $service_agreement_type_list = array('' => '') + \ServiceAgreementType::orderBy('name', 'asc')->lists('name', 'id');
        $supplier_list = array('' => '') + \Supplier::orderBy('name', 'asc')->lists('name', 'id');
        $location_list = array('' => '') + Location::orderBy('name', 'asc')->lists('name', 'id');
        
        return View::make('backend/serviceagreements/edit', compact('serviceagreement'))
            ->with('service_agreement_type_list',$service_agreement_type_list)
            ->with('supplier_list',$supplier_list)
            ->with('location_list',$location_list);
    }
    
    public function getView($serviceagreementId = null)
    {
        if (is_null($serviceagreement = \ServiceAgreement::find($serviceagreementId))) {
            // Redirect to the blogs management page
            return Redirect::to('backend/serviceagreements/index')->with('error', Lang::get('admin/serviceagreements/message.does_not_exist'));
        }
        
        return View::make('backend/serviceagreements/view', compact('serviceagreement'));
    }
    
     public function postEdit($serviceagreementId = null)
    {
        // Check if the model exists
        if (is_null($serviceagreement = \ServiceAgreement::find($serviceagreementId))) {
            // Redirect to the models management page
            return Redirect::to('backend/serviceagreements/index')->with('error', Lang::get('admin/serviceagreements/message.does_not_exist'));
        }

          //attempt to validate
        $validator = Validator::make(Input::all(), $serviceagreement->validationRules($serviceagreementId));

        if ($validator->fails())
        {
            // The given data did not pass validation           
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {
            
            // Update the model data
            $serviceagreement->name            	= e(Input::get('name'));
            $serviceagreement->contract_number  = e(Input::get('contract_number'));
            $serviceagreement->management_url   = e(Input::get('management_url'));
            $serviceagreement->registered_to   = e(Input::get('registered_to')); 
            $serviceagreement->term_months   = e(Input::get('term_months'));
            $serviceagreement->supplier_id   = e(Input::get('supplier_id'));
            $serviceagreement->location_id   = e(Input::get('location_id'));            
            $serviceagreement->service_agreement_type_id   = e(Input::get('service_agreement_type_id'));
            $serviceagreement->purchase_date   = e(Input::get('purchase_date'));
            $serviceagreement->purchase_cost   = e(Input::get('purchase_cost'));
            
            // Was it created?
            if($serviceagreement->save()) {
                // Redirect to the new model  page                
                return Redirect::to('admin/serviceagreements/')->with('success', Lang::get('message.update.success'));
            }
        } 

        // Redirect to the model create page
        return Redirect::to("admin/serviceagreements/view", compact('serviceagreement'))->with('error', Lang::get('message.update.error'));

    }
    
    public function getDelete($serviceagreementId = null)
    {
        if (is_null($serviceagreement = \ServiceAgreement::find($serviceagreementId))) {
            // Redirect to the blogs management page
            return Redirect::to('backend/serviceagreements/index')->with('error', Lang::get('admin/serviceagreements/message.does_not_exist'));
        }
        
        if($serviceagreement->delete())
        {
            return Redirect::to('admin/serviceagreements/')->with('success', Lang::get('message.delete.success'));
        }
        else 
        {
            return Redirect::to('backend/serviceagreements/index')->with('error', Lang::get('message.delete.error'));
            
        }
    }
    
    public function getCreate()
    {
        $supplier_list = array('' => '') + \Supplier::orderBy('name', 'asc')->lists('name', 'id');
        $service_agreement_type_list = array('' => '') + \ServiceAgreementType::orderBy('name', 'asc')->lists('name', 'id');
        $location_list = array('' => '') + Location::orderBy('name', 'asc')->lists('name', 'id');        
        
        return View::make('backend/serviceagreements/edit')->with('serviceagreement', new \ServiceAgreement)
            ->with('supplier_list',$supplier_list)
            ->with('location_list',$location_list)
            ->with('service_agreement_type_list',$service_agreement_type_list);
    }


    /**
     * Manufacturer create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {

        // get the POST data
        $new = Input::all();

        // Create a new manufacturer
        $serviceagreement = new \ServiceAgreement;

        // attempt validation
        if ($serviceagreement->validate($new)) {

            // Save the location data            
            $serviceagreement->user_id                      = Sentry::getId();
            $serviceagreement->name                         = e(Input::get('name'));
            $serviceagreement->contract_number              = e(Input::get('contract_number'));
            $serviceagreement->management_url               = e(Input::get('management_url'));
            $serviceagreement->registered_to                = e(Input::get('registered_to')); 
            $serviceagreement->term_months                  = e(Input::get('term_months'));
            $serviceagreement->supplier_id                  = e(Input::get('supplier_id'));
            $serviceagreement->location_id                  = e(Input::get('location_id'));            
            $serviceagreement->service_agreement_type_id    = e(Input::get('service_agreement_type_id'));
            $serviceagreement->purchase_date                = e(Input::get('purchase_date'));
            $serviceagreement->purchase_cost                = e(Input::get('purchase_cost'));

            // Was it created?
            if($serviceagreement->save()) {
                // Redirect to the new manufacturer  page
                return Redirect::to('admin/serviceagreements/')->with('success', Lang::get('message.delete.success'));
            }
        } else {
            // failure
            $errors = $serviceagreement->errors();
            return Redirect::back()->withInput()->withErrors($errors);
        }

        // Redirect to the manufacturer create page
        return Redirect::to('admin/serviceagreements/create')->with('error', Lang::get('admin/serviceagreements/message.create.error'));

    }
}
