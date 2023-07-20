<?php
use Carbon\Carbon;
?>
@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/asset_maintenances/general.view') }} {{ $assetMaintenance->title }}
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="row header">
  <div class="col-md-12">
    <h2 class="title">
      {{ trans('admin/asset_maintenances/general.view') }}
      {{ " - " . $assetMaintenance->title }}
    </h2>

    <div class="btn-group pull-right">
      <div class="dropdown">
        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">
          <li role="presentation"><a href="{{ route('maintenances.update', $assetMaintenance->id) }}">{{ trans('admin/asset_maintenances/general.edit') }}</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="user-profile ">
  <div class="row profile">
    <div class="col-md-9 bio">
      <!-- 1st Row Begin -->
      <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
          <strong>{{ trans('admin/asset_maintenances/form.asset_maintenance_type') }}: </strong>
          {{ $assetMaintenance->asset_maintenance_type }}
        </div>
      </div>
      <!-- 1st Row End -->

      <!-- 2nd Row Begin -->
      <div class="row">
        <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
          <strong>{{ trans('admin/asset_maintenances/table.asset_name') }}: </strong>
          <a href="{{ route('hardware.show', $assetMaintenance->asset_id) }}">
            {{ $assetMaintenance->asset->name }}
          </a>
        </div>
        <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
          <strong>{{ trans('general.supplier') }}: </strong>
          <a href="{{ route('suppliers.show', $assetMaintenance->supplier_id) }}">
            {{ $assetMaintenance->supplier->name }}
          </a>
        </div>
      </div>
      <!-- 2nd Row End -->
      <!-- 3rd Row Begin -->
      <div class="row">
        <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
          <strong>{{ trans('admin/asset_maintenances/form.start_date') }}: </strong>
            <?php $startDate = Carbon::parse($assetMaintenance->start_date); ?>
          {{ $startDate->toDateString() }}
        </div>
        <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
          <strong>{{ trans('admin/asset_maintenances/form.completion_date') }}: </strong>
          {{ $completionDate = $assetMaintenance->completion_date }}
          {{ $completionDate ? $completionDate : trans('admin/asset_maintenances/message.asset_maintenance_incomplete') }}
        </div>
        <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
          <strong>{{ trans('admin/asset_maintenances/form.asset_maintenance_time') }}: </strong>
          {{ $assetMaintenance->asset_maintenance_time }}
        </div>
      </div>
      <!-- 3rd Row End -->
      <!-- 4th Row Begin -->
      <div class="row">
        <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
          <strong>{{ trans('admin/asset_maintenances/form.cost') }}: </strong>
          {{ trans( 'general.currency' ) . Helper::formatCurrencyOutput($assetMaintenance->cost) }}
        </div>
        <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
          <strong>{{ trans('admin/asset_maintenances/form.is_warranty') }}: </strong>
          {{ $assetMaintenance->is_warranty ? trans('admin/asset_maintenances/message.warranty') : trans('admin/asset_maintenances/message.not_warranty') }}
        </div>
      </div>
      <!-- 4th Row End -->
      <!-- 5th Row Begin -->
      <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
          <strong>{{ trans('admin/asset_maintenances/form.notes') }}: </strong>
          {!! nl2br(Helper::parseEscapedMarkedownInline($assetMaintenance->notes)) !!}
        </div>
      </div>
      <!-- 5th Row End -->
    </div> <!-- col-md-9 bio end -->
  </div> <!-- row profile end -->
</div> <!-- user-profile end -->
@stop
