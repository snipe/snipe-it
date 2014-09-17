<?php

class ServiceAgreementType extends Elegant
{
    protected $guarded = 'id';
    protected $table = 'service_agreement_types';
    protected $softDelete = false;
    
    protected $rules = array(
        'name'                      => 'required|alpha_space|min:3|max:255|unique:service_agreement_types,name,{id}',  
        );
    
    public function has_serviceagreements()
    {
        return $this->hasMany('ServiceAgreement', 'service_agreement_type_id')->count();
    }
    
    public function serviceagreements()
    {
        return $this->hasMany('ServiceAgreement', 'service_agreement_type_id');
    } 
    


}