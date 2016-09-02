<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckoutRequest extends Model
{
    //
    protected $fillable = ['user_id'];
    protected $table = 'checkout_requests';
}
