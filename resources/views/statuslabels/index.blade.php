@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/statuslabels/table.title') }}
@parent
@stop

@section('header_right')
<a href="{{ route('create/statuslabel') }}" class="btn btn-primary pull-right">
{{ trans('general.create') }}</a>
@stop
{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">

          <table
          name="statuslabels"
          id="table"
          class="snipe-table"
          data-url="{{ route('api.statuslabels.list') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="statuslabelsTable-{{ config('version.hash_version') }}">
            <thead>
              <tr>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-sortable="true" data-field="name">{{ trans('admin/statuslabels/table.name') }}</th>
                <th data-sortable="false" data-field="type">{{ trans('admin/statuslabels/table.status_type') }}</th>
                <th data-sortable="false" data-field="color">{{ trans('admin/statuslabels/table.color') }}</th>
                <th data-sortable="true" data-field="show_in_nav">{{ trans('admin/statuslabels/table.show_in_nav') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- side address column -->
  <div class="col-md-3">
    <h4>{{ trans('admin/statuslabels/table.about') }}</h4>
    <p>{{ trans('admin/statuslabels/table.info') }}</p>
  </div>

</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'statuslabels-export', 'search' => true])
@stop
