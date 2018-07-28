<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckoutAcceptance extends Model
{

	use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
    	'accepted_at',
    	'declined_at',

    	'deleted_at'
    ];

    public function checkoutable() {
    	return $this->morphTo();
    }

    public function assignedTo() {
    	return $this->belongsTo(User::class);
    }

    public function isPending() {
        return $this->accepted_at == null && $this->declined_at == null;
    }

    public function isCheckedOutTo(User $user) {
        return $this->assignedTo->is($user);
    }

    public function accept($signature_filename) {
        $this->accepted_at        = now();
        $this->signature_filename = $signature_filename;
        $this->save();

        /**
         * Update state for the checked out item
         */
        $this->checkoutable->acceptedCheckout($this->assignedTo, $signature_filename);     
    }

    public function decline($signature_filename) {
        $this->declined_at        = now();
        $this->signature_filename = $signature_filename;
        $this->save();

        /**
         * Update state for the checked out item
         */
        $this->checkoutable->declinedCheckout($this->assignedTo, $signature_filename);
    }    

    public function scopeForUser(Builder $query, User $user) {
        return $query->where('assigned_to_id', $user->id);
    }

    public function scopePending(Builder $query) {
        return $query->whereNull('accepted_at')->whereNull('declined_at');
    }
}
