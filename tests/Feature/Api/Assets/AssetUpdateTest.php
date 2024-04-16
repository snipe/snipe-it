<?php

namespace Tests\Feature\Api\Assets;

use App\Models\Asset;
use App\Models\CustomField;
use App\Models\User;
use Tests\TestCase;

class AssetUpdateTest extends TestCase
{
    public function testEncryptedCustomFieldCanBeUpdated()
    {
        $field = CustomField::factory()->testEncrypted()->create();
        $asset = Asset::factory()->hasEncryptedCustomField($field)->create();
        $superuser = User::factory()->superuser()->create();

        //first, test that an Admin user can save the encrypted custom field
        $response = $this->actingAsForApi($superuser)
            ->patchJson(route('api.assets.update', $asset->id), [
                $field->db_column_name() => 'This is encrypted field'
            ])
            ->assertStatusMessageIs('success')
            ->assertOk()
            ->json();
        $asset->refresh();
        $this->assertEquals('This is encrypted field', \Crypt::decrypt($asset->{$field->db_column_name()}));
    }

    public function testPermissionNeededToUpdateEncryptedField()
    {
        $field = CustomField::factory()->testEncrypted()->create();
        $asset = Asset::factory()->hasEncryptedCustomField($field)->create();
        $normal_user = User::factory()->editAssets()->create();

        $asset->{$field->db_column_name()} = \Crypt::encrypt("encrypted value should not change");
        $asset->save(); //is this needed?

        //test that a 'normal' user *cannot* change the encrypted custom field
        $response = $this->actingAsForApi($normal_user)
            ->patchJson(route('api.assets.update', $asset->id), [
                $field->db_column_name() => 'Some Other Value Entirely!'
            ])
            ->assertStatusMessageIs('success')
            ->assertOk()
            ->assertMessagesAre('Asset updated successfully, but encrypted custom fields were not due to permissions')
            ->json();
        $asset->refresh();
        $this->assertEquals("encrypted value should not change", \Crypt::decrypt($asset->{$field->db_column_name()}));
    }
}
