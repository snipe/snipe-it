@extends('layouts/default')

{{-- Page title --}}
@section('title')
 {{ $component->name }}
 {{ trans('general.component') }}
@parent
@stop

@section('header_right')
    <x-button.info-panel-toggle/>
@endsection

@section('content')
<x-container columns="2">
        <x-page-column class="col-md-9 main-panel">
            <x-tabs>
                <x-slot:tabnav>

                    <x-tabs.nav-item
                            name="assigned"
                            icon_type="checkedout"
                            label="{{ trans('general.assigned') }}"
                            count="{{ $snipe_component->numCheckedOut() }}"
                    />

                    <x-tabs.files-tab :item="$snipe_component" count="{{ $snipe_component->uploads()->count() }}"/>
                    <x-tabs.orders-tab count="{{ $snipe_component->ordersCount() }}"/>
                    <x-tabs.history-tab count="{{ $snipe_component->history()->count() }}" :model="$snipe_component"/>
                    <x-tabs.upload-tab :item="$snipe_component"/>

                </x-slot:tabnav>

                <x-slot:tabpanes>

                    <x-tabs.pane name="assigned">

                        <x-slot:table_header>
                            {{ trans('general.assigned') }}
                        </x-slot:table_header>

                        @can('checkin', $snipe_component)
                            <x-slot:bulkactions>
                                <x-table.bulk-actions
                                    name="componentCheckedOut"
                                    :action_route="route('components.bulkcheckin.selected')"
                                    model_name="components_asset"
                                    :actions="[
                                        'checkin' => ['label' => trans('general.checkin')],
                                    ]"
                                />
                            </x-slot:bulkactions>
                        @endcan

                        <x-table
                            name="componentCheckedOut" :presenter="\App\Presenters\ComponentPresenter::checkedOut()"
                            :api_url="route('api.components.assets', $snipe_component)"
                        />

                    </x-tabs.pane>

                    <!-- start files tab pane -->
                    <x-tabs.pane name="files">
                        <x-table.files object_type="components" :object="$snipe_component"/>
                    </x-tabs.pane>

                    <!-- start orders tab pane -->
                    <x-tabs.pane name="orders">
                        <x-table.orders name="componentOrders" :route="route('api.order-items.index', ['item_type' => \App\Models\Component::class, 'item_id' => $snipe_component->id])"/>
                    </x-tabs.pane>

                    <!-- start history tab pane -->
                    <x-tabs.pane name="history">
                        <x-table.history name="componentHistory" :model="$snipe_component" :route="route('api.components.history', $snipe_component)"/>
                    </x-tabs.pane>

                </x-slot:tabpanes>
            </x-tabs>
        </x-page-column>
        <x-page-column class="col-md-3">

            <x-box class="side-box expanded">
                <x-info-panel :infoPanelObj="$snipe_component" img_path="{{ app('components_upload_url') }}" :qr_code_url="route('qr_code/common', ['object_type' => 'components', 'id' => $snipe_component->id])">

                    <x-slot:buttons>
                        <x-button.edit :item="$snipe_component" :route="route('components.edit', $snipe_component->id)"/>
                        <x-button.clone :item="$snipe_component" :route="route('components.clone.create', $snipe_component->id)"/>
                        <x-button.checkout :item="$snipe_component" :route="route('components.checkout.show', $snipe_component->id)" />
                        @can('update', $snipe_component)
                            @php $lastOrder = $snipe_component->lastOrderDefaults(); @endphp
                            <button type="button"
                                class="btn btn-sm btn-primary adjust-quantity"
                                data-tooltip="true"
                                title="{{ trans('general.adjust_quantity') }}"
                                data-adjust-url="{{ route('components.adjust-quantity', $snipe_component) }}"
                                data-item-name="{{ e($snipe_component->name) }}"
                                data-available="{{ (int) $snipe_component->numRemaining() }}"
                                @if ($lastOrder && $lastOrder['unit_cost'] !== null) data-last-unit-cost="{{ $lastOrder['unit_cost'] }}" @endif
                                @if ($lastOrder && $lastOrder['currency'] !== null) data-last-currency="{{ e($lastOrder['currency']) }}" @endif
                            >
                                <x-icon type="plus-minus" class="fa-fw" />
                                <span class="sr-only">{{ trans('general.adjust_quantity') }}</span>
                            </button>
                        @endcan
                        <x-button.delete :item="$snipe_component" />
                    </x-slot:buttons>

                </x-info-panel>
            </x-box>
        </x-page-column>
    </x-container>

@endsection



@section('moar_scripts')
    @can('files', $snipe_component)
        <x-modals.upload-file item-type="components" :item-id="$snipe_component->id" />
    @endcan

    @can('update', $snipe_component)
        <x-modals.adjust-quantity />
    @endcan

    @include ('partials.bootstrap-table', ['exportFile' => 'component' . $snipe_component->name . '-export', 'search' => false])
@endsection
