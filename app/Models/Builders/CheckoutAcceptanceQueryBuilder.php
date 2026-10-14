<?php

namespace App\Models\Builders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class CheckoutAcceptanceQueryBuilder extends Builder
{
    public function forUser(User $user): static
    {
        return $this->where('assigned_to_id', $user->id);
    }

    public function pending(): static
    {
        return $this->whereNull('accepted_at')->whereNull('declined_at');
    }

    public function declined(): static
    {
        return $this->whereNull('accepted_at')->whereNotNull('declined_at');
    }
}
