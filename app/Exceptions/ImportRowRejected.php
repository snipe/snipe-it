<?php

namespace App\Exceptions;

use Exception;

/**
 * Thrown from within an importer's row-handler when a row cannot be
 * processed as submitted (typically because the resolved company or
 * location fails the FMCS membership check). The base Importer's
 * import() loop catches this, records the row as errored, surfaces
 * the message to the wizard's error table, and continues with the
 * next row.
 */
class ImportRowRejected extends Exception
{
    public function __construct(
        public readonly string $field,
        string $message,
    ) {
        parent::__construct($message);
    }
}
