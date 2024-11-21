<?php

namespace Tests\Feature\CustomFieldsets\Api;

use App\Models\Asset;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use App\Models\User;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class DeleteCustomFieldsetsTest extends TestCase implements TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $customFieldset = CustomFieldset::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->deleteJson(route('api.fieldsets.destroy', $customFieldset))
            ->assertForbidden();

        $this->assertDatabaseHas('custom_fieldsets', ['id' => $customFieldset->id]);
    }

    public function testCannotDeleteCustomFieldsetWithAssociatedFields()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $customField = CustomField::factory()->create();
        $customFieldset = CustomFieldset::factory()->create();

        $customField->fieldset()->attach($customFieldset, ['order' => 1, 'required' => 'false']);

        $this->actingAsForApi(User::factory()->deleteCustomFieldsets()->create())
            ->deleteJson(route('api.fieldsets.destroy', $customFieldset))
            ->assertStatusMessageIs('error');

        $this->assertDatabaseHas('custom_fieldsets', ['id' => $customFieldset->id]);
    }

    public function testCannotDeleteCustomFieldsetWithAssociatedModels()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $asset = Asset::factory()->withComplicatedCustomFields()->create();
        //$customFieldset = CustomFieldset::factory()->hasModels()->create(); //FIXME - never going to work; that factory doesn't exist. Não bem.
        //$customFieldset = CustomFieldset::customizables()->first(); //($asset->model_id, Asset::class);
        $customFieldset = $asset->model->fieldset;

        $this->actingAsForApi(User::factory()->deleteCustomFieldsets()->create())
            ->deleteJson(route('api.fieldsets.destroy', $customFieldset))
            ->assertStatusMessageIs('error');

        $this->assertDatabaseHas('custom_fieldsets', ['id' => $customFieldset->id]);
    }

    public function testCanDeleteCustomFieldsets()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $customFieldset = CustomFieldset::factory()->create();

        $this->actingAsForApi(User::factory()->deleteCustomFieldsets()->create())
            ->deleteJson(route('api.fieldsets.destroy', $customFieldset))
            ->assertStatusMessageIs('success');

        $this->assertDatabaseMissing('custom_fieldsets', ['id' => $customFieldset->id]);
    }
}
