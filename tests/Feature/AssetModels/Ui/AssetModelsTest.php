<?php

namespace Tests\Feature\AssetModels\Ui;

use App\Models\Category;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\CustomField;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class AssetModelsTest extends TestCase
{
    public function testUserCanListAssetModels()
    {

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('models.index'))
            ->assertStatus(200);

    }

    public function testUserCanCreateAssetModels()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('models.index'), [
                'name' => 'Test Model',
                'category_id' => Category::factory()->create()->id
            ])
            ->assertStatus(302)
            ->assertRedirect(route('models.index'));
    }


}
