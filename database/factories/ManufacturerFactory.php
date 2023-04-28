<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/*
|--------------------------------------------------------------------------
| Asset Model Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating models ..
|
*/

// 1

// 2

// 3

// 4

// 5

// 6

// 7

// 8

// 9

// 10

// 11

class ManufacturerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Manufacturer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'support_phone' => $this->faker->phoneNumber(),
            'url' => $this->faker->url(),
            'support_email' => $this->faker->safeEmail(),
        ];
    }

    public function apple()
    {
        return $this->state(function () {
            return [
                'name' => 'Apple',
                'url' => 'https://apple.com',
                'support_url' => 'https://support.apple.com',
                'image' => 'apple.jpg',
            ];
        });
    }

    public function microsoft()
    {
        return $this->state(function () {
            return [
                'name' => 'Microsoft',
                'url' => 'https://microsoft.com',
                'support_url' => 'https://support.microsoft.com',
                'image' => 'microsoft.png',
            ];
        });
    }

    public function dell()
    {
        return $this->state(function () {
            return [
                'name' => 'Dell',
                'url' => 'https://dell.com',
                'support_url' => 'https://support.dell.com',
                'image' => 'dell.png',
            ];
        });
    }

    public function asus()
    {
        return $this->state(function () {
            return [
                'name' => 'Asus',
                'url' => 'https://asus.com',
                'support_url' => 'https://support.asus.com',
                'image' => 'asus.png',
            ];
        });
    }

    public function hp()
    {
        return $this->state(function () {
            return [
                'name' => 'HP',
                'url' => 'https://hp.com',
                'support_url' => 'https://support.hp.com',
                'image' => 'hp.png',
            ];
        });
    }

    public function lenovo()
    {
        return $this->state(function () {
            return [
                'name' => 'Lenovo',
                'url' => 'https://lenovo.com',
                'support_url' => 'https://support.lenovo.com',
                'image' => 'lenovo.jpg',
            ];
        });
    }

    public function lg()
    {
        return $this->state(function () {
            return [
                'name' => 'LG',
                'url' => 'https://lg.com',
                'support_url' => 'https://support.lg.com',
                'image' => 'lg.jpg',
            ];
        });
    }

    public function polycom()
    {
        return $this->state(function () {
            return [
                'name' => 'Polycom',
                'url' => 'https://polycom.com',
                'support_url' => 'https://support.polycom.com',
                'image' => 'polycom.png',
            ];
        });
    }

    public function adobe()
    {
        return $this->state(function () {
            return [
                'name' => 'Adobe',
                'url' => 'https://adobe.com',
                'support_url' => 'https://support.adobe.com',
                'image' => 'adobe.jpg',
            ];
        });
    }

    public function avery()
    {
        return $this->state(function () {
            return [
                'name' => 'Avery',
                'url' => 'https://avery.com',
                'support_url' => 'https://support.avery.com',
                'image' => 'avery.png',
            ];
        });
    }

    public function crucial()
    {
        return $this->state(function () {
            return [
                'name' => 'Crucial',
                'url' => 'https://crucial.com',
                'support_url' => 'https://support.crucial.com',
                'image' => 'crucial.jpg',
            ];
        });
    }
}
