@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/manufacturers/table.asset_manufacturers') }} 
@parent
@stop

{{-- Page title --}}
@section('header_right')
  @can('create', \App\Models\Manufacturer::class)
    <a href="{{ route('manufacturers.create') }}" class="btn btn-primary pull-right">
    {{ trans('general.create') }}</a>
  @endcan

  @if (Request::get('deleted')=='true')
    <a class="btn btn-default pull-right" href="{{ route('manufacturers.index') }}" style="margin-right: 5px;">{{ trans('general.show_current') }}</a>
  @else
    <a class="btn btn-default pull-right" href="{{ route('manufacturers.index', ['deleted' => 'true']) }}" style="margin-right: 5px;">
      {{ trans('general.show_deleted') }}</a>
  @endif

@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">

          <table
            data-columns="{{ \App\Presenters\ManufacturerPresenter::dataTableLayout() }}"
            data-cookie-id-table="manufacturersTable"
            data-pagination="true"
            data-id-table="manufacturersTable"
            data-search="true"
            data-show-footer="true"
            data-side-pagination="server"
            data-show-columns="true"
            data-show-export="true"
            data-show-refresh="true"
            data-sort-order="asc"
            id="manufacturersTable"
            class="table table-striped snipe-table"
            data-url="{{route('api.manufacturers.index', ['deleted' => e(Request::get('deleted')) ]) }}"
            data-export-options='{
              "fileName": "export-manufacturers-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>

          </table>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>

@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop
