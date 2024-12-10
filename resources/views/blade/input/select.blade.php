@props([
    'items',
    'selected' => null,
    'includeEmpty' => false,
    'forLivewire' => false,
])

<select
    {{ $attributes->class(['select2', 'livewire-select2' => $forLivewire]) }}
    @if ($forLivewire) data-livewire-component="{{ $this->getId() }}" @endif
>
    @if($includeEmpty)
        <option value=""></option>
    @endif
    @foreach($items as $key => $value)
        <option value="{{ $key }}" @selected($selected === $key)>{{ $value }}</option>
    @endforeach
</select>
