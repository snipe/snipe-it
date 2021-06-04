<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;



class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $password = bcrypt('password');
        return [
            'activated' => 1,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'company_id' => rand(1,4),
            'country' => $this->faker->country,
            //'department_id' => rand(1,6),
            'email' => $this->faker->safeEmail,
            'employee_num' => $this->faker->numberBetween(3500, 35050),
            'first_name' => $this->faker->firstName,
            'jobtitle' => $this->faker->jobTitle,
            'last_name' => $this->faker->lastName,
            'locale' => $this->faker->locale,
            'location_id' => rand(1,5),
            'notes' => 'Created by DB seeder',
            'password' => $password,
            'permissions' => '{"user":"0"}',
            'phone' => $this->faker->phoneNumber,
            'state' => $this->faker->stateAbbr,
            'username' => $this->faker->username,
            'zip' => $this->faker->postcode,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }


    /**
     * Generated a generic 'admin' superuser
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function firstAdmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'username' => 'admin',
                'permissions' => '{"superuser":"1"}',
            ];
        });
    }


    /**
     * Generated a generic 'snipe' superuser
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function snipeAdmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'first_name' => 'Snipe E.',
                'last_name' => 'Head',
                'username' => 'snipe',
                'email' => 'snipe@snipe.net',
                'permissions' => '{"superuser":"1"}',
            ];
        });
    }

    /**
     * Sets a superuser state
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function superUserRole()
    {
        return $this->state(function (array $attributes) {
            return [
                'permissions' => '{"superuser":"1"}',
            ];
        });
    }

    /**
     * Sets an admin role state
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function adminRole()
    {
        return $this->state(function (array $attributes) {
            return [
                'permissions' => '{"admin":"1"}',
                'manager_id' => rand(1,2),
            ];
        });
    }

    /**
     * Sets a view-assets role state
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function viewAssetsRole()
    {
        return $this->state(function (array $attributes) {
            return [
                'permissions' => '{"assets.view":"1"}',
            ];
        });
    }

    /**
     * Sets a create-assets role state
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function createAssetsRole()
    {
        return $this->state(function (array $attributes) {
            return [
                'permissions' => '{"assets.create":"1"}',
            ];
        });
    }



}

