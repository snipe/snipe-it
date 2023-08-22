<?php

namespace App\Models;

use Gate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

class CustomFieldset extends Model
{
    use HasFactory;
    use ValidatingTrait;

    protected $guarded = ['id'];

    /**
     * Validation rules
     * @var array
     */
    public $rules = [
        'name' => 'required|unique:custom_fieldsets',
        ''
    ];

    /**
     * Whether the model should inject it's identifier to the unique
     * validation rules before attempting validation. If this property
     * is not set in the model it will default to true.
     *
     * @var bool
     */
    protected $injectUniqueIdentifier = true;

    /**
     * Establishes the fieldset -> field relationship
     *
     * @author [Brady Wetherington] [<uberbrady@gmail.com>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function fields()
    {
        return $this->belongsToMany(\App\Models\CustomField::class)->withPivot(['required', 'order'])->orderBy('pivot_order');
    }

    /**
     * Establishes the fieldset -> models relationship
     *
     * @author [Brady Wetherington] [<uberbrady@gmail.com>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function customizable() // FIXME HATE this name. Should be something else. 'getFieldsetUsers'?
    {
        // so maybe this is a static method on 'Asset' (for example) that takes a Fieldset?
        // Asset::getFieldestUsers($fieldset_id) ????
        /************************************
         * 
         * WARNING:
         * 
         * This tries to look and act like a normal Laravel relation, but it is very much *not*
         * 
         * I decided to make it look and act similar to the Laravel relations to be easier on the developer(s)
         * (which is likely going to be me).
         * 
         * But I figured I need to warn you (me) before you start rummaging around assume that this is a 'normal' relation
         **********************************/

        // $class_name = $this->type; // FIXED I THINK BUT CHECK?: note that here, we're expecting the 'type' to be the type of the *pivot*, but elsewhere we seem to want it to be of the Customizable thing.
        // $class_name is the name of the end-result of the actually customizable thing (e.g. "asset" not "AssetModel"), in "\Blah\Blah\Blah" format as a string.
        // does it make sense to do a Trait check here, or is the actual trait *usage* enough?
        $customizable_class_name = $this->type; //TODO - copypasta from Customizable trait?
        \Log::info("Customizable Class name is: ".$customizable_class_name);
        return $customizable_class_name::getFieldsetUsers($this->id);
//        $customizable_class = new $customizable_class_name;
//        $pivot_class_name = $customizable_class->getPivotClass(); // FIXME - this is no longer correct
//
//        return $pivot_class_name::where("fieldset_id", "=", $this->id)->get(); // I *have* tested this in Tinker and it *does* seem to work.

        /**************************
         * 
         * What we're trying to do here, and it's confusing, is to basically call - 
         * 
         *  `$classname::where("fieldset_id", "=", $this->id)` - but that's not directly possible
         * So we have to use this strange contraption below
         */
//        $query_builder = call_user_func( [$class_name, "where"], "fieldset_id", "=", $this->id); //this *should* return a standard Eloquent Query Builder object
//        return $query_builder->get(); //we may want to pull this 'get' and let the caller call get on their own? Not sure. Trying to keep it acting like a relation still.
    }

    /**
     * Establishes the fieldset -> admin user relationship
     *
     * @author [Brady Wetherington] [<uberbrady@gmail.com>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class); //WARNING - not all CustomFieldsets have a User!!
    }

    /**
     * Determine the validation rules we should apply based on the
     * custom field format
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return array
     */
    public function validation_rules()
    {
        $rules = [];
        foreach ($this->fields as $field) {
            $rule = [];

            if (($field->field_encrypted != '1') ||
                  (($field->field_encrypted == '1') && (Gate::allows('admin')))) {
                    $rule[] = ($field->pivot->required == '1') ? 'required' : 'nullable';
            }

            if ($field->is_unique == '1') {
                    $rule[] = 'unique_undeleted';
            }

            if($field->format == 'date') {
                $rule[] = 'date_format:Y-m-d';
            } else {
                array_push($rule, $field->attributes['format']);
            }
            $rules[$field->db_column_name()] = $rule;
        }

        return $rules;
    }
}
