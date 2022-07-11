<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckinAcceptance extends Model
{
    use SoftDeletes;

    protected $casts = [
        'returned_at' => 'datetime',
        'declined_at' => 'datetime',
    ];

    /**
     * The resource that was is out
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function checkinable()
    {
        return $this->morphTo();
    }

    /**
     * Is this checkout acceptance pending?
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->accepted_at == null && $this->declined_at == null;
    }

    /**
     * Was the checkinable returned by user?
     *
     * @param  User    $user
     * @return bool
     */
    public function returnedBy(User $user)
    {
        return $this->returnedBy->is($user);
    }

    /**
     * Add a record to the checkin_acceptance table ONLY.
     * Do not add stuff here that doesn't have a corresponding column in the
     * checkin_acceptances table or you'll get an error.
     *
     * @param  string $signature_filename
     */
    public function accept($signature_filename, $eula = null, $filename = null)
    {
        $this->returned_at = now();
        $this->signature_filename = $signature_filename;
        $this->stored_eula = $eula;
        $this->stored_eula_file = $filename;
        $this->save();

        /**
         * Update state for the checked in item
         */
        $this->checkinable->acceptedCheckin($this->returnedBy, $signature_filename, $filename);
    }

    /**
     * Decline the checkin acceptance
     *
     * @param  string $signature_filename
     */
    public function decline($signature_filename)
    {
        $this->declined_at = now();
        $this->signature_filename = $signature_filename;
        $this->save();

        /**
         * Update state for the checked out item
         */
        $this->checkoutable->declinedCheckin($this->assignedTo, $signature_filename);
    }

    /**
     * Filter checkin acceptences by the user
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  User    $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser(Builder $query, User $user)
    {
        return $query->where('returned_by_id', $user->id);
    }

}
