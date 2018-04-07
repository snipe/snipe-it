<?php

namespace App\Models;


class Insurance extends Agreement
{
    public function __construct($attributes = []) {
        parent::__construct($attributes);
        $this->table = "insurance";

        $this->rules = array_merge($this->rules, ["policy" => "string", "policy_number"=>"string"]);
    }

}