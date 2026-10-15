@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($item->id)
        {{ trans('admin/suppliers/table.update') }}
    @else
        {{ trans('admin/suppliers/table.create') }}
    @endif
    @parent
@stop

{{-- Page content --}}
@section('content')

    <x-container class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">

        <x-form :$item route="{{ ($item->id) ? route('suppliers.update', ['supplier' => $item->id]) : route('suppliers.store') }}">

            <x-box top_submit>
                @if ($item->id)
                    <x-slot:header>{{ $item->name }}</x-slot:header>
                @endif

                <x-form.row
                    :label="trans('admin/suppliers/table.name')"
                    :$item
                    name="name"
                />

                <x-form.address :item="$item" />

                <x-form.row
                    :label="trans('admin/suppliers/table.contact')"
                    :$item
                    name="contact"
                />

                <x-form.row
                    :label="trans('admin/suppliers/table.phone')"
                    :$item
                    name="phone"
                    type="tel"
                    input_icon="phone"
                    input_group_addon="left"
                />

                <x-form.row
                    :label="trans('admin/suppliers/table.fax')"
                    :$item
                    name="fax"
                    type="tel"
                    input_icon="fax"
                    input_group_addon="left"
                    :maxlength="34"
                />

                <x-form.row
                    :label="trans('admin/suppliers/table.email')"
                    :$item
                    name="email"
                    type="email"
                    input_icon="email"
                    input_group_addon="left"
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
                    :label="trans('general.notes')"
                    :$item
                    name="notes"
                    type="textarea"
                />

                <x-input.image-upload :item="$item" :imagePath="app('suppliers_upload_path')" />

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
