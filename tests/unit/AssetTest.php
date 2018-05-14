<?php
use App\Exceptions\CheckoutNotAllowed;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;

class AssetTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // public function testAssetAdd()
    // {
    //     $asset = factory(Asset::class)->make();
    //     $values = [
    //         'name' => $asset->name,
    //         'model_id' => $asset->model_id,
    //         'status_id' => $asset->status_id,
    //         'asset_tag' => $asset->asset_tag,
    //     ];

    //     Asset::create($values);
    //     $this->tester->seeRecord('assets', $values);
    // }

    // public function testFailsEmptyValidation()
    // {
    //    // An Asset requires a name, a qty, and a category_id.
    //     $a = Asset::create();
    //     $this->assertFalse($a->isValid());

    //     $fields = [
    //         'model_id' => 'model id',
    //         'status_id' => 'status id',
    //         'asset_tag' => 'asset tag'
    //     ];
    //     $errors = $a->getErrors();
    //     foreach ($fields as $field => $fieldTitle) {
    //         $this->assertEquals($errors->get($field)[0], "The ${fieldTitle} field is required.");
    //     }
    // }


    public function testAutoIncrementMixed()
    {
        $expected = '123411';
        $next = Asset::nextAutoIncrement(
            collect([
                ['asset_tag' => '0012345'],
                ['asset_tag' => 'WTF00134'],
                ['asset_tag' => 'WTF-745'],
                ['asset_tag' => '0012346'],
                ['asset_tag' => '00123410'],
                ['asset_tag' => 'U8T7597h77']
            ])
        );

        \Log::debug(print_r($next));
        $this->assertEquals($expected, $next);
    }

//    public function testAutoIncrementMixedFullTagNumber()
//    {
//        $expected = '123411';
//        $next = Asset::nextAutoIncrement(
//            [
//                 ['asset_tag' => '0012345'],
//                 ['asset_tag' => 'WTF00134'],
//                 ['asset_tag' => 'WTF-745'],
//                 ['asset_tag' => '0012346'],
//                 ['asset_tag' => '00123410'],
//                 ['asset_tag' => 'U8T7597h77']
//            ]
//        );
//        $this->assertEquals($expected, $next);
//    }
//


    /**
     * @test
     */
//     public function testWarrantyExpiresAttribute()
//     {
//         $asset = factory(\App\Models\Asset::class)->create();

//         $asset->purchase_date = \Carbon\Carbon::createFromDate(2017, 1, 1)->hour(0)->minute(0)->second(0);
//         $asset->warranty_months = 24;
//         $asset->save();

//         $saved_asset = \App\Models\Asset::find($asset->id);

//         $this->tester->assertInstanceOf(\DateTime::class, $saved_asset->purchase_date);
//         $this->tester->assertEquals(
//             \Carbon\Carbon::createFromDate(2017, 1, 1)->format('Y-m-d'),
//             $saved_asset->purchase_date->format('Y-m-d')
//         );
//         $this->tester->assertEquals(
//             \Carbon\Carbon::createFromDate(2017, 1, 1)->setTime(0, 0, 0),
//             $saved_asset->purchase_date
//         );
//         $this->tester->assertEquals(24, $saved_asset->warranty_months);
//         $this->tester->assertInstanceOf(\DateTime::class, $saved_asset->warranty_expires);
//         $this->tester->assertEquals(
//             \Carbon\Carbon::createFromDate(2019, 1, 1)->format('Y-m-d'),
//             $saved_asset->warranty_expires->format('Y-m-d')
//         );
//         $this->tester->assertEquals(
//             \Carbon\Carbon::createFromDate(2019, 1, 1)->setTime(0, 0, 0),
//             $saved_asset->warranty_expires
//         );
//     }

