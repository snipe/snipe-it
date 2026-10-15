@props([
    'count' => 0,
    'class' => false,
])

@if ($count > 0)
    <x-tabs.nav-item
        :$class
        name="orders"
        icon_type="order"
        label="{{ trans('general.orders') }}"
        count="{{ $count }}"
        tooltip="{{ trans('general.orders') }}"
    />
@endif
