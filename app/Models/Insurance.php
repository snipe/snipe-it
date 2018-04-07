<?php

namespace App\Models;


class Insurance extends Agreement
{
    public function __construct($attributes = []) {
        parent::__construct($attributes);
        $this->table = "insurance";
    }

}