<?php

namespace Database\Seeders;

use Database\Factories\LabelFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LabelFactory::loadLabels()->create();
    }
}
