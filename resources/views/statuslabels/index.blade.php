@extends('layouts/default', [
    'helpText' => trans('admin/statuslabels/table.info') ,
    'helpPosition' => 'right',
])

{{-- Page title --}}
@section('title')
{{ trans('admin/statuslabels/table.title') }}
@parent
@stop

@section('header_right')
    @can('create', \App\Models\Statuslabel::class)
        <a href="{{ route('statuslabels.create') }}" class="btn btn-primary pull-right">
{{ trans('general.create') }}</a>
    @endcan
@stop
{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">

            <table
                    data-cookie-id-table="statuslabelsTable"
                    data-pagination="true"
                    data-id-table="statuslabelsTable"
                    data-search="true"
                    data-show-footer="false"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-fullscreen="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="statuslabelsTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.statuslabels.index') }}"
                    data-export-options='{
                "fileName": "export-statuslabels-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
            <thead>
              <tr>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-sortable="true" data-field="name" data-formatter="statuslabelsAssetLinkFormatter">{{ trans('admin/statuslabels/table.name') }}</th>
                <th data-sortable="false" data-field="type" data-formatter="statusLabelTypeFormatter">{{ trans('admin/statuslabels/table.status_type') }}</th>
                  <th data-sortable="true" data-field="assets_count">{{ trans('general.assets') }}</th>
                <th data-sortable="true" data-field="color" data-formatter="colorSqFormatter">{{ trans('admin/statuslabels/table.color') }}</th>
                <th class="text-center" data-sortable="true" data-field="show_in_nav" data-formatter="trueFalseFormatter">{{ trans('admin/statuslabels/table.show_in_nav') }}</th>
                  <th class="text-center" data-sortable="true" data-field="default_label" data-formatter="trueFalseFormatter">{{ trans('admin/statuslabels/table.default_label') }}</th>
                  <th data-sortable="true" data-field="notes" data-visible="false">{{ trans('general.notes') }}</th>
                <th data-formatter="statuslabelsActionsFormatter" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- side address column -->
  <div class="col-md-3">
    <h2>{{ trans('admin/statuslabels/table.about') }}</h2>

      <div class="box box-success">
          <div class="box-body">
          <p><i class="fas fa-circle text-green"></i> <strong>{{ trans('admin/statuslabels/table.deployable') }}</strong>: {!!  trans('admin/statuslabels/message.help.deployable')  !!}</p>
          </div>
      </div>

      <div class="box box-warning">
          <div class="box-body">
              <p><i class="fas fa-circle text-orange"></i> <strong>{{ trans('admin/statuslabels/table.pending') }}</strong>: {{ trans('admin/statuslabels/message.help.pending') }}</p>
          </div>
      </div>
      <div class="box box-danger">
          <div class="box-body">
            <p><i class="fas fa-times text-red"></i> <strong>{{ trans('admin/statuslabels/table.undeployable') }}</strong>: {{ trans('admin/statuslabels/message.help.undeployable') }}</p>
          </div>
      </div>

      <div class="box box-danger">
          <div class="box-body">
              <p><i class="fas fa-times text-red"></i> <strong>{{ trans('admin/statuslabels/table.archived') }}</strong>: {{ trans('admin/statuslabels/message.help.archived') }}</p>
          </div>
      </div>

  </div>

</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')

  <script nonce="{{ csrf_token() }}">
      function colorSqFormatter(value, row) {
          if (value) {
              return '<span class="label" style="background-color: ' + value + ';">&nbsp;</span> ' + value;
          }
      }

      function statuslabelsAssetLinkFormatter(value, row) {
          if ((row) && (row.name)) {
              return '<a href="{{ config('app.url') }}/hardware/?status_id=' + row.id + '"> ' + row.name + '</a>';
          }
      }

      function statusLabelTypeFormatter (row, value) {
          switch (value.type) {
              case 'deployed':
                  text_color = 'blue';
                  icon_style = 'fa-circle';
                  break;
              case 'deployable':
                  text_color = 'green';
                  icon_style = 'fa-circle';
                  break;
              case 'pending':
                  text_color = 'orange';
                  icon_style = 'fa-circle';
                  break;
              default:
                  text_color = 'red';
                  icon_style = 'fa-times';
          }

          var typename_lower = value.type;
          var typename = typename_lower.charAt(0).toUpperCase() + typename_lower.slice(1);
          return '<i class="fa ' + icon_style + ' text-' + text_color + '"></i> ' + typename;


      }
  </script>
@stop
