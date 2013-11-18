@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	Checkout License to User
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>Checkout License to User</h3>

		<div class="pull-right">
			<a href="{{ route('assets') }}" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
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
			<div class="control-group">
				<label class="control-label" for="asset_tag">Asset Tag</label>
				<div class="controls">
					<input class="span4" readonly="readonly" type="text" name="asset_tag" id="asset_tag" value="{{ $license->asset_tag }}" />
				</div>
			</div>

			<!-- Asset Name -->
			<div class="control-group">
				<label class="control-label" for="name">Asset Name</label>
				<div class="controls">
					<input class="span4" readonly="readonly" type="text" name="name" id="asset_name" value="{{ $license->name }}" />
				</div>
			</div>
			<!-- Asset Name -->
			<div class="control-group">
				<label class="control-label" for="serial">Serial</label>
				<div class="controls">
					<input class="span4" readonly="readonly" type="text" name="serial" id="serial" value="{{ $license->serial }}" />
				</div>
			</div>


			<!-- User -->
			<div class="control-group {{ $errors->has('assigned_to') ? 'error' : '' }}">
				<label class="control-label" for="parent">Checkout to</label>
				<div class="controls">
					{{ Form::select('assigned_to', $users_list , Input::old('assigned_to', $license->assigned_to)) }}
					{{ $errors->first('user_id', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

		</div>

	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<a class="btn btn-link" href="{{ route('assets') }}">@lang('general.cancel')</a>
			<button type="submit" class="btn btn-success">@lang('general.checkout')</button>
		</div>
	</div>
</form>


@stop
