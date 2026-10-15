<?php

namespace Tests\Feature\Blade;

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class ButtonSubmitTest extends TestCase
{
    /**
     * Compile the given inline Blade fragment through the full component-
     * tag compiler and return the resulting HTML. Blade::render() bootstraps
     * a real compiler pass so attribute merging, @disabled evaluation, and
     * default @props resolution all fire the way they would in a live view.
     */
    private function render(string $inner): string
    {
        return Blade::render($inner);
    }

    public function test_defaults_render_a_primary_save_submit_button()
    {
        $html = $this->render('<x-button.submit />');

        $this->assertMatchesRegularExpression('/<button\b[^>]*type="submit"/', $html);
        $this->assertMatchesRegularExpression('/class="[^"]*\bbtn\b[^"]*"/', $html);
        $this->assertMatchesRegularExpression('/class="[^"]*\bbtn-primary\b[^"]*"/', $html);
        $this->assertStringContainsString(trans('general.save'), $html);
    }

    public function test_label_prop_overrides_default()
    {
        $html = $this->render('<x-button.submit label="Update Widget" />');

        $this->assertStringContainsString('Update Widget', $html);
        $this->assertStringNotContainsString(trans('general.save'), $html);
    }

    public function test_icon_defaults_to_checkmark_and_can_be_disabled()
    {
        $withIcon = $this->render('<x-button.submit />');
        $withoutIcon = $this->render('<x-button.submit :icon="false" />');

        // Checkmark by default; explicit :icon="false" strips it.
        // Callers use false (not null) because Blade's @props resolver
        // treats null as "not passed" and falls back to the default.
        $this->assertStringContainsString('fa-check', $withIcon);
        $this->assertStringNotContainsString('fa-check', $withoutIcon);
    }

    public function test_caller_class_merges_with_default()
    {
        $html = $this->render('<x-button.submit class="btn-success" />');

        // Both the caller color and the base .btn should still be present.
        $this->assertMatchesRegularExpression('/class="[^"]*\bbtn\b[^"]*"/', $html);
        $this->assertMatchesRegularExpression('/class="[^"]*\bbtn-success\b[^"]*"/', $html);
    }

    public function test_disabled_defaults_to_enabled()
    {
        // The component does not bake in any disable condition. Callers
        // pass :disabled="config('app.lock_passwords')" (or any other
        // reason) at the callsite when they want it off.
        config()->set('app.lock_passwords', true);
        $html = $this->render('<x-button.submit />');

        $this->assertDoesNotMatchRegularExpression('/<button\b[^>]*\bdisabled\b/', $html);
    }

    public function test_disabled_prop_passes_through()
    {
        $disabled = $this->render('<x-button.submit :disabled="true" />');
        $enabled = $this->render('<x-button.submit :disabled="false" />');

        $this->assertMatchesRegularExpression('/<button\b[^>]*\bdisabled\b/', $disabled);
        $this->assertDoesNotMatchRegularExpression('/<button\b[^>]*\bdisabled\b/', $enabled);
    }

    public function test_forwarded_attributes_reach_the_button()
    {
        $html = $this->render('<x-button.submit id="my-save" data-marker="X" />');

        $this->assertMatchesRegularExpression('/<button\b[^>]*id="my-save"/', $html);
        $this->assertMatchesRegularExpression('/<button\b[^>]*data-marker="X"/', $html);
    }
}
