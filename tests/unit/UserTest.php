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

    // public function testUserAdd()
    // {
    //   $user = factory(User::class)->make();
    //   $values = [
    //     'first_name' => $user->first_name,
    //     'last_name' => $user->last_name,
    //     'email' => $user->email,
    //     'username' => $user->username,
    //     'password' => $user->password,
    //   ];

    //   User::create($values);
    //   $this->tester->seeRecord('users', $values);
    // }


    public function testFirstNameSplit()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_firstname = 'Natalia';
        $expected_lastname = "Allanovna Romanova-O'Shostakova";
        $user = User::generateFormattedNameFromFullName('firstname', $fullname);
        $this->assertEquals($expected_firstname, $user['first_name']);
        $this->assertEquals($expected_lastname, $user['last_name']);
    }

    public function testFirstName()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'natalia';
        $user = User::generateFormattedNameFromFullName('firstname', $fullname);
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testFirstNameDotLastName()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'natalia.allanovna-romanova-oshostakova';
        $user = User::generateFormattedNameFromFullName('firstname.lastname', $fullname);
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testLastNameFirstInitial()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'allanovna-romanova-oshostakovan';
        $user = User::generateFormattedNameFromFullName('lastnamefirstinitial', $fullname);
        $this->assertEquals($expected_username, $user['username']);
    }


    public function testFirstInitialLastName()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'nallanovna-romanova-oshostakova';
        $user = User::generateFormattedNameFromFullName('filastname', $fullname);
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testFirstInitialUnderscoreLastName()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'natalia_allanovna-romanova-oshostakova';
        $user = User::generateFormattedNameFromFullName('firstname_lastname', $fullname);
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testSingleName()
    {
        $fullname = "Natalia";
        $expected_username = 'natalia';
        $user = User::generateFormattedNameFromFullName('firstname_lastname', $fullname);
        $this->assertEquals($expected_username, $user['username']);
    }


}
