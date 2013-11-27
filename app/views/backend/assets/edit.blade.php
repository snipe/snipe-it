@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($asset->id)
	Asset Update ::
	@else
	Create Asset ::
	@endif
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
	@if ($asset->id)
	Asset Update
	@else
	Create Asset
	@endif

		<div class="pull-right">
			<a href="{{ route('assets') }}" class="btn-flat gray"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>


<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Tabs Content -->
	<div class="tab-content">

		<div class="tab-pane active" id="tab-general">



			<!-- Asset Tag -->
			<div class="control-group {{ $errors->has('asset_tag') ? 'error' : '' }}">
				<label class="control-label" for="asset_tag">Asset Tag</label>
				<div class="controls">
					<input class="span4" type="text" name="asset_tag" id="asset_tag" value="{{ Input::old('asset_tag', $asset->asset_tag) }}" />
					{{ $errors->first('asset_tag', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>
			<!-- Asset Title -->
			<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
				<label class="control-label" for="name">Asset Name</label>
				<div class="controls">
					<input class="span4" type="text" name="name" id="name" value="{{ Input::old('name', $asset->name) }}" />
					{{ $errors->first('name', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>


			<!-- Serial -->
			<div class="control-group {{ $errors->has('serial') ? 'error' : '' }}">
				<label class="control-label" for="serial">Serial</label>
				<div class="controls">
					<input class="span4" type="text" name="serial" id="serial" value="{{ Input::old('serial', $asset->serial) }}" />
					{{ $errors->first('serial', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Order Number -->
			<div class="control-group {{ $errors->has('order_number') ? 'error' : '' }}">
				<label class="control-label" for="order_number">Order Number</label>
				<div class="controls">
					<input class="span4" type="text" name="order_number" id="order_number" value="{{ Input::old('order_number', $asset->order_number) }}" />
					{{ $errors->first('order_number', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

				<!-- Model -->
			<div class="control-group {{ $errors->has('model_id') ? 'error' : '' }}">
				<label class="control-label" for="parent">Model</label>
				<div class="controls">
					{{ Form::select('model_id', $model_list , Input::old('model_id', $asset->model_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
					{{ $errors->first('model_id', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Purchase Date -->
			<div class="control-group input-append {{ $errors->has('purchase_date') ? 'error' : '' }}" >
				<label class="control-label" for="purchase_date">Purchase Date</label>
				<div class="controls">
				<input type="text" class="datepicker span2" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="purchase_date" id="purchase_date" value="{{ Input::old('purchase_date', $asset->purchase_date) }}">
				{{ $errors->first('purchase_date', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}

				</div>
			</div>

			<!-- Purchase Cost -->
			<div class="control-group {{ $errors->has('purchase_cost') ? 'error' : '' }}">
				<label class="control-label" for="purchase_cost">Purchase Cost</label>
				<div class="controls">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="span2" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', $asset->purchase_cost) }}" />
					{{ $errors->first('purchase_cost', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
				 </div>
			</div>

			<!-- Warrantee -->
			<div class="control-group {{ $errors->has('warranty_months') ? 'error' : '' }}">
				<label class="control-label" for="serial">Warranty</label>
				<div class="controls">
					<input class="span1" type="text" name="warranty_months" id="warranty_months" value="{{ Input::old('warranty_months', $asset->warranty_months) }}" />  months
					{{ $errors->first('warranty_months', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Depreciation -->
			<div class="control-group {{ $errors->has('depreciation_id') ? 'error' : '' }}">
				<label class="control-label" for="parent">Depreciation</label>
				<div class="controls">
					<div class="field-box">
					{{ Form::select('depreciation_id', $depreciation_list , Input::old('depreciation_id', $asset->depreciation_id), array('class'=>'select2', 'style'=>'width:250px')) }}
					{{ $errors->first('depreciation_id', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
				</div>
			</div>

			<!-- Status -->
			<div class="control-group {{ $errors->has('status_id') ? 'error' : '' }}">
				<label class="control-label" for="parent">Status</label>
				<div class="controls">
					<div class="field-box">
					{{ Form::select('status_id', $statuslabel_list , Input::old('status_id', $asset->status_id), array('class'=>'select2', 'style'=>'width:250px')) }}
					{{ $errors->first('depreciation_id', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
				</div>
			</div>


			<!-- Notes -->
			<div class="control-group {{ $errors->has('notes') ? 'error' : '' }}">
				<label class="control-label" for="notes">Notes</label>
				<div class="controls">
					<input class="span6" type="text" name="notes" id="notes" value="{{ Input::old('notes', $asset->notes) }}" />
					{{ $errors->first('notes', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>




		</div>

	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<a class="btn btn-link" href="{{ route('assets') }}">Cancel</a>
			<button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i> Save</button>
		</div>
	</div>
</form>


@stop
