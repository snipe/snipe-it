<?php

namespace App\Models;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SnipeModel extends Model
{

    /**
     * @param $value
     */
    public function setPurchaseCostAttribute($value)
    {
        $value =  Helper::ParseFloat($value);
        if ($value == '0.0') {
            $value = null;
        }
        $this->attributes['purchase_cost'] = $value;
        return;
    }


    //
    public function getDisplayNameAttribute()
    {
        return $this->name;
    }
}
