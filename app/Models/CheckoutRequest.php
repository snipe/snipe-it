<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckoutRequest extends Model
{
    //
    protected $fillable = ['user_id'];
    protected $table = 'checkout_requests';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requestedItem()
    {
        return $this->morphTo('requestable');
    }
}
