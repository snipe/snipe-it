<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Gate;

class CustomFieldset extends Model
{
    protected $guarded=["id"];

    public $rules=[
    "name" => "required|unique:custom_fieldsets"
    ];

    public function fields()
    {
        return $this->belongsToMany('\App\Models\CustomField')->withPivot(["required","order"])->orderBy("pivot_order");
    }

    public function models()
    {
        return $this->hasMany('\App\Models\AssetModel', "fieldset_id");
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User'); //WARNING - not all CustomFieldsets have a User!!
    }

    public function validation_rules()
    {
        $rules=[];
        foreach ($this->fields as $field) {
            $rule = [];

            if (($field->field_encrypted!='1') ||
                  (($field->field_encrypted =='1')  && (Gate::allows('admin')) ))
                  {

                if ($field->pivot->required) {
                    $rule[]="required";
                }
            }

            array_push($rule, $field->attributes['format']);
            $rules[$field->db_column_name()]=$rule;
        }
        return $rules;
    }

}
