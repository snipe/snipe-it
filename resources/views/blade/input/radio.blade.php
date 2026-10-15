@props([
    'name' => null,
    'value' => null,
    'checked' => false,
    'required' => false,
    'disabled' => false,
    'id' => null,
])
<!-- input-radio blade component -->
<input
    type="radio"
    name="{{ $name }}"
    value="{{ $value }}"
    @if ($id) id="{{ $id }}" @endif
    {{ $attributes }}
    @checked($checked)
    @required($required)
    @disabled($disabled)
/>
