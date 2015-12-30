<?php 
class CustomFieldset extends Elegant
{
  protected $guarded=["id"];

  public $rules=[
    "name" => "required|unique:custom_fieldsets"
  ];

  public function fields() {
    return $this->belongsToMany('CustomField')->withPivot(["required","order"])->orderBy("pivot_order");
  }
  
  public function models() {
    return $this->hasMany('Model',"fieldset_id");
  }
  
  public function user() {
    return $this->belongsTo('User'); //WARNING - not all CustomFieldsets have a User!!
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
