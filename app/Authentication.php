<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Authentication extends Model
{
    /**
     * @return
     */
    public function user()
    {
        return $this->belongsTo('User');
    }
}
