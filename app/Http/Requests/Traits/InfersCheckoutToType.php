<?php

namespace App\Http\Requests\Traits;

trait InfersCheckoutToType
{
    /**
     * When the client omits checkout_to_type, infer it from whichever
     * assigned_* target field was populated. Ambiguous requests (more than
     * one assigned_* field filled) are left alone so validation can catch
     * them downstream.
     */
    protected function inferCheckoutToType(): void
    {
        if ($this->filled('checkout_to_type')) {
            return;
        }

        $filledTargets = array_keys(array_filter([
            'location' => $this->filled('assigned_location'),
            'asset' => $this->filled('assigned_asset'),
            'user' => $this->filled('assigned_user'),
        ]));

        if (count($filledTargets) === 1) {
            $this->merge(['checkout_to_type' => $filledTargets[0]]);
        }
    }
}
