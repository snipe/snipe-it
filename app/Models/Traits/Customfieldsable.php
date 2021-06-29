<?php

namespace App\Models\Traits;

/*********************************
 * Trait Customfieldsable
 * @package App\Models\Traits
 *
 * How to use:
 * 1. do 'use Customfieldsable'
 * 2. declare a PHP Class for you to pivot from. That Class should have a 'fieldset' value in it. For example,
 *    in Assets, the Pivot class is "AssetModel." Do this with a protected variable $custom_field_pivot_class.
 * 3. declare a string name for a pivot ID - this should be the the ID that will pivot you over to your Pivot class.
 *    For Assets, that's "model_id" (as a string).
 */

trait Customfieldsable
{

    protected static function booted()
    {
        //put the 'onsave' stuff _here_ ?
        // listen to 'saving' event (fires *BEFORE* the save?)

        //static::saved(function ($something) {
        // })

    }

    /**
     * This handles the custom field validation for anything that is Customfieldsable
     *
     * The temptation here would definitely be to instead have this fire on the 'saving' event, but the problem there
     * is I'm not sure whether or not the Validation fires before or after the saving event, and I'm not sure that
     * Watson Validating Trait will fire *first* or second. So we 'cheat' and instead override the save() command
     * itself.
     *
     * @var array
     */
    public function save(array $params = [])
    {
        if ($this->{$this->custom_field_pivot_id} != '') {
            $pivot = $this->custom_field_pivot_class::find($this->{$this->custom_field_pivot_id});

            if (($pivot) && ($pivot->fieldset)) {
                $this->rules += $pivot->fieldset->validation_rules(); //might need a separate callback here?
            }
        }

        return parent::save($params);
    }


}