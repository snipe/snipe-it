@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($assetMaintenance->id)
        {{ trans('admin/asset_maintenances/form.update') }}
    @else
        {{ trans('admin/asset_maintenances/form.create') }}
    @endif
    @parent
@stop


@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')



<div class="row">
  <div class="col-md-9">
    <form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <div class="box box-default">
      <div class="box-header with-border">

        <h3 class="box-title">
          @if ($assetMaintenance)
          {{ $assetMaintenance->name }}
          @endif
      </h3>
      </div><!-- /.box-header -->
        <div class="box-body">

          <!-- Asset -->
          <div class="form-group {{ $errors->has('asset_id') ? ' has-error' : '' }}">
              <label for="asset_id" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/table.asset_name') }}
                 </label>
              <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($assetMaintenance, 'asset_id')) ? ' required' : '' }}">
                  @if ($selectedAsset == null)
                      {{ Form::select('asset_id', $asset_list , Input::old('asset_id', $assetMaintenance->asset_id), ['class'=>'select2', 'style'=>'min-width:350px']) }}
                  @else
                      {{ Form::select('asset_id', $asset_list , Input::old('asset_id', $selectedAsset), ['class'=>'select2', 'style'=>'min-width:350px', 'enabled' => 'false']) }}
                  @endif
                  {!! $errors->first('asset_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
          </div>

          <!-- Supplier -->
          <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
              <label for="supplier_id" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/table.supplier_name') }}
                 </label>
              <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($assetMaintenance, 'supplier_id')) ? ' required' : '' }}">
                  {{ Form::select('supplier_id', $supplier_list , Input::old('supplier_id', $assetMaintenance->supplier_id), ['class'=>'select2', 'style'=>'min-width:350px']) }}
                  {!! $errors->first('supplier_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
          </div>

          <!-- Improvement Type -->
          <div class="form-group {{ $errors->has('asset_maintenance_type') ? ' has-error' : '' }}">
              <label for="asset_maintenance_type" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.asset_maintenance_type') }}
              </label>
              <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($assetMaintenance, 'asset_maintenance_type')) ? ' required' : '' }}">
                  {{ Form::select('asset_maintenance_type', $assetMaintenanceType , Input::old('asset_maintenance_type', $assetMaintenance->asset_maintenance_type), ['class'=>'select2', 'style'=>'min-width:350px']) }}
                  {!! $errors->first('asset_maintenance_type', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
          </div>

          <!-- Title -->
          <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
              <label for="title" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.title') }}
                  </label>
              </label>
              <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($assetMaintenance, 'title')) ? ' required' : '' }}">
                  <input class="form-control" type="text" name="title" id="title" value="{{ Input::old('title', $assetMaintenance->title) }}" />
                  {!! $errors->first('title', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
          </div>

          <!-- Start Date -->
          <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
              <label for="start_date" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.start_date') }}
                  </label>
              <div class="input-group col-md-2{{  (\App\Helpers\Helper::checkIfRequired($assetMaintenance, 'start_date')) ? ' required' : '' }}">
                  <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="start_date" id="start_date" value="{{ Input::old('start_date', $assetMaintenance->start_date) }}">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  {!! $errors->first('start_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
          </div>

          <!-- Completion Date -->
          <div class="form-group {{ $errors->has('completion_date') ? ' has-error' : '' }}">
              <label for="start_date" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.completion_date') }}</label>
              <div class="input-group col-md-2">
                  <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="completion_date" id="completion_date" value="{{ Input::old('completion_date', $assetMaintenance->completion_date) }}">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  {!! $errors->first('completion_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
          </div>

          <!-- Warranty -->
          <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" value="1" name="is_warranty" id="is_warranty" {{ Input::old('is_warranty', $assetMaintenance->is_warranty) == '1' ? ' checked="checked"' : '' }}> {{ trans('admin/asset_maintenances/form.is_warranty') }}
                      </label>
                  </div>
              </div>
          </div>

          <!-- Asset Maintenance Cost -->
          <div class="form-group {{ $errors->has('cost') ? ' has-error' : '' }}">
              <label for="cost" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.cost') }}</label>
              <div class="col-md-2">
                  <div class="input-group">
                      <span class="input-group-addon">{{ \App\Models\Setting::first()->default_currency }}</span>
                      <input class="col-md-2 form-control" type="text" name="cost" id="cost" value="{{ Input::old('cost', \App\Helpers\Helper::formatCurrencyOutput($assetMaintenance->cost)) }}" />
                      {!! $errors->first('cost', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
              </div>
          </div>

          <!-- Notes -->
          <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
              <label for="notes" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.notes') }}</label>
              <div class="col-md-7">
                  <textarea class="col-md-6 form-control" id="notes" name="notes">{{ Input::old('notes', $assetMaintenance->notes) }}</textarea>
                  {!! $errors->first('notes', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
          </div>

        </div>
      <div class="box-footer text-right">
        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
      </div>
    </form>
    </div>
  </div>

@stop
