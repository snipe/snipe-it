<?php

namespace Tests\Feature\Users\Ui;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Consumable;
use App\Models\Statuslabel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class BulkDeleteUsersTest extends TestCase
{
    public function testRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('users/bulksave'), [
                'ids' => [
                    User::factory()->create()->id,
                ],
                'status_id' => Statuslabel::factory()->create()->id,
            ])
            ->assertForbidden();
    }

    public function testValidation()
    {
        // $this->markTestIncomplete();
        $user = User::factory()->create();
        Asset::factory()->assignedToUser($user)->create();

        $actor = $this->actingAs(User::factory()->editUsers()->create());

        // "ids" required
        $actor->post(route('users/bulksave'), [
            // 'ids' => [
            //     $user->id,
            // ],
            'status_id' => Statuslabel::factory()->create()->id,
        ])->assertSessionHas('error')->assertRedirect();

        // "status_id" needed when provided users have assets associated
        $actor->post(route('users/bulksave'), [
            'ids' => [
                $user->id,
            ],
            // 'status_id' => Statuslabel::factory()->create()->id,
        ])->assertSessionHas('error')->assertRedirect();
    }

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
        $this->assertActionLogCheckInEntryFor($userA, $accessoryA);
        $this->assertActionLogCheckInEntryFor($userA, $accessoryB);
        $this->assertActionLogCheckInEntryFor($userC, $accessoryA);
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
        $this->assertActionLogCheckInEntryFor($userA, $consumableA);
        $this->assertActionLogCheckInEntryFor($userA, $consumableB);
        $this->assertActionLogCheckInEntryFor($userC, $consumableA);
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

    private function assertActionLogCheckInEntryFor(User $user, Model $model): void
    {
        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkin from',
            'target_id' => $user->id,
            'target_type' => User::class,
            'note' => 'Bulk checkin items',
            'item_type' => get_class($model),
            'item_id' => $model->id,
        ]);
    }
}
