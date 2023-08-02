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

    public function testSendEmailCheckboxIsCheckedOnLoadWhenSendEmailIsExistingSetting()
    {
        Livewire::test(CategoryEditForm::class, [
            'checkinEmail' => true,
            'eulaText' => '',
            'useDefaultEula' => false,
        ])->assertSet('checkinEmail', true);
    }

    public function testSendEmailCheckboxIsCheckedOnLoadWhenCategoryEulaSet()
    {
        Livewire::test(CategoryEditForm::class, [
            'checkinEmail' => false,
            'eulaText' => 'Some Content',
            'useDefaultEula' => false,
        ])->assertSet('checkinEmail', true);
    }

    public function testSendEmailCheckboxIsCheckedOnLoadWhenUsingDefaultEula()
    {
        Livewire::test(CategoryEditForm::class, [
            'checkinEmail' => false,
            'eulaText' => '',
            'useDefaultEula' => true,
        ])->assertSet('checkinEmail', true);
    }

    public function testSendEmailCheckBoxIsUncheckedOnLoadWhenSendEmailIsFalseNoCategoryEulaSetAndNotUsingDefaultEula()
    {
        Livewire::test(CategoryEditForm::class, [
            'checkinEmail' => false,
            'eulaText' => '',
            'useDefaultEula' => false,
        ])->assertSet('checkinEmail', false);
    }

    public function testSendEmailCheckboxIsCheckedWhenCategoryEulaEntered()
    {
        Livewire::test(CategoryEditForm::class, [
            'checkinEmail' => false,
            'useDefaultEula' => false,
        ])->assertSet('checkinEmail', false)
            ->set('eulaText', 'Some Content')
            ->assertSet('checkinEmail', true);
    }

    public function testSendEmailCheckboxCheckedWhenUseDefaultEulaSelected()
    {
        Livewire::test(CategoryEditForm::class, [
            'checkinEmail' => false,
            'useDefaultEula' => false,
        ])->assertSet('checkinEmail', false)
            ->set('useDefaultEula', true)
            ->assertSet('checkinEmail', true);
    }
}
