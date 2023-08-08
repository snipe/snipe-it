<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DefaultValuesForCustomFields extends Model
{
    use HasFactory;

    protected $table = "models_custom_fields"; // FIXME

    public function pivot() {
        //should return a Model?
        return $this->belongsTo('models'); //fartsville
    }

    public function field() {
        return $this->belongsTo('custom_fields');
    }
}
