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

        @if (($inventory->coords!='') && (config('services.yandex.maps_api_key')))
            <div class="row">
                <div lass="col-md-12">
                <div id="map" style="width: 100%; height: 500px; padding: 0; margin: 0;"></div>
                </div>
            </div>
            <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey={{config('services.yandex.maps_api_key')}}" type="text/javascript"></script>
            <script type="text/javascript">
                ymaps.ready(init);
                function init() {
                    var myMap = new ymaps.Map("map", {
                            center: [{{$inventory->coords}}],
                            zoom: 13
                        });
                    myMap.geoObjects
                        .add(new ymaps.Placemark([{{$inventory->coords}}], {
                            balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
                        }, {
                            preset: 'islands#icon',
                            iconColor: '#0095b6'
                        }));
                }

            </script>
        @endif

            @if ($inventory->responsible_photo)
                <div class="row">
                    <a href="{{$inventory->responsible_photo_url()}}" data-lightbox="inv">
                    <img src="{{$inventory->responsible_photo_url()}}" class="img-responsive img-thumbnail">
                    </a>
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
