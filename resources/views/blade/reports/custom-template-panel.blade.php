@props([
    'type',
    'template',
])

{{-- Right-column "Saved Templates" panel shared by the three custom
     report pages (asset / component / consumable).
     Report-type-specific bits (Livewire component type, the route
     name for the save-as-template guard) are derived from $type. --}}

@php
    $saveAsNewRoutes = match ($type) {
        'asset' => ['reports/custom'],
        'component' => ['reports/custom', 'reports.custom.component'],
        'consumable' => ['reports/custom', 'reports.custom.consumable'],
    };
    $isTemplatePage = request()->routeIs('report-templates.show');
    $isOwner = $template->created_by == auth()->id();
@endphp

@if ($isTemplatePage && $isOwner)
    {{-- Owner-of-saved-template controls: name, is_shared, Save, Delete.
         The name + is_shared inputs sit in the sidebar but belong to the
         main report-config form; form="custom-report-form" wires them in
         even though they're DOM-detached. The Save button uses the same
         form attribute plus formaction so it POSTs to the template-update
         endpoint instead of the main form's download action. --}}
    <div class="box box-default">
        <div class="box-header with-border">
            <h2 class="box-title">
                {{ trans('admin/reports/general.template_name') }}
            </h2>
        </div>
        <div class="box-body">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="sr-only">
                    {{ trans('admin/reports/general.template_name') }}
                </label>
                <input
                    class="form-control"
                    name="name"
                    type="text"
                    id="name"
                    value="{{ $template->name }}"
                    form="custom-report-form"
                    required
                >
                <x-form.error name="name"/>
            </div>

            <label class="form-control">
                <input
                    type="checkbox"
                    name="is_shared"
                    value="1"
                    form="custom-report-form"
                    @checked($template->is_shared)
                />
                {{ trans('admin/reports/general.share_template') }}
            </label>

            <button
                type="submit"
                form="custom-report-form"
                formaction="{{ route('report-templates.update', $template) }}"
                class="btn btn-success btn-social btn-block"
                style="margin-top: 10px;"
            >
                <x-icon type="checkmark" class="icon-white"/>
                {{ trans('general.save') }}
            </button>

            {{-- .delete-asset is the snipeit.js delete-confirm modal
                 trigger class (legacy name, not asset-specific). --}}
            <a
                href="#"
                class="btn btn-danger btn-social btn-block delete-asset"
                data-toggle="modal"
                data-title="{{ trans('general.delete') }}"
                data-content="{{ trans('general.delete_confirm', ['item' => $template->name]) }}"
                data-target="#dataConfirmModal"
                type="button"
                style="margin-top: 5px;"
            >
                <x-icon type="delete"/>
                {{ trans('general.delete') }}
            </a>
        </div>
    </div>
@endif

@if ($isTemplatePage && ! $isOwner)
    {{-- Non-owner viewing a shared template: read-only status, no edit
         controls. The Download button in the main form is still available
         for ad-hoc report pulls using the shared config. --}}
    <div class="box box-default">
        <div class="box-body text-center">
            <strong>{{ $template->name }}</strong>
            <div style="margin-top: 5px;">
                <i class="fa fa-users"></i> {{ trans('admin/reports/general.template_shared') }}
            </div>
        </div>
    </div>
@endif

@if (! $isTemplatePage)
    <livewire:report-template-select :type="$type"/>
@endif

@if (request()->routeIs(...$saveAsNewRoutes))
    <hr>
    <div class="form-group">
        {{-- data-report-save-template hooks the shared submit handler
             in snipeit.js (form[data-report-save-template]). That handler
             forwards the template name + type into the main custom-report
             form and submits it to templates.store. --}}
        <form
            method="post"
            id="savetemplateform"
            data-report-save-template
            data-report-type="{{ $type }}"
            data-report-form="#custom-report-form"
            data-store-url="{{ route('report-templates.store') }}"
            action="{{ route('report-templates.store') }}"
        >
            @csrf
            <input type="hidden" name="options">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">{{ trans('admin/reports/general.template_name') }}</label>
                <input
                    class="form-control"
                    placeholder=""
                    name="name"
                    type="text"
                    id="name"
                    value="{{ $template->name }}"
                    required
                >
                <x-form.error name="name"/>
            </div>
            <button class="btn btn-primary" style="width: 100%">
                {{ trans('admin/reports/general.save_template') }}
            </button>
        </form>
    </div>
    <div class="box box-success">
        <div class="box-header with-border">
            <h4>{{ trans('admin/reports/message.about_templates') }}</h4>
        </div>
        <div class="box-body">
            <p>{!! trans('admin/reports/message.saving_templates_description') !!}</p>
        </div>
    </div>
@endif
