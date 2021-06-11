<?php

namespace Database\Factories;

use App\Models\AssetModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AssetModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'model_number' => $this->faker->numberBetween(99999999, 9999999999),
            'notes' => 'Created by demo seeder',
        ];
    }

    /**
     * MBP
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelMbp13()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Macbook Pro 13"',
                'category_id' => 1,
                'manufacturer_id' => 1,
                'eol' => '36',
                'depreciation_id' => 1,
                'image' => 'mbp.jpg',
                'fieldset_id' => 2,
            ];
        });
    }

    /**
     * Macbook Air
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelAir()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Macbook Air',
                'category_id' => 1,
                'manufacturer_id' => 1,
                'eol' => '36',
                'depreciation_id' => 1,
                'image' => 'macbookair.jpg',
                'fieldset_id' => 2,

            ];
        });
    }

    /**
     * Surface
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelSurface()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Surface',
                'category_id' => 1,
                'manufacturer_id' => 2,
                'eol' => '36',
                'depreciation_id' => 1,
                'image' => 'surface.jpg',
                'fieldset_id' => 2,

            ];
        });
    }

    /**
     * XPS 13
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelXps13()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'XPS 13',
                'category_id' => 1,
                'manufacturer_id' => 3,
                'eol' => '36',
                'depreciation_id' => 1,
                'image' => 'xps.jpg',
                'fieldset_id' => 2,
            ];
        });
    }

    /**
     * Spectre
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelSpectre()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Spectre',
                'category_id' => 1,
                'manufacturer_id' => 5,
                'eol' => '36',
                'depreciation_id' => 1,
                'image' => 'spectre.jpg',
                'fieldset_id' => 2,
            ];
        });
    }

    /**
     * ZenBook UX310
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelZenbook()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'ZenBook UX310',
                'category_id' => 1,
                'manufacturer_id' => 4,
                'eol' => '36',
                'depreciation_id' => 1,
                'image' => 'zenbook.jpg',
                'fieldset_id' => 2,
            ];
        });
    }

    /**
     * Yoga 910
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelYoga()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Yoga 910',
                'category_id' => 1,
                'manufacturer_id' => 6,
                'eol' => '36',
                'depreciation_id' => 1,
                'image' => 'yoga.jpg',
                'fieldset_id' => 2,
            ];
        });
    }

    /**
     * iMac Pro
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelMacPro()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'iMac Pro',
                'category_id' => 2,
                'manufacturer_id' => 1,
                'eol' => '24',
                'depreciation_id' => 1,
                'image' => 'imacpro.jpg',
                'fieldset_id' => 2,

            ];
        });
    }

    /**
     * Lenovo Intel Core i5 Pro
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelLenovoi5()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Lenovo Intel Core i5',
                'category_id' => 2,
                'manufacturer_id' => 6,
                'eol' => '24',
                'depreciation_id' => 1,
                'image' => 'lenovoi5.png',
                'fieldset_id' => 2,

            ];
        });
    }

    /**
     * OptiPlex
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelOptiplex()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'OptiPlex',
                'category_id' => 2,
                'manufacturer_id' => 3,
                'model_number' => '5040 (MRR81)',
                'eol' => '24',
                'depreciation_id' => 1,
                'image' => 'optiplex.jpg',
                'fieldset_id' => 2,

            ];
        });
    }

    /**
     * SoundStation 2
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelPolycom()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'SoundStation 2',
                'category_id' => 6,
                'manufacturer_id' => 8,
                'eol' => '12',
                'depreciation_id' => 1,
                'image' => 'soundstation.jpg',
            ];
        });
    }

    /**
     * Polycom CX3000 IP Conference Phone
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelPolycomCx()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Polycom CX3000 IP Conference Phone',
                'category_id' => 6,
                'manufacturer_id' => 8,
                'eol' => '12',
                'depreciation_id' => 1,
                'image' => 'cx3000.png',
            ];
        });
    }

    /**
     * iPad
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelIpad()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'iPad Pro',
                'category_id' => 3,
                'manufacturer_id' => 1,
                'eol' => '12',
                'depreciation_id' => 1,
                'image' => 'ipad.jpg',
            ];
        });
    }

    /**
     * Tab3
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelTab3()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Tab3',
                'category_id' => 3,
                'manufacturer_id' => 6,
                'eol' => '12',
                'depreciation_id' => 1,
                'image' => 'tab3.png',
            ];
        });
    }

    /**
     * iPhone 6
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelIphone6()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'iPhone 6s',
                'category_id' => 4,
                'manufacturer_id' => 1,
                'eol' => '12',
                'depreciation_id' => 3,
                'image' => 'iphone6.jpg',
                'fieldset_id' => 1,
            ];
        });
    }

    /**
     * iPhone 7
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelIphone7()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'iPhone 7',
                'category_id' => 4,
                'manufacturer_id' => 1,
                'eol' => '12',
                'depreciation_id' => 3,
                'image' => 'iphone7.jpg',
                'fieldset_id' => 1,
            ];
        });
    }

    /**
     * Ultrafine
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelUltrafine()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Ultrafine 4k',
                'category_id' => 5,
                'manufacturer_id' => 7,
                'eol' => '12',
                'depreciation_id' => 2,
                'image' => 'ultrafine.jpg',
            ];
        });
    }

    /**
     * Ultrasharp
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetModelUltrasharp()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Ultrasharp U2415',
                'category_id' => 5,
                'manufacturer_id' => 7,
                'eol' => '12',
                'depreciation_id' => 2,
                'image' => 'ultrasharp.jpg',
            ];
        });
    }
}
