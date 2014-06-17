@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@lang('admin/hardware/general.clone') ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">

		<div class="pull-right">
			<a href="{{ URL::previous() }}" class="btn-flat gray"><i class="icon-circle-arrow-left icon-white"></i>  @lang('general.back')</a>
		</div>

		<h3>@lang('admin/hardware/general.clone')</h3>
</div>


<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- Asset Tag -->
			<div class="form-group {{ $errors->has('asset_tag') ? 'error' : '' }}">
				<label class="control-label" for="asset_tag">@lang('admin/hardware/form.tag')</label>
				<div class="controls">
					<input class="col-md-4" type="text" name="asset_tag" id="asset_tag" value="{{ Input::old('asset_tag') }}" />
					{{ $errors->first('asset_tag', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>
			<!-- Asset Title -->
			<div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
				<label class="control-label" for="name">@lang('admin/hardware/form.name')</label>
				<div class="controls">
					<input class="col-md-4" type="text" name="name" id="name" value="{{ Input::old('name', $asset->name) }}" />
					{{ $errors->first('name', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>


			<!-- Serial -->
			<div class="form-group {{ $errors->has('serial') ? 'error' : '' }}">
				<label class="control-label" for="serial">@lang('admin/hardware/form.serial')</label>
				<div class="controls">
					<input class="col-md-4" type="text" name="serial" id="serial" value="{{ Input::old('serial', $asset->serial) }}" />
					{{ $errors->first('serial', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Order Number -->
			<div class="form-group {{ $errors->has('order_number') ? 'error' : '' }}">
				<label class="control-label" for="order_number">@lang('admin/hardware/form.order')</label>
				<div class="controls">
					<input class="col-md-4" type="text" name="order_number" id="order_number" value="{{ Input::old('order_number', $asset->order_number) }}" />
					{{ $errors->first('order_number', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

				<!-- Model -->
			<div class="form-group {{ $errors->has('model_id') ? 'error' : '' }}">
				<label class="control-label" for="parent">@lang('admin/hardware/form.model')</label>
				<div class="controls">
					{{ Form::select('model_id', $model_list , Input::old('model_id', $asset->model_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
					{{ $errors->first('model_id', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Purchase Date -->
			<div class="form-group input-append {{ $errors->has('purchase_date') ? 'error' : '' }}" >
				<label class="control-label" for="purchase_date">@lang('admin/hardware/form.date')</label>
				<div class="controls">
				<input type="text" class="datepicker span2" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="purchase_date" id="purchase_date" value="{{ Input::old('purchase_date', $asset->purchase_date) }}">
				{{ $errors->first('purchase_date', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}

				</div>
			</div>

			<!-- Purchase Cost -->
			<div class="form-group {{ $errors->has('purchase_cost') ? 'error' : '' }}">
				<label class="control-label" for="purchase_cost">@lang('admin/hardware/form.cost')</label>
				<div class="controls">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="col-md-2" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', $asset->purchase_cost) }}" />
					{{ $errors->first('purchase_cost', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
				 </div>
			</div>

			<!-- Warrantee -->
			<div class="form-group {{ $errors->has('warranty_months') ? 'error' : '' }}">
				<label class="control-label" for="serial">@lang('admin/hardware/form.warranty')</label>
				<div class="controls">
					<input class="col-md-1" type="text" name="warranty_months" id="warranty_months" value="{{ Input::old('warranty_months', $asset->warranty_months) }}" />
					@lang('admin/hardware/form.months')
					{{ $errors->first('warranty_months', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Depreciation -->
			<div class="form-group {{ $errors->has('depreciation_id') ? 'error' : '' }}">
				<label class="control-label" for="parent">@lang('admin/hardware/form.depreciation')</label>
				<div class="controls">
					<div class="field-box">
					{{ Form::select('depreciation_id', $depreciation_list , Input::old('depreciation_id', $asset->depreciation_id), array('class'=>'select2', 'style'=>'width:250px')) }}
					{{ $errors->first('depreciation_id', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
				</div>
			</div>

			<!-- Status -->
			<div class="form-group {{ $errors->has('status_id') ? 'error' : '' }}">
				<label class="control-label" for="parent">@lang('admin/hardware/form.status')</label>
				<div class="controls">
					<div class="field-box">
					{{ Form::select('status_id', $statuslabel_list , Input::old('status_id', $asset->status_id), array('class'=>'select2', 'style'=>'width:250px')) }}
					{{ $errors->first('depreciation_id', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
				</div>
			</div>


			<!-- Notes -->
			<div class="form-group {{ $errors->has('notes') ? 'error' : '' }}">
				<label class="control-label" for="notes">@lang('admin/hardware/form.notes')</label>
				<div class="controls">
					<input class="col-md-6" type="text" name="notes" id="notes" value="{{ Input::old('notes', $asset->notes) }}" />
					{{ $errors->first('notes', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

	<!-- Form actions -->
	<div class="form-group">
		<div class="controls">
			<a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
			<button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
		</div>
	</div>
</form>


@stop
