<?php

namespace Tests\Feature\AssetModels\Ui;

use App\Livewire\CustomFieldSetDefaultValuesForModel;
use App\Models\AssetModel;
use App\Models\CustomFieldset;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class CloneAssetModelTest extends TestCase
{
    public function test_clone_page_preselects_source_fieldset()
    {
        // Regression for #19286: cloning a model that has a fieldset was
        // rendering the clone form with the fieldset selector empty, because
        // getClone was passing model_id => null to the fieldset picker.
        $fieldset = CustomFieldset::factory()->create();
        $source = AssetModel::factory()->create(['fieldset_id' => $fieldset->id]);

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('models.clone.create', $source))
            ->assertOk()
            // The fieldset id is rendered inside the fieldset selector's
            // <option selected> markup for the source fieldset.
            ->assertSee('value="'.$fieldset->id.'" selected', false);
    }

    public function test_livewire_fieldset_picker_receives_source_model_id_on_clone()
    {
        $fieldset = CustomFieldset::factory()->create();
        $source = AssetModel::factory()->create(['fieldset_id' => $fieldset->id]);

        $this->actingAs(User::factory()->superuser()->create());

        Livewire::test(CustomFieldSetDefaultValuesForModel::class, ['model_id' => $source->id])
            ->assertSet('model_id', $source->id)
            ->assertSet('fieldset_id', $fieldset->id);
    }

    public function test_livewire_fieldset_picker_leaves_fieldset_empty_when_no_model_id()
    {
        // Baseline: without a source model_id (i.e. plain create form), the
        // fieldset stays unset. Guards against a fix that would leak defaults
        // into an unrelated create flow.
        $this->actingAs(User::factory()->superuser()->create());

        Livewire::test(CustomFieldSetDefaultValuesForModel::class, ['model_id' => null])
            ->assertSet('model_id', null)
            ->assertSet('fieldset_id', null);
    }

    public function test_create_permission_alone_is_not_enough_to_clone_asset_model()
    {
        // Cloning renders the source asset model's data (model_number,
        // notes, fieldset, image) into the create form, so a user with
        // only models.create (no models.view) must be blocked.
        $model = AssetModel::factory()->create();

        $this->actingAs(User::factory()->createAssetModels()->create())
            ->get(route('models.clone.create', $model))
            ->assertForbidden();
    }
}
