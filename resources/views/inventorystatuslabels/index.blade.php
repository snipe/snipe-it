@extends('layouts/default')

{{-- Page title --}}
@section('title')
Статусы инвентаризаций
@parent
@stop

@section('header_right')
    @can('create', \App\Models\Statuslabel::class)
        <a href="{{ route('inventorystatuslabels.create') }}" class="btn btn-primary pull-right">
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
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="statuslabelsTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.inventorystatuslabels.index') }}"
                    data-export-options='{
                "fileName": "export-statuslabels-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
            <thead>
              <tr>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-sortable="true" data-field="name">{{ trans('admin/statuslabels/table.name') }}</th>

                <th data-sortable="false" data-field="type" data-formatter="statusLabelSuccessFormatter">{{ trans('admin/statuslabels/table.status_type') }}</th>
                <th data-sortable="true" data-field="color" data-formatter="colorSqFormatter">{{ trans('admin/statuslabels/table.color') }}</th>
              <th data-formatter="inventorystatuslabelsActionsFormatter" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
        </div>
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

      function statusLabelSuccessFormatter (row, value) {
          if (value.success=="1"){
              return "Успешно"
          }else{
              return "Не успешно"
          }
      }
  </script>
@stop
