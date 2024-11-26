@props([
    'items',
    'selected' => null,
    'includeEmpty' => false,
])

<select
    {{ $attributes->merge(['class' => 'select2']) }}
>
    @if($includeEmpty)
        <option value="" selected="selected"></option>
    @endif
    @foreach($items as $key => $value)
        <option value="{{ $key }}" @selected($selected === $key)>{{ $value }}</option>
    @endforeach
</select>
