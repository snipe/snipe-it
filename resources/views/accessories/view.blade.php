@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $accessory->name }}
 {{ trans('general.accessory') }}
 @if ($accessory->model_number!='')
     ({{ $accessory->model_number }})
 @endif

@parent
@stop

@section('header_right')
    <x-button.info-panel-toggle/>
@endsection

{{-- Page content --}}
@section('content')
    <x-container columns="2">
        <x-page-column class="col-md-9 main-panel">


            <x-tabs>
                <x-slot:tabnav>
                    <x-tabs.checkedout-tab :item="$accessory" count="{{ $accessory->checkouts_count }}" />
                    <x-tabs.files-tab :item="$accessory" count="{{ $accessory->uploads()->count() }}"/>
                    <x-tabs.orders-tab count="{{ $accessory->ordersCount() }}"/>
                    <x-tabs.history-tab count="{{ $accessory->history()->count() }}" :model="$accessory"/>
                    <x-tabs.upload-tab :item="$accessory"/>
                </x-slot:tabnav>

                <x-slot:tabpanes>

                    <!-- start assigned tab pane -->
                    <x-tabs.pane name="assigned">
                        <x-slot:table_header>
                            {{ trans('general.checked_out') }}
                        </x-slot:table_header>

                        <x-table
                            name="accessoryCheckedOut" api_url="{{ route('api.accessories.checkedout', $accessory->id) }}"
                            :presenter="\App\Presenters\AccessoryPresenter::assignedDataTableLayout()"
                            export_filename="export-{{ str_slug($accessory->name) }}-assets-{{ date('Y-m-d') }}"
                        />

                    </x-tabs.pane>
                    <!-- end assigned tab pane -->

                    <!-- start orders tab pane -->
                    <x-tabs.pane name="orders">
                        <x-table.orders name="accessoryOrders" :route="route('api.order-items.index', ['item_type' => \App\Models\Accessory::class, 'item_id' => $accessory->id])"/>
                    </x-tabs.pane>
                    <!-- end orders tab pane -->

                    <!-- start history tab pane -->
                    <x-tabs.pane name="history">
                        <x-table.history name="accessoryHistory" :model="$accessory" :route="route('api.accessories.history', $accessory)" :hide_fields="['serial']"/>
                    </x-tabs.pane>
                    <!-- end history tab pane -->

                    <!-- start files tab pane -->
                    <x-tabs.pane name="files">
                        <x-table.files object_type="accessories" :object="$accessory"/>
                    </x-tabs.pane>
                    <!-- end files tab pane -->
                </x-slot:tabpanes>

            </x-tabs>

        </x-page-column>

        <x-page-column class="col-md-3">
            <x-box class="side-box expanded">
                <x-info-panel :infoPanelObj="$accessory" img_path="{{ app('accessories_upload_url') }}" :qr_code_url="route('qr_code/common', ['object_type' => 'accessories', 'id' => $accessory->id])">
                    <x-slot:buttons>
                        <x-button.edit :item="$accessory" :route="route('accessories.edit', $accessory->id)"/>
                        <x-button.clone :item="$accessory" :route="route('clone/accessories', $accessory->id)"/>
                        <x-button.checkout permission="checkout" :item="$accessory" :route="route('accessories.checkout.show', $accessory->id)" />
                        @can('update', $accessory)
                            @php $lastOrder = $accessory->lastOrderDefaults(); @endphp
                            <button type="button"
                                class="btn btn-sm btn-primary adjust-quantity"
                                data-tooltip="true"
                                title="{{ trans('general.adjust_quantity') }}"
                                data-adjust-url="{{ route('accessories.adjust-quantity', $accessory) }}"
                                data-item-name="{{ e($accessory->name) }}"
                                data-available="{{ (int) $accessory->numRemaining() }}"
                                @if ($lastOrder && $lastOrder['unit_cost'] !== null) data-last-unit-cost="{{ $lastOrder['unit_cost'] }}" @endif
                                @if ($lastOrder && $lastOrder['currency'] !== null) data-last-currency="{{ e($lastOrder['currency']) }}" @endif
                            >
                                <x-icon type="plus-minus" class="fa-fw" />
                                <span class="sr-only">{{ trans('general.adjust_quantity') }}</span>
                            </button>
                        @endcan
                        <x-button.delete :item="$accessory" />
                    </x-slot:buttons>
                </x-info-panel>
            </x-box>

        </x-page-column>
    </x-container>

@endsection



@section('moar_scripts')
    @can('files', $accessory)
        <x-modals.upload-file item-type="accessories" :item-id="$accessory->id" />
    @endcan

    @can('update', $accessory)
        <x-modals.adjust-quantity />
    @endcan

@include ('partials.bootstrap-table')
@endsection
