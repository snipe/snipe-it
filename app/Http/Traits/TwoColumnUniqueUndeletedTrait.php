<?php

namespace App\Http\Traits;

trait TwoColumnUniqueUndeletedTrait
{
    /**
     * Prepare a unique_ids rule, adding a model identifier if required.
     *
     * @param  array  $parameters
     * @param  string $field
     * @return string
     */
    protected function prepareTwoColumnUniqueUndeletedRule($parameters, $field)
    {
        $column = $parameters[0];
        $value = $this->{$parameters[0]};

        if ($this->exists) {
            return 'two_column_unique_undeleted:'.$this->table.','.$this->getKey().','.$column.','.$value;
        }

        return 'two_column_unique_undeleted:'.$this->table.',0,'.$column.','.$value;
    }
}
