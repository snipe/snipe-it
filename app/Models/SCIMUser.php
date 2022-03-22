<?php

namespace App\Models;

class SCIMUser extends User
{
    protected $table = 'users';

    protected $throwValidationExceptions = true; // we want model-level validation to fully THROW, not just return false

    public function __construct(array $attributes = []) {
        $attributes['password'] = "*NO PASSWORD*";
        // $attributes['activated'] = 1;
        parent::__construct($attributes);
    }
}