//     public function testModelIdMustExist()
//     {
//         $model = factory(AssetModel::class)->create();
//         $asset = factory(Asset::class)->make(['model_id' => $model->id]);
//         $asset->save();
//         $this->assertTrue($asset->isValid());
//         $newId = $model->id + 1;
//         $asset = factory(Asset::class)->make(['model_id' => $newId]);
//         $asset->save();

//         $this->assertFalse($asset->isValid());
//     }

//     public function testAnAssetHasRelationships()
//     {
//         $asset = factory(Asset::class)->create();
//         $this->assertInstanceOf(AssetModel::class, $asset->model);
//         $this->assertInstanceOf(Company::class, $asset->company);
//         $this->assertInstanceOf(App\Models\Depreciation::class, $asset->depreciation);
//         $this->assertInstanceOf(App\Models\Statuslabel::class, $asset->assetstatus);
//         $this->assertInstanceOf(App\Models\Supplier::class, $asset->supplier);
//     }

//     public function testAnAssetCanBeAvailableForCheckout()
//     {
//         // Logic: If the asset is not assigned to anyone,
//         // and the statuslabel type is "deployable"
//         // and the asset is not deleted
//         // Then it is available for checkout

//         // An asset assigned to someone should not be available for checkout.
//         $user = factory(App\Models\User::class)->create();
//         $assetAssigned = factory(Asset::class)->create(['assigned_to' => $user->id]);
//         $this->assertFalse($assetAssigned->availableForCheckout());

//         // An asset with a non deployable statuslabel should not be available for checkout.
//         $status = factory(App\Models\Statuslabel::class)->states('archived')->create();
//         $assetUndeployable = factory(Asset::class)->create(['status_id' => $status->id]);
//         $this->assertFalse($assetUndeployable->availableForCheckout());

//         // An asset that has been deleted is not avaiable for checkout.
//         $assetDeleted = factory(Asset::class)->states('deleted')->create();
//         $this->assertFalse($assetDeleted->availableForCheckout());

//         // A ready to deploy asset that isn't assigned to anyone is available for checkout
//         $status = factory(App\Models\Statuslabel::class)->states('rtd')->create();
//         $asset = factory(Asset::class)->create(['status_id' => $status->id]);
//         $this->assertTrue($asset->availableForCheckout());
//     }

//     public function testAnAssetCanHaveComponents()
//     {
//         $asset = factory(Asset::class)->create();
//         $components = factory(App\Models\Component::class, 5)->create();
//         $components->each(function($component) use ($asset) {
//             $component->assets()->attach($component, [
//                 'asset_id'=>$asset->id
//             ]);
//         });
//         $this->assertInstanceOf(App\Models\Component::class, $asset->components()->first());
//         $this->assertCount(5, $asset->components);
//     }

//     public function testAnAssetCanHaveUploads()
//     {
//         $asset = factory(Asset::class)->create();
//         $this->assertCount(0, $asset->uploads);
//         factory(App\Models\Actionlog::class, 'asset-upload')->create(['item_id' => $asset->id]);
//         $this->assertCount(1, $asset->fresh()->uploads);
//     }

//     // Helper Method for checking in assets.... We should extract this to the model or a trait.

//     private function checkin($asset, $target) {
//         $asset->expected_checkin = null;
//         $asset->last_checkout = null;
//         $asset->assigned_to = null;
//         $asset->assigned_type = null;
//         $asset->assignedTo()->disassociate($asset);
//         $asset->accepted = null;
//         $asset->save();
//         $asset->logCheckin($target, 'Test Checkin');
//     }

//     public function testAnAssetCanBeCheckedOut()
//     {
//         // This tests Asset::checkOut(), Asset::assignedTo(), Asset::assignedAssets(), Asset::assetLoc(), Asset::assignedType(), defaultLoc()
//         $asset = factory(Asset::class)->create();
//         $adminUser = $this->signIn();

//         $target = factory(App\Models\User::class)->create();
//         // An Asset Can be checked out to a user, and this should be logged.
//         $asset->checkOut($target, $adminUser);
//         $asset->save();

