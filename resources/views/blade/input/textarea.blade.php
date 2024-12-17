@props([
    'value' => '',
    'cols' => 50,
    'rows' => 10,
])

<textarea
    {{ $attributes->merge(['class' => 'form-control']) }}
    cols="{{ $cols }}"
    rows="{{ $rows }}"
>{{ $value }}</textarea>
