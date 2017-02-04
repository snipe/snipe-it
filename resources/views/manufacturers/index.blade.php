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
            <thead>
              <tr>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-sortable="true" data-field="name" data-formatter="manufacturersLinkFormatter">
                  {{ trans('admin/manufacturers/table.name') }}</th>
                <th data-switchable="true" data-searchable="false" data-sortable="false" data-field="assets_count">{{ trans('general.assets') }}</th>
                <th data-switchable="true" data-searchable="false" data-sortable="false" data-field="licenses_count">{{ trans('general.licenses') }}</th>
                <th data-switchable="true" data-searchable="false" data-sortable="false" data-field="accessories_count">{{ trans('general.accessories') }}</th>
                <th data-switchable="true" data-searchable="false" data-sortable="false" data-field="consumables_count">{{ trans('general.consumables') }}</th>
                <th data-formatter="manufacturersActionsFormatter" data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
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
