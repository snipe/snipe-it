<?php

namespace App\Models\Traits;

/*********************************
 * Trait Customizable
 * @package App\Models\Traits
 *
 * How to use:
 * 1. do 'use Customizable'
 * 2. declare a PHP Class for you to pivot from. That Class should have a 'fieldset' value in it. For example,
 *    in Assets, the Pivot class is "AssetModel." Do this with a protected variable $custom_field_pivot_class.
 * 3. declare a string name for a pivot ID - this should be the the ID that will pivot you over to your Pivot class.
 *    For Assets, that's "model_id" (as a string).
 * 
 * 
 * So here's a Gotcha of sorts. Most things, like Accessories and Users and whatever the hell else you want, will pivot
 * off of categories. So it's:
 * 
 * Accessories->categories->custom_fieldset
 * But it'd be:
 * Assets->models->custom_fieldset
 * Honestly I guess it's not that weird.
 * Assets gets the Customizable trait.
 * Models gets the morphTo() or whatever (for default values)
 * As well as the fieldset() relationship.
 * Yeah that's not even that bad.
 * 
 * Okay, to restate, here's what you've gotta do:
 * add Customizable (which I shoudl totally rename this to) to the thing that you want to have custom fields.
 * (do we still need the pivot stuff? maybe?)
 * Then the pivot-class, that should morphTo a fieldset
 * Oh, and if you want to use it, it should also morphMany custom_field_default_values
 * Is that it?
 */

trait Customizable
{

    // protected static function booted()
    // {
    //     //put the 'onsave' stuff _here_ ?
    //     // listen to 'saving' event (fires *BEFORE* the save?)

    //     //static::saved(function ($something) {
    //     // })

    // }

    /**
     * This handles the custom field validation for anything that is Customizable
     *
     * The temptation here would definitely be to instead have this fire on the 'saving' event, but the problem there
     * is I'm not sure whether or not the Validation fires before or after the saving event, and I'm not sure that
     * Watson Validating Trait will fire *first* or second. So we 'cheat' and instead override the save() command
     * itself.
     * 
     * Actually we might be able to do something really clever here - override $rules with rules() ?
     * Then we're not hacking the save method? TODO (note that there are weird rules with inheritance in Traits)
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