@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.bulk_edit') }}
    @parent
@stop


{{-- Page content --}}
@section('content')
    <x-container class="col-md-8 col-md-offset-2">

        <x-form :route="route('categories.bulk.save')">

            <x-box>

                <x-callout type="warning" icon="warning" live="assertive">
                    {{ trans_choice('admin/categories/message.bulkedit.warn', count($categories), ['count' => count($categories)]) }}
                </x-callout>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">{{ trans('admin/categories/general.category_name') }}</th>
                            <th scope="col">{{ trans('general.type') }}</th>
                            <th class="text-center" scope="col">
                                <x-icon type="asset" :title="trans('general.assets')" />
                                <span class="sr-only">{{ trans('general.assets') }}</span>
                            </th>
                            <th class="text-center" scope="col">
                                <x-icon type="model" :title="trans('general.asset_models')" />
                                <span class="sr-only">{{ trans('general.asset_models') }}</span>
                            </th>
                            <th class="text-center" scope="col">
                                <x-icon type="accessory" :title="trans('general.accessories')" />
                                <span class="sr-only">{{ trans('general.accessories') }}</span>
                            </th>
                            <th class="text-center" scope="col">
                                <x-icon type="consumable" :title="trans('general.consumables')" />
                                <span class="sr-only">{{ trans('general.consumables') }}</span>
                            </th>
                            <th class="text-center" scope="col">
                                <x-icon type="component" :title="trans('general.components')" />
                                <span class="sr-only">{{ trans('general.components') }}</span>
                            </th>
                            <th class="text-center" scope="col">
                                <x-icon type="license" :title="trans('general.licenses')" />
                                <span class="sr-only">{{ trans('general.licenses') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->category_type ? \App\Helpers\Helper::categoryTypeList($category->category_type) : '' }}</td>
                                <td class="text-center {{ $category->assets_count ? '' : 'text-muted' }}">{{ number_format($category->assets_count) }}</td>
                                <td class="text-center {{ $category->models_count ? '' : 'text-muted' }}">{{ number_format($category->models_count) }}</td>
                                <td class="text-center {{ $category->accessories_count ? '' : 'text-muted' }}">{{ number_format($category->accessories_count) }}</td>
                                <td class="text-center {{ $category->consumables_count ? '' : 'text-muted' }}">{{ number_format($category->consumables_count) }}</td>
                                <td class="text-center {{ $category->components_count ? '' : 'text-muted' }}">{{ number_format($category->components_count) }}</td>
                                <td class="text-center {{ $category->licenses_count ? '' : 'text-muted' }}">{{ number_format($category->licenses_count) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <x-form.radio-row
                    name="require_acceptance"
                    :label="trans('admin/categories/general.import_require_acceptance')"
                    selected=""
                    :options="[
                        '' => trans('general.do_not_change'),
                        '1' => trans('general.yes'),
                        '0' => trans('general.no'),
                    ]"
                />

                <x-form.radio-row
                    name="use_default_eula"
                    :label="trans('admin/categories/general.use_default_eula_column')"
                    selected=""
                    :options="[
                        '' => trans('general.do_not_change'),
                        '1' => trans('general.yes'),
                        '0' => trans('general.no'),
                    ]"
                />

                <x-form.radio-row
                    name="checkin_email"
                    :label="trans('admin/categories/general.import_checkin_email')"
                    selected=""
                    :options="[
                        '' => trans('general.do_not_change'),
                        '1' => trans('general.yes'),
                        '0' => trans('general.no'),
                    ]"
                />

                <x-form.radio-row
                    name="alert_on_response"
                    :label="trans('admin/categories/general.import_alert_on_response')"
                    selected=""
                    :options="[
                        '' => trans('general.do_not_change'),
                        '1' => trans('general.yes'),
                        '0' => trans('general.no'),
                    ]"
                />

                <x-form.row
                    :label="trans('general.tag_color')"
                    name="tag_color"
                    :help_text="trans('general.tag_color_help')"
                >
                    <x-slot:input>
                        <x-input.colorpicker
                            name="tag_color"
                            id="tag_color"
                            :default="old('tag_color', '')"
                        />
                    </x-slot:input>
                </x-form.row>

                @foreach ($categories as $category)
                    <input type="hidden" name="ids[{{ $category->id }}]" value="{{ $category->id }}">
                @endforeach

            </x-box>

        </x-form>

    </x-container>
@stop
