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
                <th data-sortable="true" data-field="name">{{ trans('admin/statuslabels/table.name') }}</th>
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
  </div>

</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'statuslabels-export', 'search' => true])

  <script>
      function colorSqFormatter(value, row) {
          if (value) {
              return '<span class="label" style="background-color: ' + value + ';">&nbsp;</span> ' + value;
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
