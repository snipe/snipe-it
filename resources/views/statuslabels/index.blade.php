@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/statuslabels/table.title') }}
@parent
@stop

@section('header_right')
<a href="{{ route('statuslabels.create') }}" class="btn btn-primary pull-right">
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
          data-url="{{ route('api.statuslabels.index') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="statuslabelsTable-{{ config('version.hash_version') }}">
            <thead>
              <tr>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-sortable="true" data-field="name" data-formatter="statuslabelsAssetLinkFormatter">{{ trans('admin/statuslabels/table.name') }}</th>
                <th data-sortable="false" data-field="type" data-formatter="undeployableFormatter">{{ trans('admin/statuslabels/table.status_type') }}</th>
                <th data-sortable="false" data-field="color" data-formatter="colorSqFormatter">{{ trans('admin/statuslabels/table.color') }}</th>
                <th class="text-center" data-sortable="true" data-field="show_in_nav" data-formatter="trueFalseFormatter">{{ trans('admin/statuslabels/table.show_in_nav') }}</th>
                <th data-switchable="false" data-formatter="statuslabelsActionsFormatter" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
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

      <p><i class="fa fa-circle text-green"></i> <strong>{{ trans('admin/statuslabels/table.deployable') }}</strong>: {!!  trans('admin/statuslabels/message.help.deployable')  !!}</p>
      <p><i class="fa fa-circle text-orange"></i> <strong>Pending</strong>: {{ trans('admin/statuslabels/message.help.pending') }}</p>
      <p><i class="fa fa-times text-red"></i> <strong>Undeployable</strong>: {{ trans('admin/statuslabels/message.help.undeployable') }}</p>
      <p><i class="fa fa-times text-red"></i> <strong>Archived</strong>: {{ trans('admin/statuslabels/message.help.archived') }}</p>

  </div>

</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'statuslabels-export', 'search' => true])

  <script nonce="{{ csrf_token() }}">
      function colorSqFormatter(value, row) {
          if (value) {
              return '<span class="label" style="background-color: ' + value + ';">&nbsp;</span> ' + value;
          }
      }

      function statuslabelsAssetLinkFormatter(value, row) {
          if ((row) && (row.name)) {
              return '<a href="{{ url('/') }}/hardware/?status_id=' + row.id + '"> ' + row.name + '</a>';
          }
      }

      function undeployableFormatter(value, row) {
          if ((value)  && (value!='deployable')) {
              return '<span class="text-danger">' + value + '</span> ';
          } else {
              return '<span class="text-success">' + value + '</span> ';
          }
      }
  </script>
@stop
