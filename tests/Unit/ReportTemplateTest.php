<?php

namespace Tests\Unit;

use App\Models\Department;
use App\Models\Location;
use App\Models\ReportTemplate;
use Tests\TestCase;

class ReportTemplateTest extends TestCase
{
    public function testParsingValuesOnNonExistentReportTemplate()
    {
        $this->markTestIncomplete();

        $unsavedTemplate = new ReportTemplate;

        // checkmarkValue()
        // radioValue()
        $this->assertNull($unsavedTemplate->selectValue('value_on_unsaved_template'));
        // selectValues()
        // textValue()
    }

    public function testParsingCheckmarkValue()
    {
        $template = ReportTemplate::factory()->create([
            'options' => [
                'is_a_checkbox_field' => '1',
            ],
        ]);

        $this->assertEquals('1', $template->checkmarkValue('is_a_checkbox_field'));
        $this->assertEquals('0', $template->checkmarkValue('non_existent_key'));

        $this->assertEquals('1', (new ReportTemplate)->checkmarkValue('is_a_checkbox_field'));
    }

    public function testParsingTextValue()
    {
        $template = ReportTemplate::factory()->create([
            'options' => [
                'is_a_text_field' => 'some text',
            ],
        ]);

        $this->assertEquals('some text', $template->textValue('is_a_text_field'));
        $this->assertEquals('', $template->textValue('non_existent_key'));

        $this->assertEquals('', (new ReportTemplate)->textValue('is_a_text_field'));
    }

    public function testParsingRadioValue()
    {
        $template = ReportTemplate::factory()->create([
            'options' => [
                'is_a_radio_field' => null,
            ],
        ]);

        $this->assertEquals('return_value', $template->radioValue('is_a_radio_field', null, 'return_value'));
        $this->assertEquals(null, $template->radioValue('is_a_radio_field', 'another_value', 'return_value'));
        $this->assertNull($template->radioValue('non_existent_key', '1', true));
    }

    public function testParsingSelectValue()
    {
        $template = ReportTemplate::factory()->create([
            'options' => [
                'is_a_text_field_as_well' => '4',
                'contains_a_null_value' => null,
            ],
        ]);

        $this->assertEquals('4', $template->selectValue('is_a_text_field_as_well'));
        $this->assertEquals('', $template->selectValue('non_existent_key'));
        $this->assertNull($template->selectValue('contains_a_null_value'));
    }

    public function testParsingSelectValues()
    {
        $template = ReportTemplate::factory()->create([
            'options' => [
                'an_array' => ['2', '3', '4'],
                'an_empty_array' => [],
                'an_array_containing_null' => [null],
            ],
        ]);

        $this->assertEquals(['2', '3', '4'], $template->selectValues('an_array'));
        $this->assertEquals([], $template->selectValues('an_empty_array'));
        // @todo: should this actually be []?
        $this->assertEquals([null], $template->selectValues('an_array_containing_null'));
        $this->assertEquals([], $template->selectValues('non_existent_key'));
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
        $this->assertNull((new ReportTemplate)->selectValue('value_on_unsaved_template', Location::class));
    }

    public function testSelectValuesDoNotIncludeDeletedOrNonExistentModels()
    {
        [$locationA, $locationB] = Location::factory()->count(2)->create();
        $invalidId = 10000;

        $template = ReportTemplate::factory()->create([
            'options' => [
                'array_of_ids' => [
                    $locationA->id,
                    $locationB->id,
                    $invalidId,
                ],
            ],
        ]);

        $locationB->delete();

        $parsedValues = $template->selectValues('array_of_ids', Location::class);

        $this->assertContains($locationA->id, $parsedValues);
        $this->assertNotContains($locationB->id, $parsedValues);
        $this->assertNotContains($invalidId, $parsedValues);
    }

    public function testGracefullyHandlesSingleSelectBecomingMultiSelect()
    {
        $department = Department::factory()->create();

        // Given a report template saved with a property that is a string value
        $templateWithValue = ReportTemplate::factory()->create([
            'options' => ['single_value' => 'a string'],
        ]);

        $templateWithModelId = ReportTemplate::factory()->create([
            'options' => ['by_dept_id' => $department->id],
        ]);

        $this->assertEquals(['a string'], $templateWithValue->selectValues('single_value'));
        $this->assertContains($department->id, $templateWithModelId->selectValues('by_dept_id', Department::class));
    }

    public function testGracefullyHandlesMultiSelectBecomingSingleSelect()
    {
        $this->markTestIncomplete();

        [$departmentA, $departmentB] = Department::factory()->count(2)->create();

        // Given a report template saved with a property that is an array of values
        $templateWithValuesInArray = ReportTemplate::factory()->create([
            'options' => ['array_of_values' => [1, 'a string']],
        ]);

        $templateWithModelIdsInArray = ReportTemplate::factory()->create([
            'options' => ['model_ids' => [$departmentA->id, $departmentB->id]],
        ]);

        // @todo: Determine behavior...shoudl we return the first value?
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

    public function testReportTemplateHasDefaultValuesSet()
    {
        $this->markTestIncomplete();

        // Quick thought: I think deleted_assets should be set to null so that
        // "Exclude Deleted Assets" is selected when using a new'd up ReportTemplate.
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
