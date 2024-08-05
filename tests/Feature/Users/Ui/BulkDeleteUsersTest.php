<?php

namespace Tests\Feature\Users\Ui;

use App\Models\Accessory;
use App\Models\Consumable;
use App\Models\Statuslabel;
use App\Models\User;
use Tests\TestCase;

class BulkDeleteUsersTest extends TestCase
{
    public function testAccessoryCheckinsAreProperlyLogged()
    {
        [$accessoryA, $accessoryB] = Accessory::factory()->count(2)->create();
        [$userA, $userB, $userC] = User::factory()->count(3)->create();

        // Add checkouts for multiple accessories to multiple users to get different ids in the mix
        $this->attachAccessoryToUsers($accessoryA, [$userA, $userB, $userC]);
        $this->attachAccessoryToUsers($accessoryB, [$userA, $userB]);

        $this->actingAs(User::factory()->editUsers()->create())
            ->post(route('users/bulksave'), [
                'ids' => [
                    $userA->id,
                    $userC->id,
                ],
                'status_id' => Statuslabel::factory()->create()->id,
            ])
            ->assertRedirect();

        // These assertions check against a bug where the wrong value from
        // accessories_users was being populated in action_logs.item_id.
        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkin from',
            'target_id' => $userA->id,
            'target_type' => User::class,
            'note' => 'Bulk checkin items',
            'item_type' => Accessory::class,
            'item_id' => $accessoryA->id,
        ]);

        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkin from',
            'target_id' => $userA->id,
            'target_type' => User::class,
            'note' => 'Bulk checkin items',
            'item_type' => Accessory::class,
            'item_id' => $accessoryB->id,
        ]);

        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkin from',
            'target_id' => $userC->id,
            'target_type' => User::class,
            'note' => 'Bulk checkin items',
            'item_type' => Accessory::class,
            'item_id' => $accessoryA->id,
        ]);
    }

    public function testConsumableCheckinsAreProperlyLogged()
    {
        [$consumableA, $consumableB] = Consumable::factory()->count(2)->create();
        [$userA, $userB, $userC] = User::factory()->count(3)->create();

        // Add checkouts for multiple consumables to multiple users to get different ids in the mix
        $this->attachConsumableToUsers($consumableA, [$userA, $userB, $userC]);
        $this->attachConsumableToUsers($consumableB, [$userA, $userB]);

        $this->actingAs(User::factory()->editUsers()->create())
            ->post(route('users/bulksave'), [
                'ids' => [
                    $userA->id,
                    $userC->id,
                ],
                'status_id' => Statuslabel::factory()->create()->id,
            ])
            ->assertRedirect();

        // These assertions check against a bug where the wrong value from
        // consumables_users was being populated in action_logs.item_id.
        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkin from',
            'target_id' => $userA->id,
            'target_type' => User::class,
            'note' => 'Bulk checkin items',
            'item_type' => Consumable::class,
            'item_id' => $consumableA->id,
        ]);

        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkin from',
            'target_id' => $userA->id,
            'target_type' => User::class,
            'note' => 'Bulk checkin items',
            'item_type' => Consumable::class,
            'item_id' => $consumableB->id,
        ]);

        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkin from',
            'target_id' => $userC->id,
            'target_type' => User::class,
            'note' => 'Bulk checkin items',
            'item_type' => Consumable::class,
            'item_id' => $consumableA->id,
        ]);
    }

    private function attachAccessoryToUsers(Accessory $accessory, array $users): void
    {
        foreach ($users as $user) {
            $accessory->users()->attach($accessory->id, [
                'accessory_id' => $accessory->id,
                'assigned_to' => $user->id,
            ]);
        }
    }

    private function attachConsumableToUsers(Consumable $consumable, array $users): void
    {
        foreach ($users as $user) {
            $consumable->users()->attach($consumable->id, [
                'consumable_id' => $consumable->id,
                'assigned_to' => $user->id,
            ]);
        }
    }
}
