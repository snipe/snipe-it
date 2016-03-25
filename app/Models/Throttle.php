<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Throttle extends Model
{

    protected $table = 'throttle';
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
}
