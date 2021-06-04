<?php
namespace Database\Factories;

use App\Models\Statuslabel;
use Illuminate\Database\Eloquent\Factories\Factory;



class StatuslabelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Statuslabel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
            'user_id' => 1,
            'deleted_at' => null,
            'deployable' => 0,
            'pending' => 0,
            'archived' => 0,
            'default_label' => 0,
            'notes' => $this->faker->sentence,
        ];

    }

    /**
     * RTD
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function statuslabelRtd()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Ready to Deploy',
                'deployable' => 1,
                'default_label' => 1,

            ];
        });
    }

    /**
     * Pending
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function statuslabelPending()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Pending',
                'pending' => 1,
            ];
        });
    }

    /**
     * Archived
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function statuslabelArchived()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Archived',
                'notes' => 'These assets are permanently undeployable',
                'archived' => 1,
            ];
        });
    }

    /**
     * Out for Diagnostics
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function statuslabelDiagnostics()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Out for Diagnostics',
                'notes' => 'These assets are out for diagnostics and therefore not deployable',
            ];
        });
    }

    /**
     * Out for Repair
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function statuslabelRepair()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Out for Diagnostics',
                'notes' => 'These assets are out for repair and therefore not deployable',
            ];
        });
    }

    /**
     * Broken
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function statuslabelBroken()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Broken',
                'notes' => 'These assets are broken and therefore not deployable',
            ];
        });
    }

    /**
     * Broken
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function statuslabelLost()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Lost / Stolen',
                'notes' => 'These assets are lost and therefore not deployable',
            ];
        });
    }



}


