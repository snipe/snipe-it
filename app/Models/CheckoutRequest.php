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

    public function requestingUser()
    {
        return $this->user()->first();
    }

    public function requestedItem()
    {
        return $this->morphTo('requestable');
    }

    public function itemRequested() // Workaround for laravel polymorphic issue that's not being solved :(
    {
        return $this->requestedItem()->first();
    }

    public function itemType()
    {
        return snake_case(class_basename($this->requestable_type));
    }

    public function location()
    {
        if ($this->itemType() == "asset") {
            $asset = $this->itemRequested();
            if ($asset->assigneduser && $asset->assetloc) {
                return $asset->assetloc;
            } elseif ($asset->defaultLoc) {
                return $asset->defaultLoc;
            }
        }
        return $this->itemRequested()->location;
    }

    public function name()
    {
        if ($this->itemType() == "asset") {
            return $this->itemRequested()->showAssetName();
        }
        return $this->itemRequested()->name;

    }
}
