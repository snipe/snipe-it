<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * Dynamic tag + serial rows for the multi-asset create form
 * (hardware/edit.blade.php when $item->id is null). Replaces the jQuery
 * string-HTML injection that used to sit in the same blade file and let
 * users add or remove additional asset_tag/serial pairs one at a time.
 *
 * The primary (index 1) tag and serial inputs stay in the outer blade
 * so this component only manages indices 2+. Field names are preserved
 * as asset_tags[N] / serials[N] so the outer form's plain POST submit
 * picks them up alongside the primary row.
 */
class AssetAdditionalTags extends Component
{
    /**
     * Additional tag + serial pairs keyed by 1-based row number as it
     * appears in the form field names (asset_tags[2], asset_tags[3],
     * ...). Keys keep their original number when a middle row is
     * removed so Laravel's per-field validator errors continue to point
     * at the right row.
     */
    public array $rows = [];

    /**
     * Auto-increment prefix from Setting::getSettings(). Used when
     * computing the next tag value on addRow(); empty when the tenant
     * has no prefix configured.
     */
    public string $autoPrefix = '';

    /**
     * Whether the tenant has auto-increment turned on. When false,
     * addRow() leaves the new row's tag blank for the operator to
     * fill in manually.
     */
    public bool $autoEnabled = false;

    protected int $maxFields = 100;

    public function mount(string $autoPrefix = '', bool $autoEnabled = false): void
    {
        $this->autoPrefix = $autoPrefix;
        $this->autoEnabled = $autoEnabled;

        // On validation-failure redisplay Laravel repopulates old input
        // with every submitted asset_tag/serial. Rehydrate rows 2+ from
        // that so users don't lose their added rows when the primary
        // form errors out. Index 1 stays with the outer blade.
        foreach (old('asset_tags', []) as $i => $tag) {
            if ((int) $i === 1) {
                continue;
            }
            $this->rows[(int) $i] = [
                'asset_tag' => $tag,
                'serial' => old('serials.'.$i, ''),
            ];
        }
    }

    /**
     * Add an empty row. Dispatched by the "add another tag" button in
     * hardware/edit.blade.php via `Livewire.dispatch('addTagRow', ...)`,
     * which passes the primary asset_tag input's current DOM value so
     * we can auto-increment from what the operator has actually typed.
     */
    #[On('addTagRow')]
    public function addRow(string $firstTag = ''): void
    {
        if (count($this->rows) + 1 >= $this->maxFields) {
            return;
        }

        $nextIndex = empty($this->rows) ? 2 : max(array_keys($this->rows)) + 1;

        $this->rows[$nextIndex] = [
            'asset_tag' => $this->nextAutoTag($nextIndex, $firstTag),
            'serial' => '',
        ];
    }

    public function removeRow(int $index): void
    {
        unset($this->rows[$index]);
    }

    /**
     * Compute the next auto-increment tag value given the primary
     * row's current tag. Mirrors the pre-Livewire JS: strip the
     * tenant prefix, parse the remainder as an int, add (index - 1),
     * zero-pad to the original digit width, re-prepend the prefix.
     * Returns an empty string when auto-increment is off.
     */
    protected function nextAutoTag(int $rowIndex, string $firstTag): string
    {
        if (! $this->autoEnabled) {
            return '';
        }

        $stripped = ($this->autoPrefix !== '' && str_starts_with($firstTag, $this->autoPrefix))
            ? substr($firstTag, strlen($this->autoPrefix))
            : $firstTag;

        if ($stripped === '' || ! ctype_digit($stripped)) {
            return $this->autoPrefix;
        }

        $incremented = (int) $stripped + ($rowIndex - 1);
        $padded = str_pad((string) $incremented, strlen($stripped), '0', STR_PAD_LEFT);

        return $this->autoPrefix.$padded;
    }

    public function render(): View
    {
        return view('livewire.asset-additional-tags');
    }
}
