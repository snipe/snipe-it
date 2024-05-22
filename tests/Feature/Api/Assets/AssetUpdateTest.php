<?php

namespace Tests\Feature\Api\Assets;

use App\Models\Asset;
use App\Models\CustomField;
use App\Models\User;
use App\Models\Location;
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

    public function testCheckoutToUserOnAssetUpdate()
    {
        $asset = Asset::factory()->create();
        $user = User::factory()->editAssets()->create();
        $assigned_user = User::factory()->create();

        $response = $this->actingAsForApi($user)
            ->patchJson(route('api.assets.update', ['hardware' => $asset->id]), [
                'assigned_user' => $assigned_user->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

        $asset->refresh();
        $this->assertEquals($assigned_user->id, $asset->assigned_to);
        $this->assertEquals($asset->assigned_type, 'App\Models\User');
    }

    public function testCheckoutToDeletedUserFailsOnAssetUpdate()
    {
        $asset = Asset::factory()->create();
        $user = User::factory()->editAssets()->create();
        $assigned_user = User::factory()->deleted()->create();

        $this->actingAsForApi($user)
            ->patchJson(route('api.assets.update', ['hardware' => $asset->id]), [
                'assigned_user' => $assigned_user->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->json();

        $asset->refresh();
        $this->assertNull($asset->assigned_to);
        $this->assertNull($asset->assigned_type);
    }

    public function testCheckoutToLocationOnAssetUpdate()
    {
        $asset = Asset::factory()->create();
        $user = User::factory()->editAssets()->create();
        $assigned_location = Location::factory()->create();

        $this->actingAsForApi($user)
            ->patchJson(route('api.assets.update', ['hardware' => $asset->id]), [
                'assigned_location' => $assigned_location->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

        $asset->refresh();
        $this->assertEquals($assigned_location->id, $asset->assigned_to);
        $this->assertEquals($asset->assigned_type, 'App\Models\Location');

    }

    public function testCheckoutToDeletedLocationFailsOnAssetUpdate()
    {
        $asset = Asset::factory()->create();
        $user = User::factory()->editAssets()->create();
        $assigned_location = Location::factory()->deleted()->create();

        $this->actingAsForApi($user)
            ->patchJson(route('api.assets.update', ['hardware' => $asset->id]), [
                'assigned_location' => $assigned_location->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->json();

        $asset->refresh();
        $this->assertNull($asset->assigned_to);
        $this->assertNull($asset->assigned_type);
    }

    public function testCheckoutAssetOnAssetUpdate()
    {
        $asset = Asset::factory()->create();
        $user = User::factory()->editAssets()->create();
        $assigned_asset = Asset::factory()->create();

        $this->actingAsForApi($user)
            ->patchJson(route('api.assets.update', ['hardware' => $asset->id]), [
                'assigned_asset' => $assigned_asset->id,
                'checkout_to_type' => 'user',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->json();

        $asset->refresh();
        $this->assertEquals($assigned_asset->id, $asset->assigned_to);
        $this->assertEquals($asset->assigned_type, 'App\Models\Asset');

    }

    public function testCheckoutToDeletedAssetFailsOnAssetUpdate()
    {
        $asset = Asset::factory()->create();
        $user = User::factory()->editAssets()->create();
        $assigned_asset = Asset::factory()->deleted()->create();

        $this->actingAsForApi($user)
            ->patchJson(route('api.assets.update', ['hardware' => $asset->id]), [
                'assigned_asset' => $assigned_asset->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->json();

        $asset->refresh();
        $this->assertNull($asset->assigned_to);
        $this->assertNull($asset->assigned_type);
    }
    

}
