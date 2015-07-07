<?php 
class CustomFieldset extends Elegant
{
  public function fields() {
    return $this->hasMany('CustomField');
  }
  
  //requiredness goes *here*
  //sequence goes here?
}
