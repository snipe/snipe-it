<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Import;
use App\Models\User;

class GeneralImportTest extends ImportDataTestCase
{
    public function testRequiresExistingImport()
    {
        $this->actingAsForApi(User::factory()->canImport()->create());

        $this->importFileResponse(['import' => 9999, 'import-type' => 'accessory'])
            ->assertStatusMessageIs('import-errors');
    }

    public function testWillReturnValidationErrorWhenImportTypeIsInvalid()
    {
        $this->actingAsForApi(User::factory()->canImport()->create());

        $import = Import::factory()->accessory()->create();

        $this->importFileResponse(['import-type' => 'foo', 'import' => $import->id])
            ->assertOk()
            ->assertJson([
                'messages' => [
                    'import-type' => [
                        'The selected import-type is invalid.'
                    ]
                ]
            ]);
    }
}
