@props([
    'name' => null,
    'item' => null,
    'label' => null,
    'value' => '1',
    'required' => null,
    'disabled' => false,
])

@php
    // Old-input aware check-state. On a fresh render, session()->hasOldInput()
    // is false, so we fall back to the model. On a validation-failure redisplay,
    // hasOldInput() is true and we trust the (possibly missing) old value: an
    // unchecked box comes back correctly unchecked instead of falling through
    // to the stale $item->{$name}.
    $is_redisplay = session()->hasOldInput();
    $checked = $is_redisplay
        ? (bool) old($name)
        : (bool) ($item?->{$name} ?? false);

    // Helper::checkIfRequired dereferences $item statically via $item::rules(),
    // so it needs a real class/object. Fall back to false when no model was
    // supplied (transient forms have no persistent model).
    $really_required = $required ?? ($item ? Helper::checkIfRequired($item, $name) : false);
@endphp

{{-- Inline variant: no form-group wrapper. The caller drops this into an
     existing form row (e.g. next to a text input in a bulk-edit view) and
     controls the containing column themselves. --}}
<label class="form-control">
    <x-input.checkbox
        :name="$name"
        :id="$name"
        :value="$value"
        :checked="$checked"
        :required="$really_required"
        :disabled="$disabled"
        :aria-label="$name"
    />
    {{ $label }}
</label>
