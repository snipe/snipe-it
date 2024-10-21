<?php

namespace App\Exceptions;

use Exception;

class AssetNotRequestable extends Exception
{
    private $errorMessage = 'Asset not requestable';

    public function __construct($errorMessage = null)
    {
        $this->errorMessage = $errorMessage;

        parent::__construct($errorMessage);
    }

    public function __toString()
    {
        return is_null($this->errorMessage) ? 'This asset is not requestable.' : $this->errorMessage;
    }

    public function getTranslatedMessage()
    {
        return trans($this->errorMessage);
    }
}
