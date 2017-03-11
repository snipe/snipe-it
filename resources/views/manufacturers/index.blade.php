@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/manufacturers/table.asset_manufacturers') }} 
@parent
@stop

{{-- Page title --}}
@section('header_right')
<a href="{{ route('manufacturers.create') }}" class="btn btn-primary pull-right">
  {{ trans('general.create') }}</a>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">
          <table
          name="manufacturers"
          class="table table-striped snipe-table"
          id="table"
          data-url="{{route('api.manufacturers.index') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="manufacturersTable-{{ config('version.hash_version') }}">

          </table>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>

@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table',
      ['exportFile' => 'manufacturers-export',
      'search' => true,
      'columns' => \App\Presenters\ManufacturerPresenter::dataTableLayout()
  ])
@stop
