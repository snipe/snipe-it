<?php

class ServiceAgreement extends Elegant
{
    protected $table = 'service_agreements';
    protected $softDelete = true;
    // Declare the rules for the form validation
    protected $rules = array(
        'name'                      => 'required|alpha_space|min:3|max:255|unique:service_agreements,name,{id}',       
        'user_id'                   => 'integer',  
        'term_months'               => 'required|integer|max:100',  
        'supplier_id'               => 'integer', 
        'service_agreement_type_id' => 'integer', 
        'purchase_date'             => 'date', 
        'purchase_cost'             => 'numeric', 
        'contract_number'           => 'max:255',
        'management_url'            => 'max:100',
        'registered_to'            => 'max:255',
        'location_id'                  => 'required|integer'
    );

    
    public function location()
    {
        return $this->belongsTo('Location','location_id');
    }
    
    public function serviceagreementtype()
    {
        return $this->belongsTo('ServiceAgreementType','service_agreement_type_id');
    }
    
    public function asset()
    {
        return $this->hasMany('Asset', 'service_agreement_id');
    }
    
     public function license()
    {
        return $this->hasMany('License', 'service_agreement_id');
    }
    
}