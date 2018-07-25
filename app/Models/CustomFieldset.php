<?php
namespace App\Models;

use App\Models\Relationships\CustomFieldsetRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Watson\Validating\ValidatingTrait;

class CustomFieldset extends Model
{
    use CustomFieldsetRelationships;
    protected $guarded=["id"];

    public $rules=[
    "name" => "required|unique:custom_fieldsets"
    ];

    /**
     * Whether the model should inject it's identifier to the unique
     * validation rules before attempting validation. If this property
     * is not set in the model it will default to true.
     *
     * @var boolean
     */
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;
    


    public function validation_rules()
    {
        $rules=[];
        foreach ($this->fields as $field) {
            $rule = [];

            if (($field->field_encrypted!='1') ||
                  (($field->field_encrypted =='1')  && (Gate::allows('admin')) )) {
                    $rule[] = ($field->pivot->required=='1') ? "required" : "nullable";
            }

            array_push($rule, $field->attributes['format']);
            $rules[$field->db_column_name()]=$rule;
        }
        return $rules;
    }
}
