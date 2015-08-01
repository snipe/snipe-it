<?php
use Carbon\Carbon;
?>
@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('general.unaccepted_asset_report') ::
    @parent
@stop

{{-- Page content --}}
@section('content')
    <div class="page-header">

        <div class="pull-right">
            <a href="{{ route('reports/export/unaccepted_assets') }}" class="btn btn-flat gray pull-right"><i class="fa fa-download icon-white"></i>
                @lang('admin/asset_maintenances/table.dl_csv')</a>
        </div>
        <h3>@lang('general.asset_maintenance_report')</h3>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table id="example">
                <thead>
                <tr role="row">
                    <th class="col-sm-1">@lang('general.category')</th>
                    <th class="col-sm-1">@lang('admin/hardware/form.model')</th>
                    <th class="col-sm-1">@lang('admin/hardware/form.name')</th>
                    <th class="col-sm-1">@lang('admin/hardware/table.asset_tag')</th>
                    <th class="col-sm-1">@lang('admin/hardware/table.checkout_date')</th>
                    <th class="col-sm-1">@lang('admin/hardware/table.checkoutto')</th>
                    <th class="col-sm-1">@lang('admin/hardware/table.days_without_acceptance')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($assetsForReport as $assetItem)
                    <tr>
                        <td>{{{ $assetItem->assetlog->model->category->name }}}</td>
                        <td>{{{ $assetItem->assetlog->model->name }}}</td>
                        <td>{{ link_to(Config::get('app.url').'/hardware/'.$assetItem->assetlog->id.'/view',$assetItem->assetlog->showAssetName()) }}</td>
                        <td>{{{ $assetItem->assetlog->asset_tag }}}</td>
                        <td>{{{ $assetItem->created_at->format('Y-m-d') }}}</td>
                        <td>{{ link_to(Config::get('app.url').'/admin/users/'.$assetItem->assetlog->assigned_to.'/view', $assetItem->assetlog->assigneduser->fullName())}}</td>
                        <td>{{{ $assetItem->created_at->diffInDays(Carbon::now()) }}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@stop