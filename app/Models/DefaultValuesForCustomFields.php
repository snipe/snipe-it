<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
}
