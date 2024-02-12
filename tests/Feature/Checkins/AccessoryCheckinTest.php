<?php

namespace Tests\Feature\Checkins;

use App\Models\Accessory;
use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class AccessoryCheckinTest extends TestCase
{
    use InteractsWithSettings;

    public function testCheckingInAccessoryRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('accessories.checkin.store', Accessory::factory()->checkedOut()->create()))
            ->assertForbidden();
    }

    public function testAccessoryCanBeCheckedIn()
    {
        $this->markTestIncomplete();
    }

    public function testEmailSentToUserIfSettingEnabled()
    {
        $this->markTestIncomplete();
    }

    public function testEmailNotSentToUserIfSettingDisabled()
    {
        $this->markTestIncomplete();
    }
}
