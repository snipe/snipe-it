<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Watson\Validating\ValidatingTrait;

class Checkout extends Model
{
    //
    use Loggable;

    protected $dates = [
        'expected_checkin',
        'checkout_at',
        'checkin_at'
    ];


//$table->unsignedInteger('item_id');
//$table->string('item_type');
//$table->unsignedInteger('target_id');
//$table->string('target_type');
//$table->unsignedInteger('location_id');
//$table->text('notes');
//$table->dateTime('expected_checkin');
//$table->dateTime('checkout_at');
//$table->dateTime('checkin_in');
    protected $itemTypeArray = [
        Asset::class,
        Accessory::class,
        Consumable::class,
        Component::class,
        LicenseModel::class
    ];
    public $rules = [
        'item_id' => 'required',
        'item_type' => 'required',
        'target_id' => 'required',
        'target_type' => 'required',
        'location_id' => 'exists:locations,id'
    ];

    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;

    protected $guarded = ['id'];

    public function item()
    {
        return $this->morphTo('item');
    }

    public function target()
    {
        return $this->morphTo('target');
    }

    public function setCheckoutAtAttribute($value)
    {
        $this->attributes['checkout_at'] = $value ?? Carbon::now();
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
