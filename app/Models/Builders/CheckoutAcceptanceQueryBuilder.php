<?php

namespace App\Models\Builders;

use App\Models\CheckoutAcceptance;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModel of CheckoutAcceptance
 *
 * @extends Builder<TModel>
 */
class CheckoutAcceptanceQueryBuilder extends Builder
{
    public function forUser(User $user): self
    {
        return $this->where('assigned_to_id', $user->id);
    }

    public function pending(): self
    {
        return $this->whereNull('accepted_at')->whereNull('declined_at');
    }

    public function declined(): self
    {
        return $this->whereNull('accepted_at')->whereNotNull('declined_at');
    }
}
