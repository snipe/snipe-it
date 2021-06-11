<?php

namespace Database\Factories;

use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManufacturerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Manufacturer::class;

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

    /**
     * Apple
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function mfgApple()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Apple',
                'url' => 'https://apple.com',
                'support_url' => 'https://support.apple.com',
                'image' => 'apple.jpg',
            ];
        });
    }

    /**
     * Microsoft
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function mfgMicrosoft()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Microsoft',
                'url' => 'https://microsoft.com',
                'support_url' => 'https://support.microsoft.com',
                'image' => 'microsoft.png',
            ];
        });
    }

    /**
     * Dell
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function mfgDell()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Dell',
                'url' => 'https://dell.com',
                'support_url' => 'https://support.dell.com',
                'image' => 'dell.png',
            ];
        });
    }

    /**
     * ASUS
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function mfgAsus()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Asus',
                'url' => 'https://asus.com',
                'support_url' => 'https://support.asus.com',
                'image' => 'asus.png',
            ];
        });
    }

    /**
     * HP
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function mfgHp()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'HP',
                'url' => 'https://hp.com',
                'support_url' => 'https://support.hp.com',
                'image' => 'hp.png',
            ];
        });
    }

    /**
     * Lenovo
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function mfgLenovo()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Lenovo',
                'url' => 'https://lenovo.com',
                'support_url' => 'https://support.lenovo.com',
                'image' => 'lenovo.jpg',
            ];
        });
    }

    /**
     * LG
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function mfgLg()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'LG',
                'url' => 'https://lg.com',
                'support_url' => 'https://support.lg.com',
                'image' => 'lg.jpg',
            ];
        });
    }

    /**
     * Polycom
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function mfgPolycom()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Polycom',
                'url' => 'https://polycom.com',
                'support_url' => 'https://support.polycom.com',
                'image' => 'polycom.png',
            ];
        });
    }

    /**
     * Adobe
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function mfgAdobe()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Adobe',
                'url' => 'https://adobe.com',
                'support_url' => 'https://support.adobe.com',
                'image' => 'adobe.jpg',
            ];
        });
    }

    /**
     * Avery
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function mfgAvery()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Avery',
                'url' => 'https://avery.com',
                'support_url' => 'https://support.avery.com',
                'image' => 'avery.png',
            ];
        });
    }

    /**
     * Crucial
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function mfgCrucial()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Crucial',
                'url' => 'https://crucial.com',
                'support_url' => 'https://support.crucial.com',
                'image' => 'crucial.jpg',
            ];
        });
    }
}
