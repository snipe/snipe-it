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

    /**
     * @todo Add more permissions.
     */
    public static function permissionsTestData(): array
    {
        return [
            '`admin`'        => ['admin'],
            '`reports.view`' => ['reports.view'],
            'only `assets` permission' => [
                'assets.view',
                'assets.create',
                'assets.edit',
                'assets.delete',
                'assets.checkout',
                'assets.checkin',
                'assets.audit',
                'assets.view.requestable',
                'assets.view.encrypted_custom_fields'
            ]
        ];
    }
}
