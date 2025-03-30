<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testLogsFailedLoginAttempt()
    {
        User::factory()->create(['username' => 'username_here']);

        $this->withServerVariables(['REMOTE_ADDR' => '127.0.0.100'])
            ->post('/login', [
                'username' => 'username_here',
                'password' => 'not a real password',
            ], [
                'User-Agent' => 'Some Custom User Agent',
            ]);

        $this->assertDatabaseHas('login_attempts', [
            'username' => 'username_here',
            'remote_ip' => '127.0.0.100',
            'user_agent' => 'Some Custom User Agent',
            'successful' => 0,
        ]);
    }

    public function testLogsSuccessfulLogin()
    {
        User::factory()->create(['username' => 'username_here']);

        $this->withServerVariables(['REMOTE_ADDR' => '127.0.0.100'])
            ->post('/login', [
                'username' => 'username_here',
                'password' => 'password',
            ], [
                'User-Agent' => 'Some Custom User Agent',
            ]);

        $this->assertDatabaseHas('login_attempts', [
            'username' => 'username_here',
            'remote_ip' => '127.0.0.100',
            'user_agent' => 'Some Custom User Agent',
            'successful' => 1,
        ]);
    }
}
