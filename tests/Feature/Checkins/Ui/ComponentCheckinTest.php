<?php

namespace Tests\Feature\Checkins\Ui;

use App\Models\Component;
use App\Models\User;
use Tests\TestCase;

class ComponentCheckinTest extends TestCase
{
    public function testCheckingInComponentRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('components.checkin.store', [
                'componentID' => Component::factory()->checkedOutToAsset()->create()->id,
            ]))
            ->assertForbidden();
    }


    public function testComponentCheckinPagePostIsRedirectedIfRedirectSelectionIsIndex()
    {
        $component = Component::factory()->checkedOutToAsset()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->from(route('components.index'))
            ->post(route('components.checkin.store', $component), [
                'redirect_option' => 'index',
                'checkin_qty' => 1,
            ])
            ->assertStatus(302)
            ->assertRedirect(route('components.index'));
    }

    public function testComponentCheckinPagePostIsRedirectedIfRedirectSelectionIsItem()
    {
        $component = Component::factory()->checkedOutToAsset()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->from(route('components.index'))
            ->post(route('components.checkin.store', $component), [
                'redirect_option' => 'item',
                'checkin_qty' => 1,
            ])
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('components.show', ['component' => $component->id]));
    }


}
