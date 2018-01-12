@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $manufacturer->name }}
 {{ trans('general.manufacturer') }}
@parent
@stop

@section('header_right')
  <div class="btn-group pull-right">
     <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
     <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li><a href="{{ route('manufacturers.edit', $manufacturer->id) }}">{{ trans('admin/manufacturers/table.update') }}</a></li>
        <li><a href="{{ route('manufacturers.create') }}">{{ trans('admin/manufacturers/table.create') }}</a></li>
      </ul>
  </div>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">

      <ul class="nav nav-tabs">
        <li class="active">
          <a href="#assets" data-toggle="tab">Assets</a>
        </li>
        <li>
          <a href="#licenses" data-toggle="tab">Licenses</a>
        </li>
        <li>
          <a href="#accessories" data-toggle="tab">Accessories</a>
        </li>
        <li>
          <a href="#consumables" data-toggle="tab">Consumables</a>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane fade in active" id="assets">

          <table
                  name="manufacturerDetail-assets"
                  id="manufacturerDetail-assets"
                  class="table table-striped snipe-table"
                  data-search="true"
                  data-url="{{ route('api.assets.index', ['manufacturer_id' => $manufacturer->id, 'itemtype' => 'assets']) }}"
                  data-cookie-id-table="manufacturerDetail-assets"
                  data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}">
          </table>
        </div> <!-- /.tab-pane assets -->

        <div class="tab-pane fade" id="licenses">
          <table
                  name="manufacturerDetail-licenses"
                  id="manufacturerDetail-licenses"
                  class="table table-striped snipe-table"
                  data-search="true"
                  data-url="{{ route('api.licenses.index', ['manufacturer_id' => $manufacturer->id]) }}"
                  data-cookie-id-table="manufacturerDetail-licenses"
                  data-columns="{{ \App\Presenters\LicensePresenter::dataTableLayout() }}">
          </table>
        </div><!-- /.tab-pan licenses-->

        <div class="tab-pane fade" id="accessories">
          <table
                  name="manufacturerDetail-accessories"
                  id="manufacturerDetail-accessories"
                  class="table table-striped snipe-table"
                  data-search="true"
                  data-url="{{ route('api.accessories.index', ['manufacturer_id' => $manufacturer->id]) }}"
                  data-cookie-id-table="manufacturerDetail-accessories"
                  data-columns="{{ \App\Presenters\AccessoryPresenter::dataTableLayout() }}">
          </table>
        </div> <!-- /.tab-pan accessories-->

        <div class="tab-pane fade" id="consumables">


          <table
                  name="manufacturerDetail-consumables"
                  id="manufacturerDetail-consumables"
                  class="table table-striped snipe-table"
                  data-search="true"
                  data-url="{{ route('api.consumables.index', ['manufacturer_id' => $manufacturer->id]) }}"
                  data-cookie-id-table="manufacturerDetail-consumables"
                  data-columns="{{ \App\Presenters\ConsumablePresenter::dataTableLayout() }}">
          </table>

        </div> <!-- /.tab-pan consumables-->

      </div> <!-- /.tab-content -->
    </div>  <!-- /.nav-tabs-custom -->
  </div><!-- /. col-md-12 -->
</div> <!-- /.row -->
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'manufacturer' . $manufacturer->name . '-export', 'search' => false])

@stop
