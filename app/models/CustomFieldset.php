<?php 
class CustomFieldset extends Elegant
{
  protected $guarded=["id"];
  public $timestamps=false;
  public function fields() {
    return $this->belongsToMany('CustomField')->withPivot(["required","order"]);
  }
  
  //requiredness goes *here*
  //sequence goes here?
}
