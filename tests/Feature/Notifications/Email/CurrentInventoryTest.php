<?php

namespace Tests\Feature\Notifications\Email;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Consumable;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use App\Notifications\CurrentInventory;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CurrentInventoryTest extends TestCase
{
    public function test_must_have_permission_to_send_current_inventory_email()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('users.email', User::factory()->create()->id))
            ->assertForbidden();
    }

    public function test_handles_attempt_to_send_to_user_without_email_address()
    {
        $user = User::factory()->create(['email' => null]);

        $this->actingAs(User::factory()->viewUsers()->create())
            ->post(route('users.email', $user->id))
            ->assertSessionHas('error');
    }

    public function test_can_send_users_current_inventory()
    {
        Notification::fake();

        $user = User::factory()->create(['email' => 'hi@there.com']);

        Asset::factory()->assignedToUser($user)->create(['asset_tag' => 'complex-asset-tag']);
        Accessory::factory()->checkedOutToUser($user)->create(['name' => 'Complex Accessory Name']);
        LicenseSeat::factory()->for(License::factory()->state(['name' => 'Complex License Name']))->assignedToUser($user)->create();
        Consumable::factory()->checkedOutToUser($user)->create(['name' => 'Complex Consumable Name']);

        $this->actingAs(User::factory()->viewUsers()->create())
            ->post(route('users.email', $user->id))
            ->assertSessionHas('success');

        Notification::assertCount(1);
        Notification::assertSentTo($user, function (CurrentInventory $notification) {
            $emailContents = $notification->toMail()->render();

            $this->assertStringContainsString('complex-asset-tag', $emailContents);
            $this->assertStringContainsString('Complex Accessory Name', $emailContents);
            $this->assertStringContainsString('Complex License Name', $emailContents);
            $this->assertStringContainsString('Complex Consumable Name', $emailContents);

            return true;
        });
    }
}
