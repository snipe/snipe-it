<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
//use Model;
use Redirect;
//use Setting;
use Sentry;
//use DB;
//use Depreciation;
//use Manufacturer;
//use Str;
use Validator;
use View;
//use License;
use Location;
use ServiceAgreement;


class ServiceAgreementsController extends AdminController 
{ 
    public function getIndex()
    {
        if (Input::get('withTrashed')) {
            $serviceagreements = ServiceAgreement::withTrashed()->get();  
        } elseif (Input::get('onlyTrashed')) {	
            $serviceagreements = ServiceAgreement::onlyTrashed()->get();  
        }    
        else {
            $serviceagreements = ServiceAgreement::all();
        }

        // Show the page
        return View::make('backend/serviceagreements/index', compact('serviceagreements'));
    }
    
    public function getEdit($serviceagreementId = null)
    {        
        if (is_null($serviceagreement = ServiceAgreement::find($serviceagreementId))) {
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
        if (is_null($serviceagreement = ServiceAgreement::find($serviceagreementId))) {
            // Redirect to the blogs management page
            return Redirect::to('backend/serviceagreements/index')->with('error', Lang::get('admin/serviceagreements/message.does_not_exist'));
        }
        
        return View::make('backend/serviceagreements/view', compact('serviceagreement'));
    }
    
     public function postEdit($serviceagreementId = null)
    {
        // Check if the model exists
        if (is_null($serviceagreement = ServiceAgreement::find($serviceagreementId))) {
            // Redirect to the models management page
            return Redirect::to('backend/serviceagreements/index')->with('error', Lang::get('admin/serviceagreements/message.does_not_exist'));
        }

        // Cleans the currency input value before validation
        Input::merge(array_map('ParseFloat', Input::only('purchase_cost')));         
        
          //attempt to validate
        $validator = Validator::make(Input::all(), $serviceagreement->validationRules($serviceagreementId));

        if ($validator->fails())
        {
            // The given data did not pass validation           
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {
            
             // Save the location data            
            $serviceagreement->user_id                      = Sentry::getId();
            $serviceagreement->name                         = e(Input::get('name'));
            $serviceagreement->contract_number              = e(Input::get('contract_number'));
            $serviceagreement->management_url               = e(Input::get('management_url'));
            $serviceagreement->registered_to                = e(Input::get('registered_to')); 
            $serviceagreement->term_months                  = e(Input::get('term_months'));
            //$serviceagreement->supplier_id                  = e(Input::get('supplier_id'));
            $serviceagreement->location_id                  = e(Input::get('location_id'));            
            //$serviceagreement->service_agreement_type_id    = e(Input::get('service_agreement_type_id'));
            //$serviceagreement->purchase_date                = e(Input::get('purchase_date'));
            //$serviceagreement->purchase_cost                = e(Input::get('purchase_cost'));
            
            if ( e(Input::get('purchase_date')) == '') {
                $serviceagreement->purchase_cost =  null;
            } else {
                $serviceagreement->purchase_cost = e(Input::get('purchase_cost'));
            }
            
            if ( e(Input::get('purchase_date')) == '') {
                $serviceagreement->purchase_date =  null;
            } else {
                $serviceagreement->purchase_date = e(Input::get('purchase_date'));
            }
            
            if ( e(Input::get('service_agreement_type_id')) == '') {
                $serviceagreement->service_agreement_type_id =  0;
            } else {
                $serviceagreement->service_agreement_type_id = e(Input::get('service_agreement_type_id'));
            }
            
            if ( e(Input::get('supplier_id')) == '') {
                $serviceagreement->supplier_id =  0;
            } else {
                $serviceagreement->supplier_id = e(Input::get('supplier_id'));
            }
            
            if ( e(Input::get('notes')) == '') {
                $serviceagreement->notes =  '';
            } else {
                $serviceagreement->notes = e(Input::get('notes'));
            }
            
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
        if (is_null($serviceagreement = ServiceAgreement::withTrashed()->find($serviceagreementId))) {
            // Redirect to the license management page
            return Redirect::to('admin/serviceagreements')->with('error', Lang::get('admin/serviceagreements/message.not_found'));
        }
        
        if($serviceagreement->trashed())
            {                
                $serviceagreement->forceDelete();
               
            } else {
                // Delete the license and the associated license seats                
                $serviceagreement->delete();
            }
        
         return Redirect::to('admin/serviceagreements/')->with('success', Lang::get('message.delete.success'));
        
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

    public function postCreate()
    {

        // Create a new manufacturer
        $serviceagreement = new ServiceAgreement();
        
        // Cleans the currency input value before validation
        Input::merge(array_map('ParseFloat', Input::only('purchase_cost'))); 
        
        //attempt to validate
        $validator = Validator::make(Input::all(), $serviceagreement->validationRules());
        
        // attempt validation
        if ($validator->fails())
        {
            // The given data did not pass validation            
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        else {

            // Save the location data            
            $serviceagreement->user_id                      = Sentry::getId();
            $serviceagreement->name                         = e(Input::get('name'));
            $serviceagreement->contract_number              = e(Input::get('contract_number'));
            $serviceagreement->management_url               = e(Input::get('management_url'));
            $serviceagreement->registered_to                = e(Input::get('registered_to')); 
            $serviceagreement->term_months                  = e(Input::get('term_months'));
            //$serviceagreement->supplier_id                  = e(Input::get('supplier_id'));
            $serviceagreement->location_id                  = e(Input::get('location_id'));            
            //$serviceagreement->service_agreement_type_id    = e(Input::get('service_agreement_type_id'));
            //$serviceagreement->purchase_date                = e(Input::get('purchase_date'));
            //$serviceagreement->purchase_cost                = e(Input::get('purchase_cost'));
            
            if ( e(Input::get('purchase_date')) == '') {
                $serviceagreement->purchase_cost =  null;
            } else {
                $serviceagreement->purchase_cost = e(Input::get('purchase_cost'));
            }
            
            if ( e(Input::get('purchase_date')) == '') {
                $serviceagreement->purchase_date =  null;
            } else {
                $serviceagreement->purchase_date = e(Input::get('purchase_date'));
            }
            
            if ( e(Input::get('service_agreement_type_id')) == '') {
                $serviceagreement->service_agreement_type_id =  0;
            } else {
                $serviceagreement->service_agreement_type_id = e(Input::get('service_agreement_type_id'));
            }
            
            if ( e(Input::get('supplier_id')) == '') {
                $serviceagreement->supplier_id =  0;
            } else {
                $serviceagreement->supplier_id = e(Input::get('supplier_id'));
            }
            
            if ( e(Input::get('notes')) == '') {
                $serviceagreement->notes =  '';
            } else {
                $serviceagreement->notes = e(Input::get('notes'));
            }

            // Was it created?
            if($serviceagreement->save()) {
                // Redirect to the new manufacturer  page
                return Redirect::to('admin/serviceagreements/')->with('success', Lang::get('message.delete.success'));
            }
        }

        // Redirect to the manufacturer create page
        return Redirect::to('admin/serviceagreements/create')->with('error', Lang::get('admin/serviceagreements/message.create.error'));

    }
    
    public function getRestore($serviceagreementId)
    {
    
        if (is_null($serviceagreement = ServiceAgreement::withTrashed()->find($serviceagreementId))) {
            // Redirect to the license management page
            return Redirect::to('admin/serviceagreements')->with('error', Lang::get('admin/serviceagreements/message.not_found'));
        }
        
        $serviceagreement->restore();
        
        
        ServiceAgreement::withTrashed()->where('id', $serviceagreement->id)->restore();
        
        
        return Redirect::to('admin/serviceagreements')->with('success', Lang::get('message.restore.success'));
    }
    
    public function getPurge()
    {
        //delete all licenses
        ServiceAgreement::onlyTrashed()->forceDelete();      
     
        
        return Redirect::to('admin/serviceagreements')->with('success', 'Purge Submitted');
    }
    
    public function getClone($serviceagreementId = null)
    {
         // Check if the license exists
        if (is_null($serviceagreement_to_clone = ServiceAgreement::withTrashed()->find($serviceagreementId))) {
            // Redirect to the license management page
            return Redirect::to('admin/serviceagreements')->with('error', Lang::get('admin/serviceagreements/message.not_found'));
        }

        $supplier_list = array('' => '') + \Supplier::orderBy('name', 'asc')->lists('name', 'id');
        $service_agreement_type_list = array('' => '') + \ServiceAgreementType::orderBy('name', 'asc')->lists('name', 'id');
        $location_list = array('' => '') + Location::orderBy('name', 'asc')->lists('name', 'id');        
        
        
        //clone the orig
        $serviceagreement = clone $serviceagreement_to_clone;
        $serviceagreement->id = null;
        $serviceagreement->serial = null;

        // Show the page
        return View::make('backend/serviceagreements/edit')->with('serviceagreement', $serviceagreement)
            ->with('supplier_list',$supplier_list)
            ->with('location_list',$location_list)
            ->with('service_agreement_type_list',$service_agreement_type_list);

    }
}
