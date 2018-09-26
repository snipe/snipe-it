<?php
namespace App\Models\Recipients;

use App\Models\Setting;

class AlertRecipient extends Recipient{

    public function __construct(string $email)
    {
        $this->email = trim($email);
    }

}
