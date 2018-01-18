@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.accessories') }}
@parent
@stop

@section('header_right')
    @can('create', \App\Models\Accessory::class)
        <a href="{{ route('accessories.create') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
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
          name="accessories"
          class="table table-striped snipe-table"
          id="table"
          data-url="{{route('api.accessories.index') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="accessoriesTable-{{ config('version.hash_version') }}">
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', [
    'exportFile' => 'accessories-export',
    'search' => true,
    'showFooter' => true,
    'columns' => \App\Presenters\AccessoryPresenter::dataTableLayout()
    ])
@stop
