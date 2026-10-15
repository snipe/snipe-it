@props([
    'name' => null,
    'value' => '1',
    'checked' => false,
    'required' => false,
    'disabled' => false,
    'id' => null,
])
<!-- input-checkbox blade component -->
<input
    type="checkbox"
    name="{{ $name }}"
    value="{{ $value }}"
    @if ($id) id="{{ $id }}" @endif
    {{ $attributes }}
    @checked($checked)
    @required($required)
    @disabled($disabled)
/>
