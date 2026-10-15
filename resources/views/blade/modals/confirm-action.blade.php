@props([
    'modalName',
    'modalClass' => null,
    'title',
    'route',
    'buttonClass' => 'btn-primary',
    'buttonLabel' => null,
])

<x-modals
    :id="$modalName"
    :title="$title"
    :action="$route"
    :submit_label="$buttonLabel ?? trans('general.confirm')"
    :submit_class="$buttonClass"
    :form_class="$modalClass"
>
    <div class="row">
        <div class="col-md-12">
            {{ $slot }}
        </div>
    </div>
</x-modals>
