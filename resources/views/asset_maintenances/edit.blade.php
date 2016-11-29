@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($item->id)
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
          @if ($item)
          {{ $item->name }}
          @endif
      </h3>
      </div><!-- /.box-header -->
        <div class="box-body">

          <!-- Asset -->
          <div class="form-group {{ $errors->has('asset_id') ? ' has-error' : '' }}">
              <label for="asset_id" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/table.asset_name') }}
                 </label>
              <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'asset_id')) ? ' required' : '' }}">
                  @if ($selectedAsset == null)
                      {{ Form::select('asset_id', $asset_list , Input::old('asset_id', $item->asset_id), ['class'=>'select2', 'style'=>'min-width:350px']) }}
                  @else
                      {{ Form::select('asset_id', $asset_list , Input::old('asset_id', $selectedAsset), ['class'=>'select2', 'style'=>'min-width:350px', 'enabled' => 'false']) }}
                  @endif
                  {!! $errors->first('asset_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
          </div>

           @include ('partials.forms.edit.supplier')
           @include ('partials.forms.edit.maintenance_type')



          <!-- Title -->
          <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
              <label for="title" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.title') }}
                  </label>
              </label>
              <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'title')) ? ' required' : '' }}">
                  <input class="form-control" type="text" name="title" id="title" value="{{ Input::old('title', $item->title) }}" />
                  {!! $errors->first('title', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
          </div>

          <!-- Start Date -->
          <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
              <label for="start_date" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.start_date') }}
                  </label>
              <div class="input-group col-md-2{{  (\App\Helpers\Helper::checkIfRequired($item, 'start_date')) ? ' required' : '' }}">
                  <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="start_date" id="start_date" value="{{ Input::old('start_date', $item->start_date) }}">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  {!! $errors->first('start_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
          </div>

          <!-- Completion Date -->
          <div class="form-group {{ $errors->has('completion_date') ? ' has-error' : '' }}">
              <label for="start_date" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.completion_date') }}</label>
              <div class="input-group col-md-2">
                  <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="completion_date" id="completion_date" value="{{ Input::old('completion_date', $item->completion_date) }}">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  {!! $errors->first('completion_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
          </div>

          <!-- Warranty -->
          <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" value="1" name="is_warranty" id="is_warranty" {{ Input::old('is_warranty', $item->is_warranty) == '1' ? ' checked="checked"' : '' }}> {{ trans('admin/asset_maintenances/form.is_warranty') }}
                      </label>
                  </div>
              </div>
          </div>

          <!-- Asset Maintenance Cost -->
          <div class="form-group {{ $errors->has('cost') ? ' has-error' : '' }}">
              <label for="cost" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.cost') }}</label>
              <div class="col-md-2">
                  <div class="input-group">
                      <span class="input-group-addon">{{ $snipeSettings->default_currency }}</span>
                      <input class="col-md-2 form-control" type="text" name="cost" id="cost" value="{{ Input::old('cost', \App\Helpers\Helper::formatCurrencyOutput($item->cost)) }}" />
                      {!! $errors->first('cost', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
              </div>
          </div>

          <!-- Notes -->
          <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
              <label for="notes" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.notes') }}</label>
              <div class="col-md-7">
                  <textarea class="col-md-6 form-control" id="notes" name="notes">{{ Input::old('notes', $item->notes) }}</textarea>
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
