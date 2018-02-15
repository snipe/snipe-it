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
                data-url="{{route('api.maintenances.index') }}"
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
              </tr>
            </thead>
            <tbody>
              @if ($assetsForReport)
              @foreach ($assetsForReport as $assetItem)
              <tr>
                <td>{{ is_null($assetItem->company) ? '' : $assetItem->company->name }}</td>
                <td>{{ $assetItem->model->category->name }}</td>
                <td>{{ $assetItem->model->name }}</td>
                <td>{!! $assetItem->present()->nameUrl() !!}</td>
                <td>{{ $assetItem->asset_tag }}</td>
                <td>{!! ($assetItem->assignedTo) ? $assetItem->assignedTo->present()->nameUrl() : 'Deleted user' !!}</td>
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
    </div>
  </div>
</div>

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')
@stop
