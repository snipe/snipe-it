<?php
/**
 * Created by PhpStorm.
 * User: hydrogen
 * Date: 7/29/18
 * Time: 12:36 PM
 */

namespace App\Models;


trait Checkoutable
{


    public function availableForCheckout()
    {
//        return Checkout::whereNot('item_id', $this->id)->where('checkin_at', '<=', Carbon::now())->first()
        if (
            (empty($this->assigned_to)) &&
            (empty($this->deleted_at)) &&
            (($this->assetstatus) && ($this->assetstatus->deployable == 1)))
        {
            return true;
        }
        return false;
    }

    /**
     * Checkout asset
     * @param User $user
     * @param User $admin
     * @param Carbon $checkout_at
     * @param Carbon $expected_checkin
     * @param string $note
     * @param null $name
     * @return bool
     */
    //FIXME: The admin parameter is never used. Can probably be removed.
    public function checkOut($target, $admin = null, $checkout_at = null, $expected_checkin = null, $note = null, $name = null, $location = null)
    {
        if (!$target) {
            return false;
        }

        $locationId = $this->location->id;
        if ($location != null) {
            $locationId = $location;
        } else {
            if($target->location) {
                $locationId = $target->location->id;
            }
            if($target instanceof Location) {
                $locationId = $target->id;
            }
        }

        Checkout::create([
            'item_id' => $this->id,
            'item_type' => get_class($this),
            'target_id' => $target->id,
            'target_type' => get_class($target),
            'location_id' => $locationId,
            'expected_checkin' => $expected_checkin,
            'checkout_at' => $checkout_at,
            'notes' => $note
        ]);

        $this->last_checkout = $checkout_at;

//        $this->assignedTo()->associate($target);


        if ($name != null) {
            $this->name = $name;
        }



        /**
         * Does the user have to confirm that they accept the asset?
         *
         * If so, set the acceptance-status to "pending".
         * This value is used in the unaccepted assets reports, for example
         *
         * @see https://github.com/snipe/snipe-it/issues/5772
         */
        if ($this->requireAcceptance() && $target instanceof User) {
            $this->accepted = self::ACCEPTANCE_PENDING;
        }

        if ($this->save()) {

            $this->logCheckout($note, $target);
            $this->increment('checkout_counter', 1);
            return true;
        }
        return false;
    }

    public function checkoutRelation()
    {
        return $this->morphMany(Checkout::class, 'item');
    }

    public function checkoutTarget()
    {
//        return $this->morphMany(Checkout::class, 'item');
        return $this->checkoutRelation->first();
    }
    /**
     * Even though we allow allow for checkout to things beyond users
     * this method is an easy way of seeing if we are checked out to a user.
     * @return mixed
     */
    public function checkedOutToUser()
    {
        return $this->assignedType() === self::USER;
    }

    public function assignedTo()
    {
        return $this->checkoutTarget();
    }
    public function assignedType()
    {
        return strtolower(class_basename($this->checkoutTarget()->target_type));
    }

    /**
     * Get checkouts
     */
    public function checkouts()
    {
        return $this->assetlog()->where('action_type', '=', 'checkout')
            ->orderBy('created_at', 'desc')
            ->withTrashed();
    }
}