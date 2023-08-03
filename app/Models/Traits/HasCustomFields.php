<?php

namespace App\Models\Traits;

use App\Models\AssetModel;
use App\Models\CustomFieldset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Collection;

/*********************************
 * Trait HasCustomFields
 * @package App\Models\Traits
 *
 * How to use: declare a PHP function getFieldset that will return your fieldset (not the ID, the actual set)
 *
 */

trait HasCustomFields
{

    //protected $observables = ['validating', 'validated']; // FIXME - will this override other observables?
                                                          // probably not? We don't use $observables elsewhere
    // it might be that Event::listen() is enough? Let's hope so.

    protected static function bootHasCustomFields()
     {
         Event::listen('eloquent.validating.*', function ($modelName, $event, $data /* FIXME is this right? */) {
             \Log::debug("Validating has fired! Model: ".$modelName." event: ".$event." and let's start with that");
             self::augmentValidationRulesForCustomFields($data);
        });
     }
    abstract public function getFieldset(): ?CustomFieldset; // TODO - check version compatibilikty?

    abstract public static function getFieldsetUsers(int $fieldset_id): Collection;

    public static function augmentValidationRulesForCustomFields(array $data) {
        $model = $data[0]; /* model is the actual _instance_ of the object whose class uses HasCustomFields */
        $fieldset = $model->getFieldset();
        if ($fieldset) {
            foreach ($fieldset->fields as $field){
                if($field->format == 'BOOLEAN'){
                    $model->{$field->db_column} = filter_var($model->{$model->db_column}, FILTER_VALIDATE_BOOLEAN);
                }
            }

            if(!$model->rules) {
                $model->rules = [];
            }
            $model->rules += $model->fieldset->validation_rules();
        }

    }
}