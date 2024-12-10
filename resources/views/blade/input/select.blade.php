@props([
    // items can either be provided as key => value pairs
    // or passed in via the default $slot
    'items',
    'selected' => null,
    'includeEmpty' => false,
    'forLivewire' => false,
])

<select
    {{ $attributes->class(['select2', 'livewire-select2' => $forLivewire]) }}
    @if($forLivewire) data-livewire-component="{{ $this->getId() }}" @endif
>
    @if($includeEmpty)
        <option value=""></option>
    @endif
    {{-- map the simple key => value pairs when nothing is passed in via the slot --}}
    @if($slot->isEmpty())
        @foreach($items as $key => $value)
            <option value="{{ $key }}" @selected($selected === $key)>{{ $value }}</option>
        @endforeach
    @else
        {{ $slot }}
    @endif
</select>
