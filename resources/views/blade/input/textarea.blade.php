@props([
    'name',
    // use name if id is not provided
    'id' => $id ?? $name,
    'value' => '',
    'cols' => 50,
    'rows' => 10,
])

<textarea
    {{ $attributes->merge(['class' => 'form-control']) }}
    name="{{ $name }}"
    id="{{ $id }}"
    cols="{{ $cols }}"
    rows="{{ $rows }}"
>{{ $value }}</textarea>
