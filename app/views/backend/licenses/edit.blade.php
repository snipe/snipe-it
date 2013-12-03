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

<div class="row header">
    <div class="col-md-12">
    	@if ($license->id)
			<a href="{{ route('view/license',$license->id) }}" class="btn-flat gray pull-right"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		@else
			<a href="{{ route('licenses') }}" class="btn-flat gray pull-right right"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		@endif

		<h3>
		@if ($license->id)
			Update License
		@else
			Create License
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
				<label for="name" class="col-md-3 control-label">Software Name</label>
					<div class="col-md-7">
						<input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $license->name) }}" />
						{{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }}">
				<label for="serial" class="col-md-3 control-label">Serial</label>
					<div class="col-md-7">
						<input class="form-control" type="text" name="serial" id="serial" value="{{ Input::old('serial', $license->serial) }}" />
						{{ $errors->first('serial', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<div class="form-group {{ $errors->has('license_name') ? ' has-error' : '' }}">
				<label for="license_name" class="col-md-3 control-label">Licensed to Name</label>
					<div class="col-md-7">
						<input class="form-control" type="text" name="license_name" id="license_name" value="{{ Input::old('license_name', $license->license_name) }}" />
						{{ $errors->first('license_name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<div class="form-group {{ $errors->has('license_email') ? ' has-error' : '' }}">
				<label for="license_email" class="col-md-3 control-label">Licensed to Email</label>
					<div class="col-md-7">
						<input class="form-control" type="text" name="license_email" id="license_email" value="{{ Input::old('license_email', $license->license_email) }}" />
						{{ $errors->first('license_email', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<div class="form-group {{ $errors->has('seats') ? ' has-error' : '' }}">
				<label for="seats" class="col-md-3 control-label">Seats</label>
					<div class="col-md-3">
						<input class="form-control" type="text" name="seats" id="seats" value="{{ Input::old('seats', $license->seats) }}" />
						{{ $errors->first('seats', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
				<label for="order_number" class="col-md-3 control-label">Order No.</label>
					<div class="col-md-7">
						<input class="form-control" type="text" name="order_number" id="order_number" value="{{ Input::old('order_number', $license->order_number) }}" />
						{{ $errors->first('order_number', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<!-- Purchase Date -->
			<div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
				<label for="purchase_date" class="col-md-3 control-label">Purchase Date</label>
				<div class="input-group col-md-2">
					<input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="purchase_date" id="purchase_date" value="{{ Input::old('purchase_date', $license->purchase_date) }}">
					<span class="input-group-addon"><i class="icon-calendar"></i></span>
				{{ $errors->first('purchase_date', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Purchase Cost -->
			<div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
				<label for="purchase_cost" class="col-md-3 control-label">Purchase Cost</label>
				<div class="col-md-2">
					<div class="input-group">
						<span class="input-group-addon">$</span>
						<input class="col-md-2 form-control" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', $license->purchase_cost) }}" />
						{{ $errors->first('purchase_cost', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					 </div>
				 </div>
			</div>

			<!-- Depreciation -->
			<div class="form-group {{ $errors->has('depreciation_id') ? ' has-error' : '' }}">
				<label for="parent" class="col-md-3 control-label">Depreciation</label>
					<div class="col-md-7">
						{{ Form::select('depreciation_id', $depreciation_list , Input::old('depreciation_id', $license->depreciation_id), array('class'=>'select2', 'style'=>'width:350px')) }}
						{{ $errors->first('depreciation_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

<!-- Notes -->
			<div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
				<label for="notes" class="col-md-3 control-label">Notes</label>
				<div class="col-md-7">
					<input class="col-md-6 form-control" type="text" name="notes" id="notes" value="{{ Input::old('notes', $license->notes) }}" />
					{{ $errors->first('notes', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Form actions -->
				<div class="form-group">
				<label class="col-md-3 control-label"></label>
					<div class="col-md-7">
						@if ($license->id)
						<a class="btn btn-link" href="{{ route('view/license', $license->id) }}">Cancel</a>
						@else
						<a class="btn btn-link" href="{{ route('licenses') }}">Cancel</a>
						@endif
						<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Save</button>
					</div>
				</div>

</form>
</div>

@stop
