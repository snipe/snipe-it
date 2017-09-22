<?php
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testUserAdd()
    {
      $user = factory(User::class)->make();
      $values = [
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'email' => $user->email,
        'username' => $user->username,
        'password' => $user->password,
      ];

      User::create($values);
      $this->tester->seeRecord('users', $values);
    }

}
