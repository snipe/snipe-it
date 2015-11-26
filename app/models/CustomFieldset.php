<?php 
class CustomFieldset extends Elegant
{
  protected $guarded=["id"];
  public $timestamps=false;
  public function fields() {
    return $this->belongsToMany('CustomField')->withPivot(["required","order"])->orderBy("pivot_order");
  }
  
  public function validation_rules()
  {
    $rules=[];
    foreach($this->fields AS $field) {
      $rule=[];
      if($field->pivot->required) {
        $rule[]="required";
      }
      array_push($rule,"regex:/".$field->attributes['format']."/");
      $rules[$field->db_column_name()]=$rule;
    }
    return $rules;
  }
  
  //requiredness goes *here*
  //sequence goes here?
}
