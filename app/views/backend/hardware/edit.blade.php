@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($asset->id)
	@lang('admin/hardware/form.update') ::
	@else
	@lang('admin/hardware/form.create') ::
	@endif
@parent
@stop

{{-- Page content --}}

@section('content')

<div class="row header">
    <div class="col-md-12">
			<a href="{{ URL::previous() }}" class="btn-flat gray pull-right right"><i class="icon-circle-arrow-left icon-white"></i> @lang('general.back')</a>
		<h3>
		@if ($asset->id)
		@lang('admin/hardware/form.update')
			@else
				@lang('admin/hardware/form.create')
			@endif
		</h3>
	</div>
</div>

<div class="row form-wrapper">
            <!-- left column -->
            <div class="col-md-10 column">

			<form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- Asset Tag -->
			<div class="form-group {{ $errors->has('asset_tag') ? ' has-error' : '' }}">
				<label for="asset_tag" class="col-md-2 control-label">@lang('admin/hardware/form.tag')</label>
					<div class="col-md-7">
						<input class="form-control" type="text" name="asset_tag" id="asset_tag" value="{{ Input::old('asset_tag', $asset->asset_tag) }}" />
						{{ $errors->first('asset_tag', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<!-- Asset Title -->
			<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
				<label for="name" class="col-md-2 control-label">@lang('admin/hardware/form.name')</label>
					<div class="col-md-7">
						<input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $asset->name) }}" />
						{{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>
			<!-- Serial -->
			<div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }}">
				<label for="serial" class="col-md-2 control-label">@lang('admin/hardware/form.serial')</label>
				<div class="col-md-7">
					<input class="form-control" type="text" name="serial" id="serial" value="{{ Input::old('serial', $asset->serial) }}" />
					{{ $errors->first('serial', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Order Number -->
			<div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
				<label for="order_number" class="col-md-2 control-label">@lang('admin/hardware/form.order')</label>
				<div class="col-md-7">
					<input class="form-control" type="text" name="order_number" id="order_number" value="{{ Input::old('order_number', $asset->order_number) }}" />
					{{ $errors->first('order_number', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Model -->
			<div class="form-group {{ $errors->has('model_id') ? ' has-error' : '' }}">
				<label for="parent" class="col-md-2 control-label">@lang('admin/hardware/form.model')</label>
				<div class="col-md-7">
					{{ Form::select('model_id', $model_list , Input::old('model_id', $asset->model_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
					{{ $errors->first('model_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Purchase Date -->
			<div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
				<label for="purchase_date" class="col-md-2 control-label">@lang('admin/hardware/form.date')</label>
				<div class="input-group col-md-2">
					<input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="purchase_date" id="purchase_date" value="{{ Input::old('purchase_date', $asset->purchase_date) }}">
					<span class="input-group-addon"><i class="icon-calendar"></i></span>
				{{ $errors->first('purchase_date', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Purchase Cost -->
			<div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
				<label for="purchase_cost" class="col-md-2 control-label">@lang('admin/hardware/form.cost')</label>
				<div class="col-md-2">
					<div class="input-group">
						<span class="input-group-addon">@lang('general.currency')</span>
						<input class="col-md-2 form-control" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', $asset->purchase_cost) }}" />
						{{ $errors->first('purchase_cost', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					 </div>
				 </div>
			</div>

			<!-- Warrantee -->
			<div class="form-group {{ $errors->has('warranty_months') ? ' has-error' : '' }}">
				<label for="warranty_months" class="col-md-2 control-label">@lang('admin/hardware/form.warranty')</label>
				<div class="col-md-2">
					<div class="input-group">
					<input class="col-md-2 form-control" type="text" name="warranty_months" id="warranty_months" value="{{ Input::old('warranty_months', $asset->warranty_months) }}" />   <span class="input-group-addon">@lang('admin/hardware/form.months')</span>
					{{ $errors->first('warranty_months', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
				</div>
			</div>

			<!-- Status -->
			<div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
				<label for="status_id" class="col-md-2 control-label">@lang('admin/hardware/form.status')</label>
					<div class="col-md-7">
						{{ Form::select('status_id', $statuslabel_list , Input::old('status_id', $asset->status_id), array('class'=>'select2', 'style'=>'width:350px')) }}
						{{ $errors->first('status_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<!-- Notes -->
			<div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
				<label for="notes" class="col-md-2 control-label">@lang('admin/hardware/form.notes')</label>
				<div class="col-md-7">
					<input class="col-md-6 form-control" type="text" name="notes" id="notes" value="{{ Input::old('notes', $asset->notes) }}" />
					{{ $errors->first('notes', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Form actions -->
				<div class="form-group">
				<label class="col-md-2 control-label"></label>
					<div class="col-md-7">
						<a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
						<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
					</div>
				</div>

		</form>
	</div>
</div>
@stop
