<?php 
class CustomFieldset extends Elegant
{
  public function fields() {
    return $this->belongsToMany('CustomField');
  }
  
  //requiredness goes *here*
  //sequence goes here?
}
