@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($item->id)
        {{ trans('admin/maintenance_types/general.update') }}
    @else
        {{ trans('admin/maintenance_types/general.create') }}
    @endif
    @parent
@stop


{{-- Page content --}}
@section('content')
    <x-container class="col-md-6 col-md-offset-3">
        <x-form :$item route="{{ $item->id ? route('maintenance-types.update', $item->id) : route('maintenance-types.store') }}">
            <x-box top_submit>
                @if ($item->id)
                    <x-slot:header>{{ $item->name }}</x-slot:header>
                @endif

                <x-form.row
                    :label="trans('general.name')"
                    :$item
                    name="name"
                    required
                />

                    <fieldset name="color-preferences">
                        <x-form.legend help_text="{{ trans('general.tag_color_help') }}">
                            {{ trans('general.tag_color') }}
                        </x-form.legend>
                        <x-form.row
                            :label="trans('general.tag_color')"
                            :$item
                            name="tag_color"
                            type="colorpicker"
                        />
                    </fieldset>
            </x-box>
        </x-form>
    </x-container>
@stop
