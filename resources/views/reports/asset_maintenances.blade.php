@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.asset_maintenance_report') }}
    @parent
@stop

{{-- Page content --}}
@section('content')
<div class="row">
  <div class="col-md-12">

  <div class="box box-default">
    <div class="box-body">

      <div class="table-responsive">
             <table
             name="maintenancesReport"
             id="table"
             data-cookie="true"
             data-click-to-select="true"
             data-cookie-id-table="maintenancesReportTable">

                <thead>
                    <tr role="row">
                        <th class="col-sm-1">{{ trans('admin/companies/table.title') }}</th>
                        <th class="col-sm-1">{{ trans('admin/hardware/table.asset_tag') }}</th>
                        <th class="col-sm-1">{{ trans('admin/asset_maintenances/table.asset_name') }}</th>
                        <th class="col-sm-1">{{ trans('general.supplier') }}</th>
                        <th class="col-sm-1">{{ trans('admin/asset_maintenances/form.asset_maintenance_type') }}</th>
                        <th class="col-sm-1">{{ trans('admin/asset_maintenances/form.title') }}</th>
                        <th class="col-sm-1">{{ trans('admin/asset_maintenances/form.start_date') }}</th>
                        <th class="col-sm-1">{{ trans('admin/asset_maintenances/form.completion_date') }}</th>
                        <th class="col-sm-1">{{ trans('admin/asset_maintenances/form.asset_maintenance_time') }}</th>
                        <th class="col-sm-1">{{ trans('admin/asset_maintenances/form.cost') }}</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $totalDays = 0;
                    $totalCost = 0;
                ?>
                @foreach ($assetMaintenances as $assetMaintenance)
                    <tr>
                        <td>{{ is_null($assetMaintenance->asset->company) ? '' : $assetMaintenance->asset->company->name }}</td>
                        <td>{{ $assetMaintenance->asset->asset_tag }}</td>
                        <td>{{ $assetMaintenance->asset->name }}</td>
                        <td>{{ $assetMaintenance->supplier->name }}</td>
                        <td>{{ $assetMaintenance->asset_maintenance_type }}</td>
                        <td>{{ $assetMaintenance->title }}</td>
                        <td>{{ $assetMaintenance->start_date }}</td>
                        <td>{{ is_null($assetMaintenance->completion_date) ? trans('admin/asset_maintenances/message.asset_maintenance_incomplete') : $assetMaintenance->completion_date }}</td>
                        @if (is_null($assetMaintenance->asset_maintenance_time))
                            <?php
                                $assetMaintenanceTime = intval(Carbon::now()->diffInDays(Carbon::parse($assetMaintenance->start_date)));
                            ?>
                        @else
                            <?php
                                $assetMaintenanceTime = intval($assetMaintenance->asset_maintenance_time);
                            ?>
                        @endif
                        <td>{{ $assetMaintenanceTime }}</td>
                        <td>
                          {{ $snipeSettings->default_currency }}
                          {{ number_format($assetMaintenance->cost,2) }}
                        </td>
                    </tr>
                    <?php
                        $totalDays += $assetMaintenanceTime;
                        $totalCost += floatval($assetMaintenance->cost);
                    ?>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" align="right"><strong>Totals:</strong></td>
                        <td>{{number_format($totalDays)}}</td>
                        <td>
                          {{ $snipeSettings->default_currency }}
                          {{ number_format($totalCost,2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
  </div>
</div>
</div>


@section('moar_scripts')
<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>
<script type="text/javascript">
  $('#table').bootstrapTable({
      classes: 'table table-responsive table-no-bordered',
      undefinedText: '',
      iconsPrefix: 'fa',
      showRefresh: true,
      search: true,
      pageSize: {{ $snipeSettings->per_page }},
      pagination: true,
      sidePagination: 'client',
      sortable: true,
      cookie: true,
      mobileResponsive: true,
      showExport: true,
      showColumns: true,
      exportDataType: 'all',
      exportTypes: ['csv', 'txt','json', 'xml'],
      maintainSelected: true,
      paginationFirstText: "{{ trans('general.first') }}",
      paginationLastText: "{{ trans('general.last') }}",
      paginationPreText: "{{ trans('general.previous') }}",
      paginationNextText: "{{ trans('general.next') }}",
      pageList: ['10','25','50','100','150','200'],
      icons: {
          paginationSwitchDown: 'fa-caret-square-o-down',
          paginationSwitchUp: 'fa-caret-square-o-up',
          columns: 'fa-columns',
          refresh: 'fa-refresh'
      },

  });
</script>
@stop
@stop
