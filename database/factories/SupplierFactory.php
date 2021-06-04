<?php
namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;


class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'email' => $this->faker->safeEmail(),
            'url' => $this->faker->url(),
            'user_id' => 1,
            'contact' => $this->faker->name(),
            'city' => $this->faker->city(),
            'state' => $this->faker->stateAbbr(),
            'address' => $this->faker->streetAddress(),
            'zip' => $this->faker->postcode(),
            'phone' => $this->faker->tollFreePhoneNumber(),
            'fax' => $this->faker->phoneNumber(),
        ];

    }


}


