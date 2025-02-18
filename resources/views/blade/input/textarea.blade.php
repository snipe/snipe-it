@props([
    'value' => '',
    'rows' => 10,
])

<textarea
    {{ $attributes->merge(['class' => 'form-control']) }}
    rows="{{ $rows }}"
>{{ $value }}</textarea>
