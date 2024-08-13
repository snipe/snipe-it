<?php

namespace Tests\Feature\Console;

use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

class FixupAssignedToAssignedTypeTest extends TestCase
{
    public function testEmptyAssignedType()
    {
        $this->markTestIncomplete();
        $asset = Asset::factory()->create();
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $asset->checkOut($user, $admin);
        $asset->assigned_type=null; //blank out the assigned type
        $asset->save();
        print "Okay we set everything up~!!!\n";

        $output = $this->artisan('snipeit:assigned-to-fixup --debug')->assertExitCode(0);
        print "artisan ran!\n";
        dump($output);
        $asset = Asset::find($asset->id);
        print "\n we refreshed the asset?";
        dump($asset);
        $this->assertEquals(User::class, $asset->assigned_type);
    }

    public function testInvalidAssignedTo()
    {
        $this->markTestIncomplete();
        $asset = Asset::factory()->create();
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $asset->checkOut($user, $admin);
//        $asset->checkIn($user, $admin); //no such method btw
        $asset->assigned_type=null;
        $asset->assigned_to=null;
        $asset->saveOrFail(); //*should* generate a 'checkin'?

        $asset->assigned_to=$user->id; //incorrectly mark asset as partially checked-out
        $asset->saveOrFail();
        print "Okay we set everything up for test TWO~!!!\n";

        $output = $this->artisan('snipeit:assigned-to-fixup --debug')->assertExitCode(0);
        print "artisan ran TWO!\n";
        dump($output);
        $asset = Asset::find($asset->id);
        print "\n we refreshed the asset?";
        dump($asset);
        $this->assertNull($asset->assigned_to);
    }
}
