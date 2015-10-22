<?php
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
        <h3>@lang('general.unaccepted_asset_report')</h3>
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
                    <th class="col-sm-1">@lang('admin/hardware/table.checkoutto')</th>
                </tr>
                </thead>
                <tbody>
                @if ($assetsForReport)
                    @foreach ($assetsForReport as $assetItem)
                        <tr>
                            <td>{{{ $assetItem->model->category->name }}}</td>
                            <td>{{{ $assetItem->model->name }}}</td>
                            <td>{{ link_to(Config::get('app.url').'/hardware/'.$assetItem->id.'/view',$assetItem->showAssetName()) }}</td>
                            <td>{{{ $assetItem->asset_tag }}}</td>
                            <td>{{ link_to(Config::get('app.url').'/admin/users/'.$assetItem->assigned_to.'/view', $assetItem->assigneduser->fullName())}}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
                <tfoot>
                <tr>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@stop
