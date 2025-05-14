<?php

namespace Tests\Feature\Notifications\Email;

use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group('notifications')]
class EmailNotificationsUponCheckoutTest extends TestCase
{
    public function testAdminCCEmailStillSentWhenCategoryEmailIsNotSetToSendEmailToUser()
    {
        $this->markTestIncomplete();
    }
}
