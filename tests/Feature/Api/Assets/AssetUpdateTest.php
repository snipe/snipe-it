<?php

namespace Tests\Feature\Api\Assets;

use App\Models\Asset;
use App\Models\CustomField;
use App\Models\Statuslabel;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class AssetUpdateTest extends TestCase
{
    public function testEncryptedCustomFieldCanBeUpdated()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $field = CustomField::factory()->testEncrypted()->create();
        $asset = Asset::factory()->hasEncryptedCustomField($field)->create();
        $superuser = User::factory()->superuser()->create();

        $this->actingAsForApi($superuser)
            ->patchJson(route('api.assets.update', $asset->id), [
                $field->db_column_name() => 'This is encrypted field'
            ])
            ->assertStatusMessageIs('success')
            ->assertOk();

        $asset->refresh();
        $this->assertEquals('This is encrypted field', Crypt::decrypt($asset->{$field->db_column_name()}));
    }

    public function testPermissionNeededToUpdateEncryptedField()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $field = CustomField::factory()->testEncrypted()->create();
        $asset = Asset::factory()->hasEncryptedCustomField($field)->create();
        $normal_user = User::factory()->editAssets()->create();

        $asset->{$field->db_column_name()} = Crypt::encrypt("encrypted value should not change");
        $asset->save();

        // test that a 'normal' user *cannot* change the encrypted custom field
        $this->actingAsForApi($normal_user)
            ->patchJson(route('api.assets.update', $asset->id), [
                $field->db_column_name() => 'Some Other Value Entirely!'
            ])
            ->assertStatusMessageIs('success')
            ->assertOk()
            ->assertMessagesAre('Asset updated successfully, but encrypted custom fields were not due to permissions');

        $asset->refresh();
        $this->assertEquals("encrypted value should not change", Crypt::decrypt($asset->{$field->db_column_name()}));
    }

    public function testCustomFieldCheckboxPassesValidationForValidOptionsWithString()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $asset = Asset::factory()->hasCustomCheckBox()->create();

        $column = CustomField::where('name', 'Test Checkbox')->first()->db_column;

        $response = $this->actingAsForApi(User::factory()->editAssets()->create())
            ->putJson(route('api.assets.update', $asset->id), [
                $column => 'One, Two, Three',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $asset = Asset::find($response['payload']['id']);

        $this->assertEquals('One, Two, Three', $asset->{$column});
    }

    public function testCustomFieldCheckboxPassesValidationForValidOptionsWithArray()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $asset = Asset::factory()->hasCustomCheckBox()->create();

        $column = CustomField::where('name', 'Test Checkbox')->first()->db_column;

        $response = $this->actingAsForApi(User::factory()->editAssets()->create())
            ->putJson(route('api.assets.update', $asset->id), [
                $column => ['One', 'Two', 'Three'],
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $asset = Asset::find($response['payload']['id']);

        // hmm, should probably look at trimming spaces when it's submitted as a string (above test)
        $this->assertEquals('One,Two,Three', $asset->{$column});
    }

    public function testCustomFieldCheckboxFailsValidationForInvalidOptionsWithString()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $asset = Asset::factory()->hasCustomCheckBox()->create();

        $column = CustomField::where('name', 'Test Checkbox')->first()->db_column;


        $this->settings->enableAutoIncrement();

        $this->actingAsForApi(User::factory()->editAssets()->create())
            ->putJson(route('api.assets.update', $asset->id), [
                $column => 'One, Two, Four, Five',
            ])
            ->assertOk()
            ->assertStatusMessageIs('error');
    }

    public function testCustomFieldCheckboxFailsValidationForInvalidOptionsWithArray()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $asset = Asset::factory()->hasCustomCheckBox()->create();

        $column = CustomField::where('name', 'Test Checkbox')->first()->db_column;


        $this->settings->enableAutoIncrement();

        $this->actingAsForApi(User::factory()->editAssets()->create())
            ->putJson(route('api.assets.update', $asset->id), [
                $column => ['One', 'Two', 'Four', 'Five'],
            ])
            ->assertOk()
            ->assertStatusMessageIs('error');
    }

    public function testEncryptedCustomFieldCheckboxPassesValidationForValidOptionsWithString()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $asset = Asset::factory()->hasCustomCheckBox(true)->create();

        $column = CustomField::where('name', 'Test Checkbox')->first()->db_column;

        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->putJson(route('api.assets.update', $asset->id), [
                $column => 'One, Two, Three',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $asset = Asset::find($response['payload']['id']);

        $this->assertEquals('One, Two, Three', Crypt::decrypt($asset->{$column}));
    }

    public function testEncryptedCustomFieldCheckboxPassesValidationForValidOptionsWithArray()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $asset = Asset::factory()->hasCustomCheckBox(true)->create();

        $column = CustomField::where('name', 'Test Checkbox')->first()->db_column;

        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->putJson(route('api.assets.update', $asset->id), [
                $column => ['One', 'Two', 'Three'],
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $asset = Asset::find($response['payload']['id']);

        // again, dumb space trimmed or not thing - i don't think it matters in real world though
        $this->assertEquals('One,Two,Three', Crypt::decrypt($asset->{$column}));
    }

    public function testEncryptedCustomFieldCheckboxFailsValidationForInvalidOptionsWithString()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $asset = Asset::factory()->hasCustomCheckBox(true)->create();

        $column = CustomField::where('name', 'Test Checkbox')->first()->db_column;

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->putJson(route('api.assets.update', $asset->id), [
                $column => 'One, Two, Four, Five',
            ])
            ->assertOk()
            ->assertStatusMessageIs('error');
    }

    public function testEncryptedCustomFieldCheckboxFailsValidationForInvalidOptionsWithArray()
    {
        $this->markIncompleteIfMySQL('Custom Fields tests do not work on MySQL');

        $asset = Asset::factory()->hasCustomCheckBox(true)->create();

        $column = CustomField::where('name', 'Test Checkbox')->first()->db_column;

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->putJson(route('api.assets.update', $asset->id), [
                $column => ['One', 'Two', 'Four', 'Five'],
            ])
            ->assertOk()
            ->assertStatusMessageIs('error');
    }
}
