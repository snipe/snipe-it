<?php
use App\Models\Asset;
use App\Models\License;
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
        $license = factory(License::class)->states('office')->create([
            'location_id' => $this->createValidLocation()->id
        ]);
        $user = $this->signIn();
        $user->update(['location_id' => $this->createValidLocation()->id]);
        $license->checkOut($user);

        $this->tester->seeRecord('checkouts',[
            'item_id' => $license->id,
            'item_type' => Asset::class,
            'target_id' => $user->id,
            'target_type' => User::class
        ]);

        $this->assertTrue($user->is($license->checkoutTarget()->target));
        $this->assertTrue($user->location->is($license->checkoutTarget()->location));
        $this->tester->seeNumRecords(1, 'checkouts');
    }


}
