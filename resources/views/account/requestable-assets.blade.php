@extends('layouts/default')

@section('title0')
  {{ trans('general.requestable_items') }}
@stop

{{-- Page title --}}
@section('title')
    @yield('title0')  @parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
    <div class="col-md-12">

        @php ($totalCount = array_sum($counts))
        @php ($firstVisible = collect(['assets', 'models', 'accessories', 'consumables', 'components', 'licenses'])->first(fn ($k) => ($counts[$k] ?? 0) > 0))

        @if ($totalCount < 1)

            <div class="col-md-12">
                <x-alert type="info" icon="info" :title="trans('general.notification_info')">
                    {{ trans('general.no_requestable') }}
                </x-alert>
            </div>

        @else
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                @if ($counts['assets'] > 0)
                <li>
                    <a href="#assets" data-toggle="tab" title="{{ trans('general.assets') }}">{{ trans('general.assets') }}
                        <span class="badge badge-secondary"> {{ $counts['assets'] }}</span>
                    </a>
                </li>
                @endif
                @if ($counts['models'] > 0)
                <li>
                    <a href="#models" data-toggle="tab" title="{{ trans('general.asset_models') }}">{{ trans('general.asset_models') }}
                        <span class="badge badge-secondary"> {{ $counts['models'] }}</span>
                    </a>
                </li>
                @endif
                @if ($counts['accessories'] > 0)
                <li>
                    <a href="#accessories" data-toggle="tab" title="{{ trans('general.accessories') }}">{{ trans('general.accessories') }}
                        <span class="badge badge-secondary"> {{ $counts['accessories'] }}</span>
                    </a>
                </li>
                @endif
                @if ($counts['consumables'] > 0)
                <li>
                    <a href="#consumables" data-toggle="tab" title="{{ trans('general.consumables') }}">{{ trans('general.consumables') }}
                        <span class="badge badge-secondary"> {{ $counts['consumables'] }}</span>
                    </a>
                </li>
                @endif
                @if ($counts['components'] > 0)
                <li>
                    <a href="#components" data-toggle="tab" title="{{ trans('general.components') }}">{{ trans('general.components') }}
                        <span class="badge badge-secondary"> {{ $counts['components'] }}</span>
                    </a>
                </li>
                @endif
                @if ($counts['licenses'] > 0)
                <li>
                    <a href="#licenses" data-toggle="tab" title="{{ trans('general.licenses') }}">{{ trans('general.licenses') }}
                        <span class="badge badge-secondary"> {{ $counts['licenses'] }}</span>
                    </a>
                </li>
                @endif
            </ul>
            <div class="tab-content">
                @if ($counts['assets'] > 0)
                <div class="tab-pane fade" id="assets">
                    <div class="row">
                        <div class="col-md-12">
                            <table
                                data-cookie-id-table="requestableAssetsListingTable"
                                data-id-table="requestableAssetsListingTable"
                                data-side-pagination="server"
                                data-show-export="false"
                                data-show-footer="false"
                                data-sort-order="asc"
                                data-sort-name="name"
                                data-toolbar="#assetsBulkEditToolbar"
                                data-bulk-button-id="#bulkAssetEditButton"
                                data-bulk-form-id="#assetsBulkForm"
                                id="assetsListingTable"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.assets.requestable', ['requestable' => true]) }}">

                                <thead>
                                    <tr>
                                        <th scope="col" class="col-md-1" data-field="image" data-formatter="imageFormatter" data-sortable="true">{{ trans('general.image') }}</th>
                                        <th scope="col" class="col-md-2" data-field="asset_tag" data-sortable="true" >{{ trans('general.asset_tag') }}</th>
                                        <th scope="col" class="col-md-2" data-field="model" data-sortable="true">{{ trans('admin/hardware/table.asset_model') }}</th>
                                        <th scope="col" class="col-md-2" data-field="model_number" data-sortable="true">{{ trans('admin/models/table.modelnumber') }}</th>
                                        <th scope="col" class="col-md-2" data-field="name" data-sortable="true">{{ trans('admin/hardware/form.name') }}</th>
                                        <th scope="col" class="col-md-3" data-field="serial" data-sortable="true">{{ trans('admin/hardware/table.serial') }}</th>
                                        <th scope="col" class="col-md-2" data-field="location" data-sortable="true">{{ trans('admin/hardware/table.location') }}</th>
                                        <th scope="col" class="col-md-2" data-field="status" data-sortable="true">{{ trans('admin/hardware/table.status') }}</th>
                                        <th scope="col" class="col-md-2" data-field="expected_checkin" data-formatter="dateDisplayFormatter" data-sortable="true">{{ trans('admin/hardware/form.expected_checkin') }}</th>

                                        @foreach(\App\Models\CustomField::get() as $field)
                                            @if (($field->field_encrypted=='0') && ($field->show_in_requestable_list=='1'))
                                                <th scope="col" class="col-md-2" data-field="custom_fields.{{ $field->db_column }}" data-sortable="true">{{ $field->name }}</th>
                                            @endif
                                        @endforeach
                                        <th scope="col" class="col-md-1" data-formatter="assetRequestActionsFormatter" data-field="actions" data-sortable="false">{{ trans('table.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                @if ($counts['models'] > 0)
                <div class="tab-pane fade" id="models">
                    <div class="row">
                        <div class="col-md-12">
                            <table
                                data-cookie-id-table="requestableAssetModelsListingTable"
                                data-id-table="requestableAssetModelsListingTable"
                                data-side-pagination="server"
                                data-show-export="false"
                                data-show-footer="false"
                                data-sort-order="asc"
                                data-sort-name="name"
                                id="assetModelsListingTable"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.assetmodels.requestable') }}">
                                <thead>
                                    <tr>
                                        <th scope="col" class="col-md-1" data-field="image" data-formatter="imageFormatter" data-sortable="false">{{ trans('general.image') }}</th>
                                        <th scope="col" class="col-md-6" data-field="name" data-formatter="assetmodelRequestableNameFormatter" data-sortable="true">{{ trans('admin/hardware/table.asset_model') }}</th>
                                        <th scope="col" class="col-md-3" data-field="remaining" data-sortable="true">{{ trans('admin/accessories/general.remaining') }}</th>
                                        <th scope="col" class="col-md-2 actions" data-field="actions" data-formatter="assetmodelRequestableActionsFormatter" data-sortable="false">{{ trans('table.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                @if ($counts['accessories'] > 0)
                <div class="tab-pane fade" id="accessories">
                    <div class="row">
                        <div class="col-md-12">
                            <table
                                data-cookie-id-table="requestableAccessoriesListingTable"
                                data-id-table="requestableAccessoriesListingTable"
                                data-side-pagination="server"
                                data-show-export="false"
                                data-show-footer="false"
                                data-sort-order="asc"
                                data-sort-name="name"
                                id="accessoriesListingTable"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.accessories.requestable') }}">
                                <thead>
                                    <tr>
                                        <th scope="col" class="col-md-1" data-field="image" data-formatter="imageFormatter" data-sortable="false">{{ trans('general.image') }}</th>
                                        <th scope="col" class="col-md-5" data-field="name" data-formatter="accessoryRequestableNameFormatter" data-sortable="true">{{ trans('admin/accessories/general.accessory_name') }}</th>
                                        <th scope="col" class="col-md-2" data-field="location" data-formatter="locationsLinkObjFormatter" data-sortable="true">{{ trans('admin/hardware/table.location') }}</th>
                                        <th scope="col" class="col-md-2" data-field="remaining_qty" data-sortable="true">{{ trans('admin/accessories/general.remaining') }}</th>
                                        <th scope="col" class="col-md-2 actions" data-field="actions" data-formatter="accessoryRequestableActionsFormatter" data-sortable="false">{{ trans('table.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                @if ($counts['consumables'] > 0)
                <div class="tab-pane fade" id="consumables">
                    <div class="row">
                        <div class="col-md-12">
                            <table
                                data-cookie-id-table="requestableConsumablesListingTable"
                                data-id-table="requestableConsumablesListingTable"
                                data-side-pagination="server"
                                data-show-export="false"
                                data-show-footer="false"
                                data-sort-order="asc"
                                data-sort-name="name"
                                id="consumablesListingTable"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.consumables.requestable') }}">
                                <thead>
                                    <tr>
                                        <th scope="col" class="col-md-1" data-field="image" data-formatter="imageFormatter" data-sortable="false">{{ trans('general.image') }}</th>
                                        <th scope="col" class="col-md-5" data-field="name" data-formatter="consumableRequestableNameFormatter" data-sortable="true">{{ trans('general.name') }}</th>
                                        <th scope="col" class="col-md-2" data-field="location" data-formatter="locationsLinkObjFormatter" data-sortable="true">{{ trans('admin/hardware/table.location') }}</th>
                                        <th scope="col" class="col-md-2" data-field="remaining" data-sortable="true">{{ trans('admin/accessories/general.remaining') }}</th>
                                        <th scope="col" class="col-md-2 actions" data-field="actions" data-formatter="consumableRequestableActionsFormatter" data-sortable="false">{{ trans('table.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                @if ($counts['components'] > 0)
                <div class="tab-pane fade" id="components">
                    <div class="row">
                        <div class="col-md-12">
                            <table
                                data-cookie-id-table="requestableComponentsListingTable"
                                data-id-table="requestableComponentsListingTable"
                                data-side-pagination="server"
                                data-show-export="false"
                                data-show-footer="false"
                                data-sort-order="asc"
                                data-sort-name="name"
                                id="componentsListingTable"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.components.requestable') }}">
                                <thead>
                                    <tr>
                                        <th scope="col" class="col-md-1" data-field="image" data-formatter="imageFormatter" data-sortable="false">{{ trans('general.image') }}</th>
                                        <th scope="col" class="col-md-5" data-field="name" data-formatter="componentRequestableNameFormatter" data-sortable="true">{{ trans('general.name') }}</th>
                                        <th scope="col" class="col-md-2" data-field="location" data-formatter="locationsLinkObjFormatter" data-sortable="true">{{ trans('admin/hardware/table.location') }}</th>
                                        <th scope="col" class="col-md-2" data-field="remaining" data-sortable="true">{{ trans('admin/accessories/general.remaining') }}</th>
                                        <th scope="col" class="col-md-2 actions" data-field="actions" data-formatter="componentRequestableActionsFormatter" data-sortable="false">{{ trans('table.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                @if ($counts['licenses'] > 0)
                <div class="tab-pane fade" id="licenses">
                    <div class="row">
                        <div class="col-md-12">
                            <table
                                data-cookie-id-table="requestableLicensesListingTable"
                                data-id-table="requestableLicensesListingTable"
                                data-side-pagination="server"
                                data-show-export="false"
                                data-show-footer="false"
                                data-sort-order="asc"
                                data-sort-name="name"
                                id="licensesListingTable"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.licenses.requestable') }}">
                                <thead>
                                    <tr>
                                        <th scope="col" class="col-md-6" data-field="name" data-formatter="licenseRequestableNameFormatter" data-sortable="true">{{ trans('general.name') }}</th>
                                        <th scope="col" class="col-md-2" data-field="category" data-formatter="categoriesLinkObjFormatter" data-sortable="true">{{ trans('general.category') }}</th>
                                        <th scope="col" class="col-md-2" data-field="free_seats_count" data-sortable="true">{{ trans('admin/accessories/general.remaining') }}</th>
                                        <th scope="col" class="col-md-2 actions" data-field="actions" data-formatter="licenseRequestableActionsFormatter" data-sortable="false">{{ trans('table.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

            </div> <!-- .tab-content-->
        </div> <!-- .nav-tabs-custom -->

        @endif
    </div> <!-- .col-md-12> -->
</div> <!-- .row -->

<x-modals.request-item />
@stop


@section('moar_scripts')
    @include ('partials.bootstrap-table', [
        'exportFile' => 'requested-export',
        'search' => true,
        'clientSearch' => true,
    ])

    <script nonce="{{ csrf_token() }}">
        $(function () {
            // Restore active tab from URL hash if present, otherwise
            // open the first tab that has content. Prevents landing on
            // a hidden tab when the requester was redirected back with
            // #accessories (or similar) after a request/cancel POST.
            var initial = window.location.hash && window.location.hash.length > 1
                ? window.location.hash.substring(1)
                : @json($firstVisible);
            var $trigger = $('.nav-tabs a[href="#' + initial + '"]');
            if ($trigger.length === 0) {
                $trigger = $('.nav-tabs a').first();
            }
            $trigger.tab('show');
        });
    </script>
@stop
