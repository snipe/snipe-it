@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($license->id)
		License Update ::
	@else
		Create License ::
	@endif
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		@if ($license->id)
		Update License
		@else
		Create License
		@endif

		<div class="pull-right">
			@if ($license->id)
			<a href="{{ route('view/license',$license->id) }}" class="btn-flat gray"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
			@else
			<a href="{{ route('licenses') }}" class="btn-flat gray"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
			@endif
		</div>
	</h3>
</div>


<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Tabs Content -->
	<div class="tab-content">

		<div class="tab-pane active" id="tab-general">
			<!-- Category Title -->
			<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
				<label class="control-label" for="name">Software Name</label>
				<div class="controls">
					<input class="span6" type="text" name="name" id="name" value="{{ Input::old('name', $license->name) }}" />
					{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
			<div class="control-group {{ $errors->has('serial') ? 'error' : '' }}">
				<label class="control-label" for="serial">Serial</label>
				<div class="controls">
					<input class="span6" type="text" name="serial" id="serial" value="{{ Input::old('serial', $license->serial) }}" />
					{{ $errors->first('serial', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
			<div class="control-group {{ $errors->has('license_name') ? 'error' : '' }}">
				<label class="control-label" for="license_name">Licensed to Name</label>
				<div class="controls">
					<input class="span6" type="text" name="license_name" id="license_name" value="{{ Input::old('license_name', $license->license_name) }}" />
					{{ $errors->first('license_name', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
			<div class="control-group {{ $errors->has('license_email') ? 'error' : '' }}">
				<label class="control-label" for="license_email">Licensed to Email</label>
				<div class="controls">
					<input class="span6" type="text" name="license_email" id="license_email" value="{{ Input::old('license_email', $license->license_email) }}" />
					{{ $errors->first('license_email', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
			<div class="control-group {{ $errors->has('seats') ? 'error' : '' }}">
				<label class="control-label" for="seats">Seats</label>
				<div class="controls">
					<input class="span1" type="text" name="seats" id="seats" value="{{ Input::old('seats', $license->seats) }}" />
					{{ $errors->first('seats', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
			<div class="control-group {{ $errors->has('order_number') ? 'error' : '' }}">
				<label class="control-label" for="order_number">Order Number</label>
				<div class="controls">
					<input class="span4" type="text" name="order_number" id="order_number" value="{{ Input::old('order_number', $license->order_number) }}" />
					{{ $errors->first('order_number', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
			<div class="control-group {{ $errors->has('purchase_cost') ? 'error' : '' }}">
				<label class="control-label" for="purchase_cost">Purchase Cost</label>
				<div class="controls">
					$ <input class="span2" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', $license->purchase_cost) }}" />
					{{ $errors->first('purchase_cost', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Depreciation -->
			<div class="control-group {{ $errors->has('depreciation_id') ? 'error' : '' }}">
				<label class="control-label" for="parent">Depreciation</label>
				<div class="controls">
					<div class="field-box">
					{{ Form::select('depreciation_id', $depreciation_list , Input::old('depreciation_id', $license->depreciation_id), array('class'=>'select2', 'style'=>'width:250px')) }}
					{{ $errors->first('depreciation_id', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
				</div>
			</div>

			<div class="control-group {{ $errors->has('purchase_date') ? 'error' : '' }}">
				<label class="control-label" for="purchase_date">Purchase Date</label>
				<div class="controls">
					<input type="text" class="datepicker span2" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="purchase_date" id="purchase_date" value="{{ Input::old('purchase_date', $license->purchase_date) }}"> <span class="add-on"><i class="icon-calendar"></i></span>
				{{ $errors->first('purchase_date', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<div class="control-group {{ $errors->has('notes') ? 'error' : '' }}">
				<label class="control-label" for="notes">Notes</label>
				<div class="controls">
					<input class="span6" type="text" name="notes" id="notes" value="{{ Input::old('notes', $license->notes) }}" />
					{{ $errors->first('notes', '<span class="help-inline">:message</span>') }}
				</div>
			</div>


	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			@if ($license->id)
			<a class="btn btn-link" href="{{ route('view/license', $license->id) }}">@lang('general.cancel')</a>
			@else
			<a class="btn btn-link" href="{{ route('licenses') }}">@lang('general.cancel')</a>
			@endif
			<button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
		</div>
	</div>
</form>


@stop
