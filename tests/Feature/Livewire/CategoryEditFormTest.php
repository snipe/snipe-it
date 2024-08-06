<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CategoryEditForm;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryEditFormTest extends TestCase
{
    public function testTheComponentCanRender(): void
    {
        Livewire::test(CategoryEditForm::class)->assertStatus(200);
    }

    public function testSendEmailCheckboxIsCheckedOnLoadWhenSendEmailIsExistingSetting(): void
    {
        Livewire::test(CategoryEditForm::class, [
            'sendCheckInEmail' => true,
            'eulaText' => '',
            'useDefaultEula' => false,
        ])->assertSet('sendCheckInEmail', true);
    }

    public function testSendEmailCheckboxIsCheckedOnLoadWhenCategoryEulaSet(): void
    {
        Livewire::test(CategoryEditForm::class, [
            'sendCheckInEmail' => false,
            'eulaText' => 'Some Content',
            'useDefaultEula' => false,
        ])->assertSet('sendCheckInEmail', true);
    }

    public function testSendEmailCheckboxIsCheckedOnLoadWhenUsingDefaultEula(): void
    {
        Livewire::test(CategoryEditForm::class, [
            'sendCheckInEmail' => false,
            'eulaText' => '',
            'useDefaultEula' => true,
        ])->assertSet('sendCheckInEmail', true);
    }

    public function testSendEmailCheckBoxIsUncheckedOnLoadWhenSendEmailIsFalseNoCategoryEulaSetAndNotUsingDefaultEula(): void
    {
        Livewire::test(CategoryEditForm::class, [
            'sendCheckInEmail' => false,
            'eulaText' => '',
            'useDefaultEula' => false,
        ])->assertSet('sendCheckInEmail', false);
    }

    public function testSendEmailCheckboxIsCheckedWhenCategoryEulaEntered(): void
    {
        Livewire::test(CategoryEditForm::class, [
            'sendCheckInEmail' => false,
            'useDefaultEula' => false,
        ])->assertSet('sendCheckInEmail', false)
            ->set('eulaText', 'Some Content')
            ->assertSet('sendCheckInEmail', true);
    }

    public function testSendEmailCheckboxCheckedAndDisabledAndEulaTextDisabledWhenUseDefaultEulaSelected(): void
    {
        Livewire::test(CategoryEditForm::class, [
            'sendCheckInEmail' => false,
            'useDefaultEula' => false,
        ])->assertSet('sendCheckInEmail', false)
            ->set('useDefaultEula', true)
            ->assertSet('sendCheckInEmail', true)
            ->assertSet('eulaTextDisabled', true)
            ->assertSet('sendCheckInEmailDisabled', true);
    }

    public function testSendEmailCheckboxEnabledAndSetToOriginalValueWhenNoCategoryEulaAndNotUsingGlobalEula(): void
    {
        Livewire::test(CategoryEditForm::class, [
            'eulaText' => 'Some Content',
            'sendCheckInEmail' => false,
            'useDefaultEula' => true,
        ])
            ->set('useDefaultEula', false)
            ->set('eulaText', '')
            ->assertSet('sendCheckInEmail', false)
            ->assertSet('sendCheckInEmailDisabled', false);

        Livewire::test(CategoryEditForm::class, [
            'eulaText' => 'Some Content',
            'sendCheckInEmail' => true,
            'useDefaultEula' => true,
        ])
            ->set('useDefaultEula', false)
            ->set('eulaText', '')
            ->assertSet('sendCheckInEmail', true)
            ->assertSet('sendCheckInEmailDisabled', false);
    }

    public function testEulaFieldEnabledOnLoadWhenNotUsingDefaultEula(): void
    {
        Livewire::test(CategoryEditForm::class, [
            'sendCheckInEmail' => false,
            'eulaText' => '',
            'useDefaultEula' => false,
        ])->assertSet('eulaTextDisabled', false);
    }
}
