<?php

namespace Tests\Feature\Importing\Ui;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ImportTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('imports.index'))
            ->assertOk();
    }

    public function testStoreInternationalAsset(): void
    {
        $evil_string = 'це'; //cyrillic - windows-1251 (ONE)
        $csv_contents = "a,b,c\n$evil_string,$evil_string,$evil_string\n";

        // now, deliberately transform our UTF-8 into Windows-1251 so we can test out the character-set detection
        $transliterated_contents = iconv('UTF-8', 'WINDOWS-1251', $csv_contents);
        //\Log::error("RAW TRANSLITERATED CONTENTS: $transliterated_contents"); // should show 'unicode missing glyph' symbol in logs.

        $this->actingAsForApi(User::factory()->superuser()->create());
        $results = $this->post(route('api.imports.store'), ['files' => [UploadedFile::fake()->createWithContent("myname.csv", $transliterated_contents)]])
            ->assertOk()
            ->assertJsonStructure([
                "files" => [
                    [
                        "created_at",
                        "field_map",
                        "file_path",
                        "filesize",
                        "first_row",
                        "header_row",
                        "id",
                        "import_type",
                        "name",
                    ]
                ]
            ]);
        $this->assertEquals($evil_string, $results->json()['files'][0]['first_row'][0]);
    }
}
