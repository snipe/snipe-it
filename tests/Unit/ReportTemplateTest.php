<?php

namespace Tests\Unit;

use App\Models\Location;
use App\Models\ReportTemplate;
use Tests\TestCase;

class ReportTemplateTest extends TestCase
{
    public function testParsingCheckmarkValue()
    {
        $savedReport = ReportTemplate::factory()->create([
            'options' => [
                'is_a_checkbox_field' => '1',
            ],
        ]);

        $this->assertEquals('1', $savedReport->checkmarkValue('is_a_checkbox_field'));
        $this->assertEquals('0', $savedReport->checkmarkValue('non_existent_key'));

        $this->assertEquals('1', (new ReportTemplate)->checkmarkValue('is_a_checkbox_field'));
    }

    public function testParsingTextValue()
    {
        $savedReport = ReportTemplate::factory()->create([
            'options' => [
                'is_a_text_field' => 'some text',
            ],
        ]);

        $this->assertEquals('some text', $savedReport->textValue('is_a_text_field'));
        $this->assertEquals('', $savedReport->textValue('non_existent_key'));

        $this->assertEquals('', (new ReportTemplate)->textValue('is_a_text_field'));
    }

    public function testParsingRadioValue()
    {
        $savedReport = ReportTemplate::factory()->create([
            'options' => [
                'is_a_radio_field' => null,
            ],
        ]);

        $this->assertEquals('return_value', $savedReport->radioValue('is_a_radio_field', null, 'return_value'));
        $this->assertEquals(null, $savedReport->radioValue('is_a_radio_field', 'another_value', 'return_value'));
        $this->assertNull($savedReport->radioValue('non_existent_key', '1', true));
    }

    public function testParsingSelectValue()
    {
        $savedReport = ReportTemplate::factory()->create([
            'options' => [
                'is_a_text_field_as_well' => '4',
                'contains_a_null_value' => null,
            ],
        ]);

        $this->assertEquals('4', $savedReport->selectValue('is_a_text_field_as_well'));
        $this->assertEquals('', $savedReport->selectValue('non_existent_key'));
        $this->assertNull($savedReport->selectValue('contains_a_null_value'));
    }

    public function testParsingSelectValues()
    {
        $savedReport = ReportTemplate::factory()->create([
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
        [$locationA, $locationB] = Location::factory()->count(2)->create();
        $invalidId = 10000;

        $templateWithValidId = ReportTemplate::factory()->create([
            'options' => ['single_value' => $locationA->id],
        ]);

        $templateWithDeletedId = ReportTemplate::factory()->create([
            'options' => ['single_value' => $locationB->id],
        ]);
        $locationB->delete();

        $templateWithInvalidId = ReportTemplate::factory()->create([
            'options' => ['single_value' => $invalidId],
        ]);

        $this->assertEquals(
            $locationA->id,
            $templateWithValidId->selectValue('single_value', Location::class)
        );

        $this->assertNull($templateWithDeletedId->selectValue('single_value', Location::class));
        $this->assertNull($templateWithInvalidId->selectValue('single_value', Location::class));
    }

    public function testSelectValuesDoNotIncludeDeletedOrNonExistentModels()
    {
        [$locationA, $locationB] = Location::factory()->count(2)->create();
        $invalidId = 10000;

        $savedReport = ReportTemplate::factory()->create([
            'options' => [
                'array_of_ids' => [
                    $locationA->id,
                    $locationB->id,
                    $invalidId,
                ],
            ],
        ]);

        $locationB->delete();

        $parsedValues = $savedReport->selectValues('array_of_ids', Location::class);

        $this->assertContains($locationA->id, $parsedValues);
        $this->assertNotContains($locationB->id, $parsedValues);
        $this->assertNotContains($invalidId, $parsedValues);
    }

    public function testGracefullyHandlesSingleSelectBecomingMultiSelect()
    {
        $this->markTestIncomplete();
    }

    public function testGracefullyHandlesMultiSelectBecomingSingleSelect()
    {
        $this->markTestIncomplete();
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

    public function testSavedReportHasDefaultValuesSet()
    {
        $this->markTestIncomplete();

        // Quick thought: I think deleted_assets should be set to null so that
        // "Exclude Deleted Assets" is selected when using a new'd up SavedReport.
    }

    public function testOldValuesStillWorkAfterTheseChanges()
    {
        $this->markTestIncomplete();

        // Another marker that won't actually be a test case:
        // We need to make sure that any behavior involving using "old" input.
        // I explicitly removed the old()s from the "deleted_assets" radio buttons.
        // The "x-selects" partials still include them, but I haven't tested them yet.
    }
}
