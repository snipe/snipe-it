@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/manufacturers/table.asset_manufacturers') }} 
@parent
@stop

{{-- Page title --}}
@section('header_right')
<a href="{{ route('create/manufacturer') }}" class="btn btn-primary pull-right">
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
        data-url="{{route('api.manufacturers.list') }}"
        data-cookie="true"
        data-click-to-select="true"
        data-cookie-id-table="manufacturersTable-{{ config('version.hash_version') }}">
            <thead>
                <tr>
                    <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                    <th data-sortable="true" data-field="name">{{ trans('admin/manufacturers/table.name') }}</th>
                    <th data-switchable="true" data-searchable="false" data-sortable="false" data-field="assets">{{ trans('general.assets') }}</th>
                    <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
                </tr>
            </thead>
        </table>

      </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->


  </div>
</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'manufacturers-export', 'search' => true])
@stop
