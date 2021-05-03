<?php
?>
@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.unaccepted_asset_report') }}
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
                data-cookie-id-table="unacceptedAssetsReport"
                data-pagination="true"
                data-id-table="unacceptedAssetsReport"
                data-search="true"
                data-side-pagination="client"
                data-show-columns="true"
                data-show-export="true"
                data-show-refresh="true"
                data-sort-order="asc"
                id="unacceptedAssetsReport"
                class="table table-striped snipe-table"
                data-export-options='{
                    "fileName": "maintenance-report-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
            <thead>
              <tr role="row">
                <th class="col-sm-1">{{ trans('admin/companies/table.title') }}</th>
                <th class="col-sm-1">{{ trans('general.category') }}</th>
                <th class="col-sm-1">{{ trans('admin/hardware/form.model') }}</th>
                <th class="col-sm-1">{{ trans('admin/hardware/form.name') }}</th>
                <th class="col-sm-1">{{ trans('admin/hardware/table.asset_tag') }}</th>
                <th class="col-sm-1">{{ trans('admin/hardware/table.checkoutto') }}</th>
                <th class="col-md-1"><span class="line"></span>{{ trans('table.actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @if ($assetsForReport)
              @foreach ($assetsForReport as $item)
                  @if ($item['assetItem'])
                  <tr>
                    <td>{{ ($item['assetItem']->company) ? $assetItem->company->name : '' }}</td>
                    <td>{!! $item['assetItem']->model->category->present()->nameUrl() !!}</td>
                    <td>{!! $item['assetItem']->present()->modelUrl() !!}</td>
                    <td>{!! $item['assetItem']->present()->nameUrl() !!}</td>
                    <td>{{ $item['assetItem']->asset_tag }}</td>
                    <td>{!! ($item['acceptance']->assignedTo) ? $item['acceptance']->assignedTo->present()->nameUrl() : trans('admin/reports/general.deleted_user') !!}</td>
                    <td>
                        @if ($item['acceptance']->assignedTo)<a href="{{ route('reports/unaccepted_assets_sent_reminder', ['acceptanceId' => $item['acceptance']->id]) }}" class="btn btn-sm bg-purple" data-tooltip="true">{{ trans('admin/reports/general.send_reminder') }}</a>@endif
                        <a href="{{ route('reports/unaccepted_assets_delete', ['acceptanceId' => $item['acceptance']->id]) }}" class="btn btn-sm btn-danger delete-asset" data-tooltip="true" data-toggle="modal" data-content="{{ trans('general.delete_confirm', ['item' =>trans('admin/reports/general.acceptance_request')]) }}" data-title="{{  trans('general.delete') }}" onClick="return false;"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                  @endif
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
    </div>
  </div>
</div>

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')
@stop
