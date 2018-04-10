<?php

namespace App\Models;


class Insurance extends Agreement
{
    private function getAffectedAsset() {
        return [];
    }
    public function __construct($attributes = []) {
        parent::__construct($attributes);
        $this->table = "insurance";

        $this->rules = array_merge($this->rules, ["policy" => "string", "policy_number"=>"string"]);
    }

    public function getAffected($type = "asset") {
        $data = [];
        switch($type) {
            case "asset":
                $data = $this->getAffectedAsset();
                break;
        }
    }

}