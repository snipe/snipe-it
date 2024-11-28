<?php

declare(strict_types=1);

namespace App\Importer;

class MimeTypes
{
    /**
     * The mime types supported for import file.
     */
    public const VALID = [
        'application/vnd.ms-excel',
        'text/csv',
        'application/csv',
        'text/plain',
        'text/comma-separated-values',
    ];
}
