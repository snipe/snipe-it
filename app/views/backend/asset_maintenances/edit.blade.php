@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($assetMaintenance->id)
        @lang('admin/asset_maintenances/form.update') ::
    @else
        @lang('admin/asset_maintenances/form.create') ::
    @endif
    @parent
@stop

{{-- Page content --}}
@section('content')

    <div class="row header">
        <div class="col-md-12">
            <a href="{{ URL::previous() }}" class="btn-flat gray pull-right right">
                <i class="fa fa-arrow-left icon-white"></i> @lang('general.back')</a>
            <h3>
                @if ($assetMaintenance->id)
                    @lang('admin/asset_maintenances/form.update')
                @else
                    @lang('admin/asset_maintenances/form.create')
                @endif
            </h3>
        </div>
    </div>

    <div class="row form-wrapper">

        <form class="form-horizontal" method="post" action="" autocomplete="off">
            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Asset -->
            <div class="form-group {{ $errors->has('asset_id') ? ' has-error' : '' }}">
                <label for="asset_id" class="col-md-3 control-label">@lang('admin/asset_maintenances/table.asset_name')
                    <i class='fa fa-asterisk'></i></label>
                <div class="col-md-7">
                    @if ($selectedAsset == null)
                        {{ Form::select('asset_id', $asset_list , Input::old('asset_id', $assetMaintenance->asset_id), ['class'=>'select2', 'style'=>'min-width:350px']) }}
                    @else
                        {{ Form::select('asset_id', $asset_list , Input::old('asset_id', $selectedAsset), ['class'=>'select2', 'style'=>'min-width:350px', 'enabled' => 'false']) }}
                    @endif
                    {{ $errors->first('asset_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Supplier -->
            <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                <label for="supplier_id" class="col-md-3 control-label">@lang('admin/asset_maintenances/table.supplier_name')
                    <i class='fa fa-asterisk'></i></label>
                <div class="col-md-7">
                    {{ Form::select('supplier_id', $supplier_list , Input::old('supplier_id', $assetMaintenance->supplier_id), ['class'=>'select2', 'style'=>'min-width:350px']) }}
                    {{ $errors->first('supplier_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Improvement Type -->
            <div class="form-group {{ $errors->has('asset_maintenance_type') ? ' has-error' : '' }}">
                <label for="asset_maintenance_type" class="col-md-3 control-label">@lang('admin/asset_maintenances/form.asset_maintenance_type')
                    <i class='fa fa-asterisk'></i></label>
                <div class="col-md-7">
                    {{ Form::select('asset_maintenance_type', $assetMaintenanceType , Input::old('asset_maintenance_type', $assetMaintenance->asset_maintenance_type), ['class'=>'select2', 'style'=>'min-width:350px']) }}
                    {{ $errors->first('asset_maintenance_type', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Title -->
            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title" class="col-md-3 control-label">@lang('admin/asset_maintenances/form.title')
                    <i class='fa fa-asterisk'></i></label>
                </label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', $assetMaintenance->title) }}}" />
                    {{ $errors->first('title', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Start Date -->
            <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
                <label for="start_date" class="col-md-3 control-label">@lang('admin/asset_maintenances/form.start_date')
                    <i class='fa fa-asterisk'></i></label>
                <div class="input-group col-md-2">
                    <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="start_date" id="start_date" value="{{{ Input::old('start_date', $assetMaintenance->start_date) }}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    {{ $errors->first('start_date', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Completion Date -->
            <div class="form-group {{ $errors->has('completion_date') ? ' has-error' : '' }}">
                <label for="start_date" class="col-md-3 control-label">@lang('admin/asset_maintenances/form.completion_date')</label>
                <div class="input-group col-md-2">
                    <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="completion_date" id="completion_date" value="{{{ Input::old('completion_date', $assetMaintenance->completion_date) }}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    {{ $errors->first('completion_date', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Warranty -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="1" name="is_warranty" id="is_warranty" {{ Input::old('is_warranty', $assetMaintenance->is_warranty) == '1' ? ' checked="checked"' : '' }}> @lang('admin/asset_maintenances/form.is_warranty')
                        </label>
                    </div>
                </div>
            </div>

            <!-- Asset Maintenance Cost -->
            <div class="form-group {{ $errors->has('cost') ? ' has-error' : '' }}">
                <label for="cost" class="col-md-3 control-label">@lang('admin/asset_maintenances/form.cost')</label>
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-addon">{{{ Setting::first()->default_currency }}}</span>
                        <input class="col-md-2 form-control" type="text" name="cost" id="cost" value="{{ Input::old('cost', number_format($assetMaintenance->cost,2)) }}" />
                        {{ $errors->first('cost', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                <label for="notes" class="col-md-3 control-label">@lang('admin/asset_maintenances/form.notes')</label>
                <div class="col-md-7">
                    <textarea class="col-md-6 form-control" id="notes" name="notes">{{{ Input::old('notes', $assetMaintenance->notes) }}}</textarea>
                    {{ $errors->first('notes', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Form actions -->
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-7">

                    <a class="btn btn-link" href="{{ URL::previous() }}">@lang('button.cancel')</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
                </div>
            </div>

        </form>
    </div>

@stop