//         $this->assertInstanceOf(App\Models\User::class, $asset->assignedTo);
//         $this->assertEquals($asset->assetLoc->id, $target->userLoc->id);
//         $this->assertEquals('user', $asset->assignedType());
//         $this->assertEquals($asset->defaultLoc->id, $asset->rtd_location_id);
//         $this->tester->seeRecord('action_logs', [
//             'action_type' => 'checkout',
//             'target_type'   => get_class($target),
//             'target_id'     => $target->id
//         ]);

//         $this->tester->seeRecord('assets', [
//             'id' => $asset->id,
//             'assigned_to' => $target->id,
//             'assigned_type' => User::class
//         ]);

//         $this->checkin($asset, $target);
//         $this->assertNull($asset->fresh()->assignedTo);

//         $this->tester->seeRecord('action_logs', [
//             'action_type' => 'checkin from',
//             'target_type'   => get_class($target),
//             'target_id'     => $target->id
//         ]);

//         $this->tester->seeRecord('assets', [
//             'id' => $asset->id,
//             'assigned_to' => null,
//             'assigned_type' => null
//         ]);

//         // An Asset Can be checked out to a asset, and this should be logged.
//         $target = factory(App\Models\Asset::class)->create();
//         $asset->checkOut($target, $adminUser);
//         $asset->save();
//         $this->assertInstanceOf(App\Models\Asset::class, $asset->fresh()->assignedTo);
//         $this->assertEquals($asset->fresh()->assetLoc->id, $target->fresh()->assetLoc->id);
//         $this->assertEquals('asset', $asset->assignedType());
//         $this->assertEquals($asset->defaultLoc->id, $asset->rtd_location_id);
//         $this->tester->seeRecord('action_logs', [
//             'action_type' => 'checkout',
//             'target_type'   => get_class($target),
//             'target_id'     => $target->id
//         ]);

//         $this->assertCount(1, $target->assignedAssets);
//         $this->checkin($asset, $target);
//         $this->assertNull($asset->fresh()->assignedTo);

//         $this->tester->seeRecord('action_logs', [
//             'action_type' => 'checkin from',
//             'target_type'   => get_class($target),
//             'target_id'     => $target->id
//         ]);

//         // An Asset Can be checked out to a location, and this should be logged.
//         $target = factory(App\Models\Location::class)->create();
//         $asset->checkOut($target, $adminUser);
//         $asset->save();
//         $this->assertInstanceOf(App\Models\Location::class, $asset->fresh()->assignedTo);
//         $this->assertEquals($asset->fresh()->assetLoc->id, $target->fresh()->id);
//         $this->assertEquals('location', $asset->assignedType());
//         $this->assertEquals($asset->defaultLoc->id, $asset->rtd_location_id);
//         $this->tester->seeRecord('action_logs', [
//             'action_type' => 'checkout',
//             'target_type'   => get_class($target),
//             'target_id'     => $target->id
//         ]);
//         $this->checkin($asset, $target);
//         $this->assertNull($asset->fresh()->assignedTo);

//         $this->tester->seeRecord('action_logs', [
//             'action_type' => 'checkin from',
//             'target_type'   => get_class($target),
//             'target_id'     => $target->id
//         ]);
//     }

//     public function testAnAssetHasMaintenances()
//     {
//         $asset = factory(Asset::class)->create();
//         factory(App\Models\AssetMaintenance::class)->create(['asset_id' => $asset->id]);
//         $this->assertCount(1, $asset->assetmaintenances);
//     }

//     public function testAnAssetThatRequiresAcceptanceCanNotBeCheckedOutToANonUser()
//     {
//         $this->expectException(CheckoutNotAllowed::class);
//         $this->signIn();

//         $asset = factory(Asset::class)->states('requires-acceptance')->create();

//         $location = factory(Location::class)->create();
//         $asset->checkOut($location);
//     }
}
