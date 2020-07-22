@extends('layouts/default')

{{-- Page title --}}
@section('title')

 Закупка -
 {{ $purchase->invoice_number }}
 
@parent
@stop

@section('header_right')
{{--<a href="{{ route('locations.edit', ['location' => $inventory->id]) }}" class="btn btn-sm btn-primary pull-right">{{ trans('admin/locations/table.update') }} </a>--}}
@stop

{{-- Page content --}}
@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="box box-default">
            <div class="box-header with-border">
                <div class="box-heading">
                    <h2 class="box-title">Активы</h2>
                </div>
            </div>
            <div class="box-body">
            <div class="table table-responsive">
                <table
                        data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                        data-cookie-id-table="assetsListingTable"
                        data-pagination="true"
                        data-id-table="assetsListingTable"
                        data-search="true"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-export="true"
                        data-show-refresh="true"
                        data-sort-order="asc"
                        id="assetsListingTable"
                        class="table table-striped snipe-table"
                        data-url="{{route('api.assets.index', ['purchase_id' => $purchase->id]) }}"
                        data-export-options='{
                              "fileName": "export-locations-{{ str_slug($purchase->invoice_number) }}-assets-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.box-body -->
        </div> <!--/.box-->
        @if ($purchase->status!='paid')
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-heading">
                        <h2 class="box-title">Расходники</h2>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table table-responsive">
                        <table id="table_consumables" class="table table-striped snipe-table"></table>
                    </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
            </div> <!--/.box-->
        @else
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-heading">
                        <h2 class="box-title">Расходники</h2>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table table-responsive">
                        <table
                                data-columns="{{ \App\Presenters\ConsumablePresenter::dataTableLayout() }}"
                                data-cookie-id-table="consumablesTable"
                                data-pagination="true"
                                data-id-table="consumablesTable"
                                data-search="true"
                                data-side-pagination="server"
                                data-show-columns="true"
                                data-show-export="true"
                                data-show-footer="true"
                                data-show-refresh="true"
                                data-sort-order="asc"
                                data-sort-name="name"
                                data-toolbar="#toolbar"
                                id="consumablesTable"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.consumables.index', ['purchase_id' => $purchase->id]) }}">
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
            </div> <!--/.box-->
        @endif
    </div><!--/.col-md-9-->
    <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <div class="box-heading">
                    <h2 class="box-title">Информация</h2>
                </div>
            </div>
            <div class="box-body">
                @if ($purchase->invoice_number)
                    <div class="row">
                        <div class="col-md-6">
                            <strong>
                                {{ trans('general.order_number') }}
                            </strong>
                        </div>
                        <div class="col-md-6">
                            {{ $purchase->invoice_number }}
                        </div>
                    </div>
                @endif
                @if ($purchase->invoice_file)
                        <div class="row">
                            <div class="col-md-6">
                                <strong>
                                    Счет
                                </strong>
                            </div>
                            <div class="col-md-6">
                                {{ $purchase->invoice_file }}
                            </div>
                        </div>
                    @endif
                    @if ($purchase->bitrix_id)
                        <div class="row">
                            <div class="col-md-6">
                                <strong>
                                    Bitrix id
                                </strong>
                            </div>
                            <div class="col-md-6">
                                {{ $purchase->bitrix_id }}
                            </div>
                        </div>
                    @endif
                    @if ($purchase->final_price)
                        <div class="row">
                            <div class="col-md-6">
                                <strong>
                                    Цена
                                </strong>
                            </div>
                            <div class="col-md-6">
                                {{ $purchase->final_price }}
                            </div>
                        </div>
                    @endif
                @if ($purchase->supplier)
                    <div class="row">
                        <div class="col-md-6">
                            <strong>
                                {{ trans('general.supplier') }}
                            </strong>
                        </div>
                        <div class="col-md-6">
                            @can ('superuser')
                                <a href="{{ route('suppliers.show', $purchase->supplier_id) }}">
                                    {{ $purchase->supplier->name }}
                                </a>
                            @else
                                {{ $purchase->supplier->name }}
                            @endcan
                        </div>
                    </div>
                @endif
                    @if ($purchase->paid)
                        <div class="row">
                            <div class="col-md-6">
                                <strong>
                                    Оплачено
                                </strong>
                            </div>
                            <div class="col-md-6">
                                {{ $purchase->paid }}
                            </div>
                        </div>
                    @endif
                    @if ($purchase->comment)
                        <div class="row">
                            <div class="col-md-6">
                                <strong>
                                    Комментарий
                                </strong>
                            </div>
                            <div class="col-md-6">
                                {{ $purchase->comment }}
                            </div>
                        </div>
                    @endif
            </div><!-- /.box-body -->
        </div> <!--/.box-->
    </div>
</div>



@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table', [
    'exportFile' => 'locations-export',
    'search' => true
 ])

    <script nonce="{{ csrf_token() }}">

        var table_consumables = $('#table_consumables');
        var data = '{!! $purchase->consumables_json !!}';
        data = JSON.parse(data);
        $(function() {
            console.log(data);
            table_consumables.bootstrapTable('destroy').bootstrapTable({
                data: data,
                search:true,
                toolbar:'#toolbar_consumables',
                columns: [{
                    field: 'id',
                    name:'#',
                    align: 'left',
                    valign: 'middle'
                },{
                    field: 'name',
                    name:'Назвние',
                    align: 'left',
                    valign: 'middle'
                },{
                    field: 'manufacturer_name',
                    name:'Производитель',
                    align: 'left',
                    valign: 'middle'
                },{
                    field: 'category_name',
                    name:'Категория',
                    align: 'left',
                    valign: 'middle'
                },{
                    field: 'model_number',
                    name:'Модель',
                    align: 'left',
                    valign: 'middle'
                },{
                    field: 'purchase_cost',
                    name: 'Закупочная цена',
                    align: 'center',
                    valign: 'middle'
                },{
                    field: 'nds',
                    name: 'НДС',
                    align: 'center',
                    valign: 'middle'
                },{
                    field: 'quantity',
                    name: 'Количество',
                    align: 'center',
                    valign: 'middle'
                },{
                    align: 'center',
                    valign: 'middle',
                    events: {
                        'click .remove': function (e, value, row, index) {
                            table_consumables.bootstrapTable('remove', {
                                field: 'id',
                                values: [row.id]
                            });
                            var data = table_consumables.bootstrapTable('getData');
                            var newData = [];
                            var count = 0 ;
                            data.forEach(function callback(currentValue, index, array) {
                                count++;
                                currentValue.id = count;
                                newData.push(currentValue);
                            });
                            table_consumables.bootstrapTable('load',newData);
                        }
                    },
                    formatter: function (value, row, index) {
                        return [
                            '<a class="remove text-danger"  href="javascript:void(0)" title="Убрать">',
                            '<i class="remove fa fa-times fa-lg"></i>',
                            '</a>'
                        ].join('')
                    }
                }]
            });
        })
    </script>

@stop
