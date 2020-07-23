@extends('layouts/default')

{{-- Page title --}}
@section('title')

 Инвентаризация -
 {{ $inventory->name }}
 
@parent
@stop

@section('header_right')
{{--<a href="{{ route('locations.edit', ['location' => $inventory->id]) }}" class="btn btn-sm btn-primary pull-right">{{ trans('admin/locations/table.update') }} </a>--}}
@stop

{{-- Page content --}}
@section('content')

<div class="row">
    <div class="col-md-9">
        <div class="box box-default">
            <div class="box-header with-border">
                <div class="box-heading">
                    <h2 class="box-title">Активы</h2>
                </div>
            </div>
            <div class="box-body">
            <div class="table table-responsive">
                <table
                        data-columns="{{ \App\Presenters\InventoryItemPresenter::dataTableLayout() }}"
                        data-cookie-id-table="inventoryItemsTable"
                        data-pagination="true"
                        data-id-table="inventoryItems"
                        data-search="true"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-export="true"
                        data-show-refresh="true"
                        data-sort-order="asc"
                        id="inventoryItemsTable"
                        class="table table-striped snipe-table"
                        data-url="{{route('api.inventory_items.index', ['inventory_id' => $inventory->id])}}">
                </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.box-body -->
        </div> <!--/.box-->
    </div><!--/.col-md-9-->
    <div class="col-md-3">

        @if (($inventory->coords!='') && (config('services.google.maps_api_key')))
            <div class="col-md-12 text-center">
                <img src="https://static-maps.yandex.ru/1.x/?ll={{ $inventory->coords}}&size=500,300&z=15&l=map&pt=37.620070,55.753630,pmwtm1~37.64,55.76363,pmwtm99" class="img-responsive img-thumbnail" alt="Map">
            </div>
        @endif

            @if ($inventory->responsible_photo)
                <div class="col-md-12 text-center">
                    <img src="{{$inventory->responsible_photo_url()}}" class="img-responsive img-thumbnail" alt="Map">
                </div>
            @endif
    </div><!--/.col-md-3-->
</div>



@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table', [
    'exportFile' => 'locations-export',
    'search' => true
 ])

@stop
