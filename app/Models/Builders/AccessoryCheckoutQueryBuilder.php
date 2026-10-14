<?php

namespace App\Models\Builders;

use App\Models\Asset;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class AccessoryCheckoutQueryBuilder extends Builder
{
    public function userAssigned(): static
    {
        return $this->where('assigned_type', '=', User::class);
    }

    public function locationAssigned(): static
    {
        return $this->where('assigned_type', '=', Location::class);
    }

    public function assetsAssigned(): static
    {
        return $this->where('assigned_type', '=', Asset::class);
    }
}
