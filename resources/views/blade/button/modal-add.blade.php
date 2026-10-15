@props([
    'type' => null,
    'target',
    'routeArgs' => null,
])

<a
    href="{{ route('modal.show', $routeArgs ?? $type) }}"
    data-toggle="modal"
    data-target="#createModal"
    data-select="{{ $target }}"
    class="btn btn-theme"
    data-tooltip="true"
    data-placement="top"
    data-title="{{ trans('general.create') }}"
    aria-label="{{ trans('general.create') }}"
>
    <x-icon type="create" class="fa-fw"/>
</a>
