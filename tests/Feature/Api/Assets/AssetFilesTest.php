<?php

namespace Tests\Feature\Api\Assets;

use Tests\TestCase;
use App\Models\User;
use App\Models\Asset;

class AssetFilesTest extends TestCase
{
    public function testAssetApiAcceptsFileUpload()
    {
        // Upload a file to an asset

        // Create an asset to work with
        $asset = Asset::factory()->count(1)->create();
        //
	//// Upload a file
	//// Create a superuser to run this as
	//$this->actingAsForApi(User::factory()->superuser()->create())
        //    ->postJson(
        //       route('api.asset.files', $asset), [
        //                 'file[]' => 
    }

    public function testAssetApiListsFiles()
    {
        // List all files on an asset
        
        // Create an asset to work with
        $asset = Asset::factory()->count(1)->create();

	print($asset);

	// Create a superuser to run this as
	$user = User::factory()->superuser()->create();
	$this->actingAsForApi($user)
            ->getJson(
		    route('api.assets.files', ['asset_id' => $asset[0]["id"]]))
                ->assertOk()
		->assertJsonStructure([
                    'status',
		    'messages',
		    'payload',
		]);
    }

    public function testAssetApiDownloadsFile()
    {
        // Download a file from an asset
    }

    public function testAssetApiDeletesFile()
    {
        // Delete a file from an asset
    }
}
