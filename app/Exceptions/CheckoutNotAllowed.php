<?php

namespace App\Exceptions;

use Exception;
class CheckoutNotAllowed extends Exception
{
    public function __toString()
    {
        "A checkout is not allowed under these circumstances";
    }
}
