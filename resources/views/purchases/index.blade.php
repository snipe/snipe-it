@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.purchase_orders') }}
@parent
@stop

@section('header_right')
    @can('create', \App\Models\PurchaseOrder::class)
        <a href="{{ route('accessories.create') }}" accesskey="n" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
    @endcan
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">

    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">

            <table
                data-columns="{{ \App\Presenters\PurchasePresenter::dataTableLayout() }}"
                data-cookie-id-table="purchasesTable"
                data-pagination="true"
                data-id-table="purchasesTable"
                data-search="true"
                data-side-pagination="server"
                data-show-columns="true"
                data-show-fullscreen="true"
                data-show-export="true"
                data-show-refresh="true"
                data-show-footer="true"
                data-sort-order="asc"
                id="purchasesTable"
                class="table table-striped snipe-table"
                data-url="{{route('api.purchases.index') }}"
                data-export-options='{
                    "fileName": "export-accessories-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')
@stop
