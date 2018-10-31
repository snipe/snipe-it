<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SnipeItPivot extends Pivot
{
    
    use ValidatingTrait;
    public $rules = [];
}