<?php
use App\Models\Asset;
use App\Models\License;
use App\Models\LicenseModel;
use App\Models\User;

class CheckoutTest extends BaseTest
{
    /**
    * @var \UnitTester
    */
    protected $tester;

    public function testAnAssetCanBeCheckedOutToAUser()
    {
        $asset = $this->createValidAsset([
            'location_id' => $this->createValidLocation()->id
        ]);
        $user = $this->signIn();
        $user->update(['location_id' => $this->createValidLocation()->id]);
        $asset->checkOut($user);

        $this->tester->seeRecord('checkouts',[
            'item_id' => $asset->id,
            'item_type' => Asset::class,
            'target_id' => $user->id,
            'target_type' => User::class
        ]);

        $this->assertTrue($user->is($asset->checkoutTarget()->target));
        $this->assertTrue($user->location->is($asset->checkoutTarget()->location));
        $this->tester->seeNumRecords(1, 'checkouts');
    }

    public function testALicenseCanBeCheckedOutToAUser()
    {

        $licenseModel = factory(LicenseModel::class)->states('office')->create([
            'category_id' => $this->createValidCategory('license-office-category')
        ]);
//        dd($licenseModel);
        $user = $this->signIn();
        $user->update(['location_id' => $this->createValidLocation()->id]);
        $license = $licenseModel->licenses()->first();
        $license->checkOut($user);

        $this->tester->seeRecord('checkouts',[
            'item_id' => $licenseModel->id,
            'item_type' => License::class,
            'target_id' => $user->id,
            'target_type' => User::class
        ]);

        $this->assertTrue($user->is($license->checkoutTarget()->target));
        $this->assertTrue($user->location->is($license->checkoutTarget()->location));
        $this->tester->seeNumRecords(1, 'checkouts');
    }


}
