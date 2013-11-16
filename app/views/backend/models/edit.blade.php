@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($model->id)
		Update Model
	@else
		Create Model
	@endif
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		@if ($model->id)
		Update Model
		@else
			Create New Model
		@endif

		<div class="pull-right">
			<a href="{{ route('models') }}" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>

<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<!-- Model Title -->
			<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
				<label class="control-label" for="name">Model Name</label>
				<div class="controls">
					<input type="text" name="name" id="name" value="{{ Input::old('name', $model->name) }}" />
					{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
				<label class="control-label" for="modelno">Model No.</label>
				<div class="controls">
					<input type="text" name="modelno" id="modelno" value="{{ Input::old('modelno', $model->modelno) }}" />
					{{ $errors->first('modelno', '<span class="help-inline">:message</span>') }}
				</div>
			</div>


			<!-- Depreciation -->
			<div class="control-group {{ $errors->has('depreciation_id') ? 'error' : '' }}">
				<label class="control-label" for="parent">Depreciation</label>
				<div class="controls">
					{{ Form::select('depreciation_id', $depreciation_list , Input::old('depreciation_id', $model->depreciation_id)) }}
					{{ $errors->first('depreciation_id', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
		</div>


	</div>

	<!-- Form Actions -->
	<div class="control-group">
		<div class="controls">
			<a class="btn btn-link" href="{{ route('blogs') }}">Cancel</a>
			<button type="submit" class="btn btn-success">Save</button>
		</div>
	</div>
</form>
@stop
