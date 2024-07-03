<?php

namespace Tests\Feature\Users\Ui;

use App\Models\Asset;
use App\Models\User;
use App\Models\Actionlog;
use Tests\TestCase;


class MergeUserTest extends TestCase
{
    public function testAssetsAreTransferredOnUserMerge()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user_to_merge_into = User::factory()->create();

        Asset::factory()->count(3)->assignedToUser($user1)->create();
        Asset::factory()->count(3)->assignedToUser($user2)->create();
        Asset::factory()->count(3)->assignedToUser($user_to_merge_into)->create();

        $response = $this->actingAs(User::factory()->editUsers()->viewUsers()->create())
            ->post(route('users.merge.save', $user1->id),
                [
                    'ids_to_merge' => [$user1->id, $user2->id],
                    'merge_into_id' => $user_to_merge_into->id
                ])
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

        $this->followRedirects($response)->assertSee('Success');
        $this->assertNotEquals(3, $user_to_merge_into->refresh()->assets->count());
        $this->assertEquals(9, $user_to_merge_into->refresh()->assets->count());

    }

    public function testFilesAreTransferredOnUserMerge()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user_to_merge_into = User::factory()->create();

        Actionlog::factory()->count(3)->filesUploaded()->create(['item_id' => $user1->id]);
        Actionlog::factory()->count(3)->filesUploaded()->create(['item_id' => $user2->id]);
        Actionlog::factory()->count(3)->filesUploaded()->create(['item_id' => $user_to_merge_into->id]);

        $this->assertEquals(3, $user_to_merge_into->refresh()->uploads->count());

        $response = $this->actingAs(User::factory()->editUsers()->viewUsers()->create())
            ->post(route('users.merge.save', $user1->id),
                [
                    'ids_to_merge' => [$user1->id, $user2->id],
                    'merge_into_id' => $user_to_merge_into->id
                ])
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

        $this->followRedirects($response)->assertSee('Success');
        $this->assertNotEquals(3, $user_to_merge_into->refresh()->uploads->count());
        $this->assertEquals(9, $user_to_merge_into->refresh()->uploads->count());

    }

    public function testAcceptancesAreTransferredOnUserMerge()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user_to_merge_into = User::factory()->create();

        Actionlog::factory()->count(3)->acceptedSignature()->create(['target_id' => $user1->id]);
        Actionlog::factory()->count(3)->acceptedSignature()->create(['target_id' => $user2->id]);
        Actionlog::factory()->count(3)->acceptedSignature()->create(['target_id' => $user_to_merge_into->id]);

        $this->assertEquals(3, $user_to_merge_into->refresh()->acceptances->count());

        $response = $this->actingAs(User::factory()->editUsers()->viewUsers()->create())
            ->post(route('users.merge.save', $user1->id),
                [
                    'ids_to_merge' => [$user1->id, $user2->id],
                    'merge_into_id' => $user_to_merge_into->id
                ])
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

        $this->followRedirects($response)->assertSee('Success');
        $this->assertNotEquals(3, $user_to_merge_into->refresh()->acceptances->count());
        $this->assertEquals(9, $user_to_merge_into->refresh()->acceptances->count());

    }

}
