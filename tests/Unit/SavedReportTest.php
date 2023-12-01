<?php

namespace Tests\Unit;

use App\Models\SavedReport;
use Tests\TestCase;

class SavedReportTest extends TestCase
{
    public function testParsingCheckmarkValue()
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

    public function testParsingTextValue()
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

    public function testParsingSelectValue()
    {
        $savedReport = SavedReport::factory()->create([
            'options' => [
                'is_a_text_value_as_well' => '4',
                'contains_a_null_value' => null,
            ],
        ]);

        $this->assertEquals('4', $savedReport->selectValue('is_a_text_value_as_well'));
        $this->assertEquals('', $savedReport->selectValue('non_existent_key'));
        $this->assertNull($savedReport->selectValue('contains_a_null_value'));
    }

    public function testParsingSelectValues()
    {
        $savedReport = SavedReport::factory()->create([
            'options' => [
                'is_an_array' => ['2', '3', '4'],
                'is_an_array_containing_null' => [null],
            ],
        ]);

        $this->assertEquals(['2', '3', '4'], $savedReport->selectValues('is_an_array'));
        $this->assertEquals(null, $savedReport->selectValues('non_existent_key'));
        $this->assertNull($savedReport->selectValues('is_an_array_containing_null'));
    }

    public function testSelectValueDoesNotIncludeDeletedOrNonExistentModels()
    {
        $this->markTestIncomplete();

        // @todo: maybe it should optionally include deleted values?
    }

    public function testSelectValuesDoNotIncludeDeletedOrNonExistentModels()
    {
        $this->markTestIncomplete();

        // report saved with select option for a company (or whatever)
        // company is deleted
        // ensure company's id is not returned
    }

    public function testDeletedCustomFieldsDoNotCauseAnIssue()
    {
        $this->markTestIncomplete();
    }

    public function testDateRangesAreNotStored()
    {
        $this->markTestIncomplete();

        // This might not be a test we implement, but it's a place to ask a question:
        // Should we be saving and restoring date ranges?
        // A use-case I can see is running a report at the end of the month for the date ranges for that month.
        // Maybe it's better to leave those off so users are gently prompted to enter the ranges for each run?
        // Another option would be to have checkbox that asks the user if they would like to save the dates?
        // I'm not sure how helpful that is, and it would probably be a future feature if implemented.
    }
}
