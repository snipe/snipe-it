<?php

namespace App\Models\Builders;

use App\Enums\CheckoutRequestState;
use Illuminate\Database\Eloquent\Builder;

class CheckoutRequestQueryBuilder extends Builder
{
    public function open(): static
    {
        return $this->where('state', CheckoutRequestState::Pending->value);
    }

    public function pending(): static
    {
        return $this->where('state', CheckoutRequestState::Pending->value);
    }

    public function fulfilled(): static
    {
        return $this->where('state', CheckoutRequestState::Fulfilled->value);
    }

    public function canceled(): static
    {
        return $this->where('state', CheckoutRequestState::Canceled->value);
    }
}
