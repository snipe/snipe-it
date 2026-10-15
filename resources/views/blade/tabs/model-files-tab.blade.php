@props([
    'count' => null,
    'class' => false,
    'item' => null,
])

@can('files', $item)
    <x-tabs.nav-item
        :$class
        name="model-files"
        icon_type="more-files"
        label="{{ trans('general.additional_files') }}"
        count="{{ $count }}"
        tooltip="{{ trans('general.additional_files') }}"
    />
@endcan