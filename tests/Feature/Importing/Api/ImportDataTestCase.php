<?php

namespace Tests\Feature\Importing\Api;

use Tests\TestCase;
use Illuminate\Testing\TestResponse;

abstract class ImportDataTestCase extends TestCase
{
    protected function importFileResponse(array $parameters = []): TestResponse
    {
        return $this->postJson(route('api.imports.importFile', $parameters), $parameters);
    }
}
