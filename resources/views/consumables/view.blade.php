@extends('layouts/default')

{{-- Page title --}}
@section('title')
  {{ $consumable->name }}
  {{ trans('general.consumable') }} -
  ({{ trans('general.remaining_var', ['count' => $consumable->numRemaining()])  }})
  @parent
@endsection

@section('header_right')
    <x-button.info-panel-toggle/>
@endsection

{{-- Page content --}}
@section('content')

    <x-container columns="2">
        <x-page-column class="col-md-9 main-panel">
            <x-tabs>
                <x-slot:tabnav>

                    <x-tabs.nav-item
                            name="assigned"
                            class="active"
                            icon_type="checkedout"
                            label="{{ trans('general.assigned') }}"
                            count="{{ $consumable->numCheckedOut() }}"
                    />

                    <x-tabs.files-tab :item="$consumable" count="{{ $consumable->uploads()->count() }}"/>
                    <x-tabs.orders-tab count="{{ $consumable->ordersCount() }}"/>
                    <x-tabs.history-tab count="{{ $consumable->history()->count() }}" :model="$consumable"/>
                    <x-tabs.upload-tab :item="$consumable"/>

                </x-slot:tabnav>

                <x-slot:tabpanes>

                    <x-tabs.pane name="assigned">

                        <x-table
                            name="consumableCheckedOut" :presenter="\App\Presenters\ConsumablePresenter::checkedOut()"
                            :api_url="route('api.consumables.show.users', $consumable->id)"
                        />

                    </x-tabs.pane>

                    <x-tabs.pane name="files">
                        <x-table.files object_type="consumables" :object="$consumable"/>
                    </x-tabs.pane>

                    <!-- start orders tab pane -->
                    <x-tabs.pane name="orders">
                        <x-table.orders name="consumableOrders" :route="route('api.order-items.index', ['item_type' => \App\Models\Consumable::class, 'item_id' => $consumable->id])"/>
                    </x-tabs.pane>
                    <!-- end orders tab pane -->

                    <!-- start history tab pane -->
                    <x-tabs.pane name="history">
                        <x-table.history name="consumableHistory" :model="$consumable" :route="route('api.consumables.history', $consumable)" :hide_fields="['serial']"/>
                    </x-tabs.pane>
                    <!-- end history tab pane -->

                </x-slot:tabpanes>

            </x-tabs>
        </x-page-column>

        <x-page-column class="col-md-3">
            <x-box class="side-box expanded">
                <x-info-panel :infoPanelObj="$consumable" img_path="{{ app('consumables_upload_url') }}" :qr_code_url="route('qr_code/common', ['object_type' => 'consumables', 'id' => $consumable->id])">

                    <x-slot:buttons>
                        <x-button.edit :item="$consumable" :route="route('consumables.edit', $consumable->id)"/>
                        <x-button.clone :item="$consumable" :route="route('consumables.clone.create', $consumable->id)"/>
                        @can('update', $consumable)
                            @php $lastOrder = $consumable->lastOrderDefaults(); @endphp
                            <button type="button"
                                class="btn btn-sm btn-primary adjust-quantity"
                                data-tooltip="true"
                                title="{{ trans('general.adjust_quantity') }}"
                                data-adjust-url="{{ route('consumables.adjust-quantity', $consumable) }}"
                                data-item-name="{{ e($consumable->name) }}"
                                data-available="{{ (int) $consumable->numRemaining() }}"
                                @if ($lastOrder && $lastOrder['unit_cost'] !== null) data-last-unit-cost="{{ $lastOrder['unit_cost'] }}" @endif
                                @if ($lastOrder && $lastOrder['currency'] !== null) data-last-currency="{{ e($lastOrder['currency']) }}" @endif
                            >
                                <x-icon type="plus-minus" class="fa-fw" />
                                <span class="sr-only">{{ trans('general.adjust_quantity') }}</span>
                            </button>
                        @endcan
                        <x-button.delete :item="$consumable"/>
                        <x-button.checkout :item="$consumable" :route="route('consumables.checkout.show', $consumable->id)" />
                    </x-slot:buttons>

                </x-info-panel>
            </x-box>
        </x-page-column>
    </x-container>

@endsection

@section('moar_scripts')
    @can('files', $consumable)
        <x-modals.upload-file item-type="consumables" :item-id="$consumable->id" />
    @endcan

    @can('update', $consumable)
        <x-modals.adjust-quantity />
    @endcan

    @include ('partials.bootstrap-table', ['exportFile' => 'consumable-' . $consumable->name . '-export', 'search' => false])
@endsection

