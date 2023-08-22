<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Watson\Validating\ValidatingTrait;

class DefaultValuesForCustomFields extends Model
{
    use HasFactory, ValidatingTrait;

    protected $rules = [
        'type' => 'required'
    ];

    public $timestamps = false;

    public function pivot() {
        //should return a Model?
        return $this->belongsTo('models'); // FIXME - fartsville
    }

    public function field() {
        return $this->belongsTo('custom_fields');
    }

    // TODO: might be getting overly-fancy here; maybe just want to do an ID?
    public function scopeForPivot(Builder $query, Model $item, string $class) {
        return $query->where('item_pivot_id', $item->id)->where('type', $class); //FIXME - test.
    }
}
