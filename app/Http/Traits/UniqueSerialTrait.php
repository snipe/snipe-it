<?php

namespace App\Http\Traits;

use App\Models\Setting;

trait UniqueSerialTrait
{
    /**
     * Prepare a unique_ids rule, adding a model identifier if required.
     *
     * @param array  $parameters
     * @param string $field
     *
     * @return string
     */
    protected function prepareUniqueSerialRule($parameters, $field)
    {
        if ($settings = Setting::getSettings()) {
            if ($settings->unique_serial == '1') {
                return 'unique_undeleted:'.$this->table.','.$this->getKey();
            }
        }
    }
}
