<?php

namespace Database\Seeders;

use App\Models\LabelTemplate;
use Database\Factories\LabelFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabelTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LabelTemplate::factory()->avery5267Template()->create();
        LabelTemplate::factory()->avery5520Template()->create();
        LabelTemplate::factory()->averyL163Template()->create();
        LabelTemplate::factory()->averyL7162_2DTemplate()->create();
        LabelTemplate::factory()->averyL7162_1DTemplate()->create();
        LabelTemplate::factory()->brotherTze_12mmTemplate()->create();
        LabelTemplate::factory()->brotherTze_18mmTemplate()->create();
        LabelTemplate::factory()->brotherTze_24mmTemplate()->create();
        LabelTemplate::factory()->dymolabelWriter30252Template()->create();
        LabelTemplate::factory()->dymolabelWriter1933081Template()->create();
        LabelTemplate::factory()->dymolabelWriter2112283Template()->create();

    }
}
