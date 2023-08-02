<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\CategoryEditForm;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryEditFormTest extends TestCase
{
    public function testTheComponentCanRender()
    {
        Livewire::test(CategoryEditForm::class)->assertStatus(200);
    }
}
