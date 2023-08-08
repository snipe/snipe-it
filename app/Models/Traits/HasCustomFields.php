<?php

namespace App\Models\Traits;

use App\Models\CustomField;
use App\Models\CustomFieldset;
use Illuminate\Support\Collection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use App\Models\DefaultValuesForCustomFields;

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
    }

    abstract public function getFieldset(): ?CustomFieldset; // TODO - check version compatibilikty?

    public function experimentalgetFieldset(): ?CustomFieldset {
        $pivot = $this->getFieldsetKey();
        if(is_int($pivot)) { //why does this look just like the other thing? (below, look for is_int()
            return Fieldset::find($pivot);
        }
        return $pivot->fieldset;
    }
    /*********
     * I mean, I could make this be:
     * $this->getKey()->fieldset - or let it be overriden (for example, for Users which will have just one?)
     * (or maybe if $this->getKey() is integer, return that, otherwise return $this->getKey()->fieldset?
     *
     * Man, I really did prefer the other way. UGH. It's so simple - "give me the fieldset for your $item"
     *
     * I mean, I guess another way you could go is to have YET ANOTHER (UGHHHHHH) method, that returns
     * default values? But then you have to keep re-implementing that, everywhere. That SUUUUUUCKS.
     *
     * Or maybe we have you pass in your default values? Let it be not this thing's concern? BLECH.
     *
     * or maybe we add a withPivot() to get pivot values? or maybe just a leftJoin() ?
     *
     *
     *
     */

    abstract public function getFieldsetKey(); // : Object|int|null ????

    abstract public static function getFieldsetUsers(int $fieldset_id): Collection;

    public static function augmentValidationRulesForCustomFields($model) {
        \Log::debug("Augmenting validation rules for custom fields!!!!!!");
        $fieldset = $model->getFieldset();
        if ($fieldset) {
            foreach ($fieldset->fields as $field){
                if($field->format == 'BOOLEAN'){ // TODO - this 'feels' like entanglement of concerns?
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

    public function getDefaultValue(CustomField $field)
    {
        // FIXME - should rename that table, and add a column for something-type? or is the namespacedness enough?
        $pivot = $this->getFieldsetKey(); // TODO - feels copypasta-ish?
        \Log::debug("PIVOT IS: $pivot");
        $key_id = null;
        if(is_int($pivot)) { //*WHY* does this code repeat?!
            $key_id = $pivot; // now we're done
        } elseif(is_object($pivot)) {
            $key_id = $pivot?->id; //PHP 8.0 ONLY!!!! TODO or FIXME ?
        }
        \Log::debug("Key_id is: $key_id");
        \Log::debug("field_id is: ".$field->id);
        if(is_null($key_id)) {
            return;
        }

        return DefaultValuesForCustomFields::
            where('custom_field_id',$field->id) // ->where('type',self::class)
            ->where('asset_model_id',$key_id)->first()->default_value;
        /*
        SELECT * from models_custom_fields
        WHERE
        custom_field_id=$field->id AND asset_model_id=$key_id AND type=self::class ????
         */

        /*
         * So this is a bit of a weird one, and I'm trying to think it through.
         *
         * I like the idea of using Laravel's polymorphism to do this type of thing. Wait, that doesn't work.
         * Because then I'll have Asset #1 having default-values-for-custom fields, and then Asset #2 having that...
         * That's not what I want. It really *should* be an actual Model, right?
         * I mean, if you want to use Polymorphism, then sure.
         *
         *
         */
    }

    public function customFill(Request $request, User $user, bool $shouldSetDefaults = false) {
        $this->_filled = true;
        if ($this->getFieldset()) {
            foreach ($this->getFieldset()->fields as $field) {
                if (is_array($request->input($field->db_column))) {
                    $field_value = implode(', ', $request->input($field->db_column));
                } else {
                    $field_value = $request->input($field->db_column);
                }

                if ($shouldSetDefaults && $field_value === '') { //FIXME - null-safe? empty-string safe? 0-safe?
                    $field_value = $this->getDefaultValue($field);
                } // FIXME - also be sure anywhere *else* we use default values!
                if ($field->field_encrypted == '1') {
                    if ($user->can('admin')) {
                        $this->{$field->db_column} = \Crypt::encrypt($field_value);
                    }
                } else {
                    $this->{$field->db_column} = $request->input($field->db_column);
                }
            }
        }
    }

    public function save($options = []) {
        \Log::debug("Trait save method invoked");
        // FIXME - warning!!!!!!!!
        // I think this won't work if you try to do a Test or a console command - e.g.
        // $x = new Model(); $x->save() - will throw exception because filled was never called :(
        // CONFIRMED VIA TINKER - POOP. FIXME!!!!
        if (!$this->_filled) {
            \Log::debug("Failed to do 'filled' error - kerplowee");
            throw new \Exception("You must customFill() custom fields out before saving!");
        }
        parent::save($options);
    }
}