@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($license->id)
		@lang('admin/licenses/form.update') ::
	@else
		@lang('admin/licenses/form.create') ::
	@endif
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
			<a href="{{ URL::previous() }}" class="btn-flat gray pull-right right">
			<i class="icon-circle-arrow-left icon-white"></i> @lang('general.back')</a>
		<h3>
		@if ($license->id)
			@lang('admin/licenses/form.update')
		@else
			@lang('admin/licenses/form.create')
		@endif
		</h3>
	</div>
</div>

<div class="row form-wrapper">

<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- Asset Tag -->
			<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
				<label for="name" class="col-md-3 control-label">@lang('admin/licenses/form.name')</label>
					<div class="col-md-7">
						<input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $license->name) }}" />
						{{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }}">
				<label for="serial" class="col-md-3 control-label">@lang('admin/licenses/form.serial')</label>
					<div class="col-md-7">
						<textarea class="form-control" type="text" name="serial" id="serial">{{ Input::old('serial', $license->serial) }}</textarea>
						{{ $errors->first('serial', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<div class="form-group {{ $errors->has('license_name') ? ' has-error' : '' }}">
				<label for="license_name" class="col-md-3 control-label">@lang('admin/licenses/form.to_name')</label>
					<div class="col-md-7">
						<input class="form-control" type="text" name="license_name" id="license_name" value="{{ Input::old('license_name', $license->license_name) }}" />
						{{ $errors->first('license_name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<div class="form-group {{ $errors->has('license_email') ? ' has-error' : '' }}">
				<label for="license_email" class="col-md-3 control-label">@lang('admin/licenses/form.to_email')</label>
					<div class="col-md-7">
						<input class="form-control" type="text" name="license_email" id="license_email" value="{{ Input::old('license_email', $license->license_email) }}" />
						{{ $errors->first('license_email', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<div class="form-group {{ $errors->has('seats') ? ' has-error' : '' }}">
				<label for="seats" class="col-md-3 control-label">@lang('admin/licenses/form.seats')</label>
					<div class="col-md-3">
						<input class="form-control" type="text" name="seats" id="seats" value="{{ Input::old('seats', $license->seats) }}" />
						{{ $errors->first('seats', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
				<label for="order_number" class="col-md-3 control-label">@lang('admin/licenses/form.order')</label>
					<div class="col-md-7">
						<input class="form-control" type="text" name="order_number" id="order_number" value="{{ Input::old('order_number', $license->order_number) }}" />
						{{ $errors->first('order_number', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<!-- Purchase Date -->
			<div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
				<label for="purchase_date" class="col-md-3 control-label">@lang('admin/licenses/form.date')</label>
				<div class="input-group col-md-2">
					<input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="purchase_date" id="purchase_date" value="{{ Input::old('purchase_date', $license->purchase_date) }}">
					<span class="input-group-addon"><i class="icon-calendar"></i></span>
				{{ $errors->first('purchase_date', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Purchase Cost -->
			<div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
				<label for="purchase_cost" class="col-md-3 control-label">@lang('admin/licenses/form.cost')</label>
				<div class="col-md-2">
					<div class="input-group">
						<span class="input-group-addon">@lang('general.currency')</span>
						<input class="col-md-2 form-control" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', $license->purchase_cost) }}" />
						{{ $errors->first('purchase_cost', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					 </div>
				 </div>
			</div>

			<!-- Depreciation -->
			<div class="form-group {{ $errors->has('depreciation_id') ? ' has-error' : '' }}">
				<label for="parent" class="col-md-3 control-label">@lang('admin/licenses/form.depreciation')</label>
					<div class="col-md-7">
						{{ Form::select('depreciation_id', $depreciation_list , Input::old('depreciation_id', $license->depreciation_id), array('class'=>'select2', 'style'=>'width:350px')) }}
						{{ $errors->first('depreciation_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

<!-- Notes -->
			<div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
				<label for="notes" class="col-md-3 control-label">@lang('admin/licenses/form.notes')</label>
				<div class="col-md-7">
					<input class="col-md-6 form-control" type="text" name="notes" id="notes" value="{{ Input::old('notes', $license->notes) }}" />
					{{ $errors->first('notes', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Form actions -->
				<div class="form-group">
				<label class="col-md-3 control-label"></label>
					<div class="col-md-7">

						<a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
						<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
					</div>
				</div>

</form>
</div>

@stop
