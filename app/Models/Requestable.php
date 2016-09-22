<?php

namespace App\Models;

use App\Models\CheckoutRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// $asset->requests
// $asset->isRequestedBy($user)
// $asset->whereRequestedBy($user)
trait Requestable
{

    public function requests()
    {
        return $this->morphMany(CheckoutRequest::class, 'requestable');
    }

    public function isRequestedBy(User $user)
    {
        return $this->requests()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function scopeRequestedBy($query, User $user)
    {
        return $query->whereHas('requests', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    public function request()
    {
        $this->requests()->save(
            new CheckoutRequest(['user_id' => Auth::id()])
        );
    }

    public function cancelRequest()
    {
        $this->requests()->where('user_id', Auth::id())->delete();
    }
}
