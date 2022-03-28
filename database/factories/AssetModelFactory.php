<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Asset Model Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating models ..
|
*/

/*
|--------------------------------------------------------------------------
| Laptops
|--------------------------------------------------------------------------
*/

// 1

// 2

// 3

// 4

// 5

// 6

// 7

/*
|--------------------------------------------------------------------------
| Desktops
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Conference Phones
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Tablets
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Mobile Phones
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Displays
|--------------------------------------------------------------------------
*/

class AssetModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\AssetModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'name' => $this->faker->catchPhrase(),
            'model_number' => $this->faker->creditCardNumber(),
            'notes' => 'Created by demo seeder',

        ];
    }

    public function mbp13Model()
    {
        return $this->state(function () {
            return [
                'name' => 'Macbook Pro 13"',
                'category_id' => 1,
                'eol' => '36',
                'depreciation_id' => 1,
                'image' => 'mbp.jpg',
                'fieldset_id' => 2,
            ];
        });
    }

    public function mbpAirModel()
    {
        return $this->state(function () {
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

    public function surfaceModel()
    {
        return $this->state(function () {
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

    public function xps13Model()
    {
        return $this->state(function () {
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

    public function zenbookModel()
    {
        return $this->state(function () {
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

    public function spectreModel()
    {
        return $this->state(function () {
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

    public function yogaModel()
    {
        return $this->state(function () {
            return [
                'name' => 'Yoga 910',
                'category_id' => 1,
                'manufacturer_id' => 6,
                'eol' => '36',
                'depreciation_id' => 1,
                'image' => 'yoga.png',
                'fieldset_id' => 2,
            ];
        });
    }

    public function macproModel()
    {
        return $this->state(function () {
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

    public function lenovoI5Model()
    {
        return $this->state(function () {
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

    public function optiplexModel()
    {
        return $this->state(function () {
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

    public function polycomModel()
    {
        return $this->state(function () {
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

    public function polycomcxModel()
    {
        return $this->state(function () {
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

    public function ipadModel()
    {
        return $this->state(function () {
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

    public function tab3Model()
    {
        return $this->state(function () {
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

    public function iphone11Model()
    {
        return $this->state(function () {
            return [
                'name' => 'iPhone 11',
                'category_id' => 4,
                'manufacturer_id' => 1,
                'eol' => '12',
                'depreciation_id' => 3,
                'image' => 'iphone11.jpeg',
                'fieldset_id' => 1,
            ];
        });
    }

    public function iphone12Model()
    {
        return $this->state(function () {
            return [
                'name' => 'iPhone 12',
                'category_id' => 4,
                'manufacturer_id' => 1,
                'eol' => '12',
                'depreciation_id' => 1,
                'image' => 'iphone12.jpeg',
                'fieldset_id' => 1,
            ];
        });
    }

    public function ultrafine()
    {
        return $this->state(function () {
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

    public function ultrasharp()
    {
        return $this->state(function () {
            return [
                'name' => 'Ultrasharp U2415',
                'category_id' => 5,
                'manufacturer_id' => 3,
                'eol' => '12',
                'depreciation_id' => 2,
                'image' => 'ultrasharp.jpg',
            ];
        });
    }
}
