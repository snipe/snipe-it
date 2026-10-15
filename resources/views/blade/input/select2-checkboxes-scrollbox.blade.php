{{-- Always-open scrolling checkbox list backed by an AJAX selectlist
     endpoint. Behavior lives in the .js-select2-checkboxes-scrollbox init in
     snipeit.js. Styling in overrides.less under the same name.

     Submits as a single hidden input containing a comma-separated
     list of selected ids, sidestepping max_input_vars for very large
     selections. The server reads with
     explode(',', $request->input($name)).

     Props:
       name       : hidden input name and form field.
       label      : control label shown above the scrolling box.
       endpoint   : selectlist endpoint slug (users, companies, ...).
       selected   : array of pre-selected ids (optional).
       height     : max-height of the scrolling box in px (default 400).
       maxSelectAll : optional per-widget ceiling for ?all=1 (clamped by MAX_UNPAGINATED).
       help_text  : optional help text under the control.
--}}
@props([
    'name',
    'label',
    'endpoint',
    'selected' => [],
    'height' => 400,
    'maxSelectAll' => null,
    'help_text' => null,
    'compactSubmit' => false,
])

@php
    $listId = $name.'_checkbox_list';
    $selectedIds = collect($selected ?? [])->filter()->values();
    $selectedCsv = $selectedIds->implode(',');
    $selectedCount = $selectedIds->count();
@endphp

<div @class(['form-group', 'has-error' => $errors->has($name)])>
    <label for="{{ $listId }}" class="col-md-3 control-label">{{ $label }}</label>
    <div class="col-md-7">
        <div
            class="js-select2-checkboxes-scrollbox"
            data-endpoint="{{ $endpoint }}"
            data-name="{{ $name }}"
            data-compact-submit="{{ $compactSubmit ? '1' : '0' }}"
            @if ($compactSubmit) data-hidden="{{ $listId }}_hidden" @endif
            @if ($maxSelectAll) data-max-select-all="{{ (int) $maxSelectAll }}" @endif
        >
            <div class="js-select2-checkboxes-scrollbox-controls">
                <div class="js-select2-checkboxes-scrollbox-search-wrap">
                    <input
                        type="text"
                        class="form-control js-select2-checkboxes-scrollbox-search"
                        placeholder="{{ trans('general.search') }}"
                        aria-label="{{ trans('general.search') }}"
                    >
                    <button
                        type="button"
                        class="js-select2-checkboxes-scrollbox-search-clear"
                        aria-label="{{ trans('admin/hardware/general.clear') }}"
                    >&times;</button>
                </div>
                <button type="button" class="btn btn-sm btn-theme js-select2-checkboxes-scrollbox-selectall">
                    {{ trans('general.select_all') }}
                </button>
                <button type="button" class="btn btn-sm btn-theme js-select2-checkboxes-scrollbox-clear">
                    {{ trans('general.deselect_all') }}
                </button>
                {{-- {n} is the JS-side placeholder convention. Laravel's
                     trans() substitutes `:key` not `{n}`, so render the
                     initial count by hand here and stash the template
                     on data-template for the JS to re-use on every
                     selection change. --}}
                @php $countTemplate = trans('general.checkbox_multiselect_count'); @endphp
                <span
                    class="js-select2-checkboxes-scrollbox-count"
                    aria-live="polite"
                    data-template="{{ $countTemplate }}"
                >{{ str_replace('{n}', $selectedCount, $countTemplate) }}</span>
            </div>
            <div
                id="{{ $listId }}"
                class="js-select2-checkboxes-scrollbox-scroll"
                style="height: {{ (int) $height }}px;"
                role="listbox"
                aria-multiselectable="true"
                aria-label="{{ $label }}"
            ></div>

            @if ($compactSubmit)
                {{-- Single hidden comma-separated input. Server reads with
                     explode(','). JS keeps it in sync as the user
                     ticks rows. Only used for lists with a LOT of items that
                      might hit the php_max_input_vars limit. --}}
                <input
                    type="hidden"
                    id="{{ $listId }}_hidden"
                    name="{{ $name }}"
                    value="{{ $selectedCsv }}"
                >
            @else
                {{-- Container for per-id hidden inputs. JS keeps one
                     name="X[]" input per selected id so the form
                     submits a plain array shape the rest of the app
                     already understands. --}}
                <div class="js-select2-checkboxes-scrollbox-array-inputs" aria-hidden="true">
                    @foreach ($selectedIds as $preselectedId)
                        <input type="hidden" name="{{ $name }}[]" value="{{ $preselectedId }}">
                    @endforeach
                </div>
            @endif
        </div>

        @if ($help_text)
            <x-form.help :name="$listId">{!! $help_text !!}</x-form.help>
        @endif

        <x-form.error :name="$name" />
    </div>
</div>
