<?php

namespace Tests\Feature\Api\Consumables;

use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class ConsumableCheckoutTest extends TestCase
{
    use InteractsWithSettings;

    public function testCheckingOutConsumableRequiresCorrectPermission()
    {
        $this->markTestIncomplete();
    }

    public function testValidationWhenCheckingOutConsumable()
    {
        $this->markTestIncomplete();
    }

    public function testConsumableMustBeAvailableWhenCheckingOut()
    {
        $this->markTestIncomplete();
    }

    public function testConsumableCanBeCheckedOut()
    {
        $this->markTestIncomplete();
    }

    public function testUserSentNotificationUponCheckout()
    {
        $this->markTestIncomplete();
    }

    public function testActionLogCreatedUponCheckout()
    {
        $this->markTestIncomplete();
    }
}
