@extends('layouts/default')

{{-- Page title --}}
@section('title')
  {{ trans('admin/asset_maintenances/general.asset_maintenances') }}
  @parent
@stop


@section('header_right')
  @can('update', \App\Models\Asset::class)
    <a href="{{ route('maintenances.create') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
  @endcan
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <table
          name="maintenances"
          id="table"
          class="table table-striped snipe-table"
          data-url="{{route('api.maintenances.index') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="maintenancesTable-{{ config('version.hash_version') }}"
        >
          <thead>
            <tr>
              <th data-field="company" data-sortable="false" data-visible="false">{{ trans('admin/companies/table.title') }}</th>
              <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
              <th data-sortable="false" data-field="asset_name" data-formatter="hardwareLinkObjFormatter">{{ trans('admin/asset_maintenances/table.asset_name') }}</th>
              <th data-sortable="false" data-field="supplier" data-formatter="suppliersLinkObjFormatter">{{ trans('general.supplier') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="asset_maintenance_type">{{ trans('admin/asset_maintenances/form.asset_maintenance_type') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="title">{{ trans('admin/asset_maintenances/form.title') }}</th>
              <th data-searchable="true" data-sortable="false" data-field="start_date" data-formatter="dateDisplayFormatter">{{ trans('admin/asset_maintenances/form.start_date') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="completion_date" data-formatter="dateDisplayFormatter">{{ trans('admin/asset_maintenances/form.completion_date') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="asset_maintenance_time">{{ trans('admin/asset_maintenances/form.asset_maintenance_time') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="cost" class="text-right">{{ trans('admin/asset_maintenances/form.cost') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="user_id" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="notes" data-visible="false">{{ trans('admin/asset_maintenances/form.notes') }}</th>
              @can('update', \App\Models\Asset::class)
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions" data-formatter="maintenanceActions">{{ trans('table.actions') }}</th>
              @endcan
            </tr>
          </thead>
        </table>

      </div>
    </div>
  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'maintenances-export', 'search' => true])
<script nonce="{{ csrf_token() }}">
    function maintenanceActions(value, row) {
        var actions = '<nobr>';
        if ((row) && (row.available_actions.update === true)) {
            actions += '<a href="{{ url('/') }}/hardware/maintenances/' + row.id + '/edit" class="btn btn-sm btn-warning" data-tooltip="true" title="Update"><i class="fa fa-pencil"></i></a>&nbsp;';
        }
        actions += '</nobr>'
        if ((row) && (row.available_actions.delete === true)) {
            actions += '<a href="{{ url('/') }}/hardware/maintenances/' + row.id + '" '
                + ' class="btn btn-danger btn-sm delete-asset"  data-tooltip="true"  '
                + ' data-toggle="modal" '
                + ' data-content="{{ trans('general.sure_to_delete') }} ' + row.name + '?" '
                + ' data-title="{{  trans('general.delete') }}" onClick="return false;">'
                + '<i class="fa fa-trash"></i></a></nobr>';
        }

        return actions;
    }

</script>
@stop
