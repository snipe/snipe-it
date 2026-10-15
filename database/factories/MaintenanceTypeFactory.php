<?php

namespace Database\Factories;

use App\Models\MaintenanceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceTypeFactory extends Factory
{
    protected $model = MaintenanceType::class;

    /**
     * Palette of hand-picked hex colors that read cleanly against the
     * AdminLTE box background in both light and dark mode. Used to
     * seed tag_color on generated maintenance types so the calendar
     * view's color-coded events don't all render as the site header
     * fallback (or worse, whatever hex random_int spits out).
     */
    private const TAG_COLORS = [
        '#3c8dbc',
        '#f39c12',
        '#00a65a',
        '#dd4b39',
        '#605ca8',
        '#00c0ef',
        '#39cccc',
        '#d81b60',
    ];

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'tag_color' => $this->faker->randomElement(self::TAG_COLORS),
        ];
    }
}
