@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($item->id)
        {{ trans('admin/manufacturers/table.update') }}
    @else
        {{ trans('admin/manufacturers/table.create') }}
    @endif
    @parent
@stop

{{-- Page content --}}
@section('content')

    <x-container class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">

        <x-form :$item route="{{ ($item->id) ? route('manufacturers.update', ['manufacturer' => $item->id]) : route('manufacturers.store') }}">

            <x-box top_submit>
                @if ($item->id)
                    <x-slot:header>{{ $item->name }}</x-slot:header>
                @endif

                <x-form.row
                    :label="trans('admin/manufacturers/table.name')"
                    :$item
                    name="name"
                />

                <x-form.row
                    :label="trans('general.url')"
                    :$item
                    name="url"
                    type="url"
                    input_icon="link"
                    input_group_addon="left"
                    placeholder="https://example.com"
                />

                <x-form.row
                    :label="trans('admin/manufacturers/table.support_url')"
                    :$item
                    name="support_url"
                    type="url"
                    help_html="{!! trans('admin/manufacturers/message.support_url_help') !!}"
                    input_icon="link"
                    input_group_addon="left"
                    placeholder="https://example.com"
                />

                <x-form.row
                    :label="trans('admin/manufacturers/table.warranty_lookup_url')"
                    :$item
                    name="warranty_lookup_url"
                    type="url"
                    help_html="{!! trans('admin/manufacturers/message.support_url_help') !!}"
                    input_icon="link"
                    input_group_addon="left"
                    placeholder="https://example.com"
                />

                <x-form.row
                    :label="trans('admin/manufacturers/table.support_phone')"
                    :$item
                    name="support_phone"
                    type="tel"
                    input_icon="phone"
                    input_group_addon="left"
                    placeholder="1-800-555-5555"
                />

                <x-form.row
                    :label="trans('admin/manufacturers/table.support_email')"
                    :$item
                    name="support_email"
                    type="email"
                    input_icon="email"
                    input_group_addon="left"
                    placeholder="support@example.com"
                />

                <x-input.image-upload :item="$item" :imagePath="app('manufacturers_upload_path')" />

                <x-form.row
                    :label="trans('general.notes')"
                    :$item
                    name="notes"
                    type="textarea"
                    :placeholder="trans('general.placeholders.notes')"
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
