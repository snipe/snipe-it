<?php
use Carbon\Carbon;
?>
@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('general.asset_maintenance_report') ::
    @parent
@stop

{{-- Page content --}}
@section('content')
    <div class="page-header">

        <div class="pull-right">
            <a href="{{ route('reports/export/asset_maintenances') }}" class="btn btn-flat gray pull-right"><i class="fa fa-download icon-white"></i>
                @lang('admin/asset_maintenances/table.dl_csv')</a>
        </div>
        <h3>@lang('general.asset_maintenance_report')</h3>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table id="example">
                <thead>
                    <tr role="row">
                        <th class="col-sm-1">@lang('admin/asset_maintenances/table.asset_name')</th>
                        <th class="col-sm-1">@lang('admin/asset_maintenances/table.supplier_name')</th>
                        <th class="col-sm-1">@lang('admin/asset_maintenances/form.asset_maintenance_type')</th>
                        <th class="col-sm-1">@lang('admin/asset_maintenances/form.title')</th>
                        <th class="col-sm-1">@lang('admin/asset_maintenances/form.start_date')</th>
                        <th class="col-sm-1">@lang('admin/asset_maintenances/form.completion_date')</th>
                        <th class="col-sm-1">@lang('admin/asset_maintenances/form.asset_maintenance_time')</th>
                        <th class="col-sm-1">@lang('admin/asset_maintenances/form.cost')</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $totalDays = 0;
                    $totalCost = 0;
                ?>
                @foreach ($assetMaintenances as $assetMaintenance)
                    <tr>
                        <td>{{{ $assetMaintenance->asset->name }}}</td>
                        <td>{{{ $assetMaintenance->supplier->name }}}</td>
                        <td>{{{ $assetMaintenance->asset_maintenance_type }}}</td>
                        <td>{{{ $assetMaintenance->title }}}</td>
                        <td>{{{ $assetMaintenance->start_date }}}</td>
                        <td>{{{ is_null($assetMaintenance->completion_date) ? Lang::get('admin/asset_maintenances/message.asset_maintenance_incomplete') : $assetMaintenance->completion_date }}}</td>
                        @if (is_null($assetMaintenance->asset_maintenance_time))
                            <?php
                                $assetMaintenanceTime = intval(Carbon::now()->diffInDays(Carbon::parse($assetMaintenance->start_date)));
                            ?>
                        @else
                            <?php
                                $assetMaintenanceTime = intval($assetMaintenance->asset_maintenance_time);
                            ?>
                        @endif
                        <td>{{{ $assetMaintenanceTime }}}</td>
                        <td>@lang('general.currency'){{ number_format($assetMaintenance->cost,2) }}</td>
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
                        <td>@lang('general.currency'){{ number_format($totalCost,2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@stop