<?php

namespace Tests\Unit;

use App\Models\SavedReport;
use Tests\TestCase;

class SavedReportTest extends TestCase
{
    public function testParsingCheckmarkValues()
    {
        $savedReport = SavedReport::factory()->create([
            'options' => [
                'is_a_checkbox_value' => '1',
            ],
        ]);

        $this->assertEquals('1', $savedReport->checkmarkValue('is_a_checkbox_value'));
        $this->assertEquals('0', $savedReport->checkmarkValue('non_existent_key'));

        $this->assertEquals('1', (new SavedReport)->checkmarkValue('is_a_checkbox_value'));
    }

    public function testParsingTextValues()
    {
        $savedReport = SavedReport::factory()->create([
            'options' => [
                'is_a_text_value' => 'some text',
            ],
        ]);

        $this->assertEquals('some text', $savedReport->textValue('is_a_text_value'));
        $this->assertEquals('', $savedReport->textValue('non_existent_key'));

        $this->assertEquals('', (new SavedReport)->textValue('is_a_text_value'));
    }

    public function testParsingSelectValues()
    {
        $this->markTestIncomplete();
    }

    public function testSelectValuesDoNotIncludeDeletedModels()
    {
        $this->markTestIncomplete();

        // report saved with select option for a company (or whatever)
        // company is deleted
        // ensure company's id is not returned
    }
}
