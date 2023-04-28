<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \Auth;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'activated' => 1,
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'company_id' => rand(1, 4),
            'country' => $this->faker->country(),
            'department_id' => rand(1, 6),
            'email' => $this->faker->safeEmail,
            'employee_num' => $this->faker->numberBetween(3500, 35050),
            'first_name' => $this->faker->firstName(),
            'jobtitle' => $this->faker->jobTitle(),
            'last_name' => $this->faker->lastName(),
            'locale' => 'en',
            'notes' => 'Created by DB seeder',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'permissions' => '{"user":"0"}',
            'phone' => $this->faker->phoneNumber,
            'state' => $this->faker->stateAbbr,
            'username' => $this->faker->username,
            'zip' => $this->faker->postcode,
        ];
    }
    
    public function firstAdmin()
    {
        return $this->state(function () {
            return [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'username' => 'admin',
                'avatar' => '1.jpg',
                'permissions' => '{"superuser":"1"}',
            ];
        });
    }

    public function snipeAdmin()
    {
        return $this->state(function () {
            return [
                'first_name' => 'Snipe E.',
                'last_name' => 'Head',
                'username' => 'snipe',
                'avatar' => '2.jpg',
                'email' => 'snipe@snipe.net',
                'permissions' => '{"superuser":"1"}',
            ];
        });
    }

    public function superuser()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"superuser":"1"}',
            ];
        });
    }

    public function admin()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"admin":"1"}',
                'manager_id' => rand(1, 2),
            ];
        });
    }

    public function viewAssets()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"assets.view":"1"}',
            ];
        });
    }

    public function createAssets()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"assets.create":"1"}',
            ];
        });
    }

    public function editAssets()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"assets.edit":"1"}',
            ];
        });
    }

    public function deleteAssets()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"assets.delete":"1"}',
            ];
        });
    }

    public function checkinAssets()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"assets.checkin":"1"}',
            ];
        });
    }

    public function checkoutAssets()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"assets.checkout":"1"}',
            ];
        });
    }

    public function viewRequestableAssets()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"assets.view.requestable":"1"}',
            ];
        });
    }

    public function viewAccessories()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"accessories.view":"1"}',
            ];
        });
    }

    public function createAccessories()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"accessories.create":"1"}',
            ];
        });
    }

    public function editAccessories()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"accessories.edit":"1"}',
            ];
        });
    }

    public function deleteAccessories()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"accessories.delete":"1"}',
            ];
        });
    }

    public function checkinAccessories()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"accessories.checkin":"1"}',
            ];
        });
    }

    public function checkoutAccessories()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"accessories.checkout":"1"}',
            ];
        });
    }

    public function viewConsumables()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"consumables.view":"1"}',
            ];
        });
    }

    public function createConsumables()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"consumables.create":"1"}',
            ];
        });
    }

    public function editConsumables()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"consumables.edit":"1"}',
            ];
        });
    }

    public function deleteConsumables()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"consumables.delete":"1"}',
            ];
        });
    }

    public function checkinConsumables()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"consumables.checkin":"1"}',
            ];
        });
    }

    public function checkoutConsumables()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"consumables.checkout":"1"}',
            ];
        });
    }

    public function viewLicenses()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"licenses.view":"1"}',
            ];
        });
    }

    public function createLicenses()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"licenses.create":"1"}',
            ];
        });
    }

    public function editLicenses()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"licenses.edit":"1"}',
            ];
        });
    }

    public function deleteLicenses()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"licenses.delete":"1"}',
            ];
        });
    }

    public function checkoutLicenses()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"licenses.checkout":"1"}',
            ];
        });
    }

    public function viewKeysLicenses()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"licenses.keys":"1"}',
            ];
        });
    }

    public function viewComponents()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"components.view":"1"}',
            ];
        });
    }

    public function createComponents()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"components.create":"1"}',
            ];
        });
    }

    public function editComponents()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"components.edit":"1"}',
            ];
        });
    }

    public function deleteComponents()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"components.delete":"1"}',
            ];
        });
    }

    public function checkinComponents()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"components.checkin":"1"}',
            ];
        });
    }

    public function checkoutComponents()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"components.checkout":"1"}',
            ];
        });
    }

    public function viewUsers()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"users.view":"1"}',
            ];
        });
    }

    public function createUsers()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"users.create":"1"}',
            ];
        });
    }

    public function editUsers()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"users.edit":"1"}',
            ];
        });
    }

    public function deleteUsers()
    {
        return $this->state(function () {
            return [
                'permissions' => '{"users.delete":"1"}',
            ];
        });
    }

}
