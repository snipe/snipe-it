<?php

namespace App\Models\Traits;

use App\Models\CustomFieldset;
use Illuminate\Support\Collection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

/*********************************
 * Trait HasCustomFields
 * @package App\Models\Traits
 *
 * How to use: declare a PHP function getFieldset that will return your fieldset (not the ID, the actual set)
 *
 */

trait HasCustomFields
{
    private bool $_filled = false;

    // what's below crashes because it somehow conflicts with Eloquent/Model, but since this is a trait, that will win
    // we need to instead do the other way of doing it
//    protected $observables = ['validating', 'validated']; // I guess we still need this? I don't get it tho

    protected static function bootHasCustomFields()
    {
        // https://tech.chrishardie.com/2022/define-fire-listen-custom-laravel-model-events-trait/

        static::registerModelEvent('validating', function ($model, $event) {
            \Log::debug("Uh, something happened? Something good, maybe?");
            \Log::debug("model: $model, event: $event");
            self::augmentValidationRulesForCustomFields($model);
        });
    }
    // Register the existence of the publishing model event

    public function initializeHasCustomFields()
    {
        // FIXME - does not work. The Internet says that this is too 'late' - needs to happen in boot(???)
        $this->addObservableEvents([ //is this it? i think this is needed from that blog post
            'validating',
            'eloquent.validating:*' // i think this isn't doing what I was expecting
        ]);
        //\Log::debug("Okay, now calling *initialize* has custom fields - (instance-level)");
//        $this->addObservableEvents([
//            'validating'
//        ]);
        //\Log::debug($this->observables);
    }

    abstract public function getFieldset(): ?CustomFieldset; // TODO - check version compatibilikty?

    abstract public static function getFieldsetUsers(int $fieldset_id): Collection;

    public static function augmentValidationRulesForCustomFields($model) {
        \Log::debug("Augmenting validation rules for custom fields!!!!!!");
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
            $model->rules += $model->getFieldset()->validation_rules();
            \Log::debug("FINAL RULES ARE: ".print_r($model->rules,true));
        }

    }

    public function customFill(Request $request, User $user) {
        $this->_filled = true;
        if ($this->getFieldset()) {
            foreach ($this->getFieldset()->fields as $field) {
                if ($field->field_encrypted == '1') {
                    if ($user->can('admin')) {
                        if (is_array($request->input($field->db_column))) {
                            $this->{$field->db_column} = \Crypt::encrypt(implode(', ', $request->input($field->db_column)));
                        } else {
                            $this->{$field->db_column} = \Crypt::encrypt($request->input($field->db_column));
                        }
                    }
                } else {
                    if (is_array($request->input($field->db_column))) {
                        $this->{$field->db_column} = implode(', ', $request->input($field->db_column));
                    } else {
                        $this->{$field->db_column} = $request->input($field->db_column);
                    }
                }
            }
        }
    }

    public function save($options = []) {
        \Log::debug("Trait save method invoked");
        if (!$this->_filled) {
            \Log::debug("Failed to do 'filled' error - kerplowee");
            throw new \Exception("You must customFill() custom fields out before saving!");
        }
        parent::save($options);
    }
}