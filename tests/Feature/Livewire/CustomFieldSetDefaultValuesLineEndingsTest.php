<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CustomFieldSetDefaultValuesForModel;
use App\Models\AssetModel;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use App\Models\User;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Regression coverage for #19429. The model default-values wizard used
 * explode("\r\n", ...) on custom-field values, which only splits CRLF.
 * Fields whose values were saved by a browser sending LF only (macOS,
 * Linux, some Windows Chrome configurations) rendered as a single
 * bunched-together option with visible newline characters. The blade now
 * iterates CustomField::formatFieldValuesAsArray, which handles all three
 * line-ending variants and also picks up the key|label split convention
 * the asset-edit form supports.
 */
class CustomFieldSetDefaultValuesLineEndingsTest extends TestCase
{
    /** @return array<string, array{string, string}> */
    public static function lineEndingProvider(): array
    {
        return [
            'LF' => ["Red\nGreen\nBlue", "\n"],
            'CRLF' => ["Red\r\nGreen\r\nBlue", "\r\n"],
            'CR' => ["Red\rGreen\rBlue", "\r"],
        ];
    }

    private function renderComponentWithField(string $element, string $fieldValues): \Livewire\Features\SupportTesting\Testable
    {
        $field = CustomField::factory()->create([
            'element' => $element,
            'field_values' => $fieldValues,
        ]);

        $fieldset = CustomFieldset::factory()->create();
        $fieldset->fields()->attach($field, ['order' => 1, 'required' => false]);

        $model = AssetModel::factory()->create(['fieldset_id' => $fieldset->id]);

        $this->actingAs(User::factory()->editAssetModels()->create());

        return Livewire::test(CustomFieldSetDefaultValuesForModel::class, ['model_id' => $model->id])
            ->set('add_default_values', true);
    }

    #[DataProvider('lineEndingProvider')]
    public function test_checkbox_options_render_as_separate_labels_regardless_of_line_endings(string $fieldValues, string $separator)
    {
        $this->renderComponentWithField('checkbox', $fieldValues)
            ->assertSeeHtml('value="Red"')
            ->assertSeeHtml('value="Green"')
            ->assertSeeHtml('value="Blue"')
            ->assertDontSeeHtml('value="Red'.$separator.'Green');
    }

    #[DataProvider('lineEndingProvider')]
    public function test_radio_options_render_as_separate_labels_regardless_of_line_endings(string $fieldValues, string $separator)
    {
        $this->renderComponentWithField('radio', $fieldValues)
            ->assertSeeHtml('value="Red"')
            ->assertSeeHtml('value="Green"')
            ->assertSeeHtml('value="Blue"')
            ->assertDontSeeHtml('value="Red'.$separator.'Green');
    }

    #[DataProvider('lineEndingProvider')]
    public function test_listbox_options_render_as_separate_options_regardless_of_line_endings(string $fieldValues, string $separator)
    {
        $this->renderComponentWithField('listbox', $fieldValues)
            ->assertSeeHtml('value="Red"')
            ->assertSeeHtml('value="Green"')
            ->assertSeeHtml('value="Blue"')
            ->assertDontSeeHtml('value="Red'.$separator.'Green');
    }

    public function test_checkbox_key_label_split_uses_label_for_both_value_and_display()
    {
        // The asset-edit form's checkbox/radio path uses the display label as
        // both the submitted value and the visible text. This UI must match
        // so stored defaults get pre-selected correctly on the asset form.
        $this->renderComponentWithField('checkbox', "red|Bright Red\ngreen|Forest Green")
            ->assertSeeHtml('value="Bright Red"')
            ->assertSeeHtml('value="Forest Green"')
            ->assertSee('Bright Red')
            ->assertSee('Forest Green');
    }

    public function test_listbox_key_label_split_uses_key_for_value_and_label_for_display()
    {
        // The listbox convention (matching Snipe-IT's x-input.select on the
        // asset-edit form) is: option value = key, option text = label. So a
        // stored default of "red" gets the "Bright Red" option pre-selected.
        $this->renderComponentWithField('listbox', "red|Bright Red\ngreen|Forest Green")
            ->assertSeeHtml('value="red"')
            ->assertSeeHtml('value="green"')
            ->assertSee('Bright Red')
            ->assertSee('Forest Green');
    }
}
