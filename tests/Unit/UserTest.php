<?php
namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testFirstNameSplit()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_firstname = 'Natalia';
        $expected_lastname = "Allanovna Romanova-O'Shostakova";
        $user = User::generateFormattedNameFromFullName($fullname, 'firstname');
        $this->assertEquals($expected_firstname, $user['first_name']);
        $this->assertEquals($expected_lastname, $user['last_name']);
    }

    public function testFirstName()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'natalia';
        $user = User::generateFormattedNameFromFullName($fullname, 'firstname');
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testFirstNameDotLastName()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'natalia.allanovna-romanova-oshostakova';
        $user = User::generateFormattedNameFromFullName($fullname, 'firstname.lastname');
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testLastNameFirstInitial()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'allanovna-romanova-oshostakovan';
        $user = User::generateFormattedNameFromFullName($fullname, 'lastnamefirstinitial');
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testFirstInitialLastName()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'nallanovna-romanova-oshostakova';
        $user = User::generateFormattedNameFromFullName($fullname, 'filastname');
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testFirstInitialUnderscoreLastName()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'nallanovna-romanova-oshostakova';
        $user = User::generateFormattedNameFromFullName($fullname, 'firstinitial_lastname');
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testSingleName()
    {
        $fullname = 'Natalia';
        $expected_username = 'natalia';
        $user = User::generateFormattedNameFromFullName($fullname, 'firstname_lastname',);
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testFirstInitialDotLastname()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'nallanovna-romanova-oshostakova';
        $user = User::generateFormattedNameFromFullName($fullname, 'firstinitial.lastname');
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testLastNameDotFirstInitial()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'allanovna-romanova-oshostakova.n';
        $user = User::generateFormattedNameFromFullName($fullname, 'lastname.firstinitial');
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testLastNameUnderscoreFirstInitial()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'allanovna-romanova-oshostakova_n';
        $user = User::generateFormattedNameFromFullName($fullname, 'lastname_firstinitial');
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testFirstNameLastName()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'nataliaallanovna-romanova-oshostakova';
        $user = User::generateFormattedNameFromFullName($fullname, 'firstnamelastname');
        $this->assertEquals($expected_username, $user['username']);
    }

    public function testFirstNameLastInitial()
    {
        $fullname = "Natalia Allanovna Romanova-O'Shostakova";
        $expected_username = 'nataliaa';
        $user = User::generateFormattedNameFromFullName($fullname, 'firstnamelastinitial');
        $this->assertEquals($expected_username, $user['username']);
    }
}
