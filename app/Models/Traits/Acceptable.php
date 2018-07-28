<?php

namespace App\Models\Traits;

use App\Models\Asset;
use App\Models\CustomField;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;


trait Acceptable {
    /**
     * Run after the checkout acceptance was accepted by the user
     * 
     * @param  User   $acceptedBy
     * @param  string $signature
     */
    public function acceptedCheckout(User $acceptedBy, $signature) {}

    /**
     * Run after the checkout acceptance was declined by the user
     * 
     * @param  User   $acceptedBy
     * @param  string $signature
     */ 
    public function declinedCheckout(User $declinedBy, $signature) {}
}
