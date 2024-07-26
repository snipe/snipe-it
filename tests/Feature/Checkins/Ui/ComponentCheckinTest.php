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


}
