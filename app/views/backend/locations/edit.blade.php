@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

	@if ($location->id)
		Update Location
	@else
		Create Location
	@endif

@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		@if ($location->id)
			Update Location
		@else
			Create Location
		@endif

		<div class="pull-right">
			<a href="{{ route('locations') }}" class="btn-flat gray"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>


<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Tabs Content -->
	<div class="tab-content">

	<div class="tab-pane active" id="tab-general">
			<!-- Class Title -->
			<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
				<label class="control-label" for="name">Location Name</label>
				<div class="controls">
					<input class="span4" type="text" name="name" id="name" value="{{ Input::old('name', $location->name) }}" />
					{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
			<div class="control-group {{ $errors->has('address') ? 'error' : '' }}">
				<label class="control-label" for="address">Street Address 1</label>
				<div class="controls">
					<input class="span4" type="text" name="address" id="address" value="{{ Input::old('address', $location->address) }}" />
					{{ $errors->first('address', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
			<div class="control-group {{ $errors->has('address2') ? 'error' : '' }}">
				<label class="control-label" for="address2">Street Address 2</label>
				<div class="controls">
					<input class="span4" type="text" name="address2" id="address2" value="{{ Input::old('address2', $location->address2) }}" />
					{{ $errors->first('address2', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
			<div class="control-group {{ $errors->has('city') ? 'error' : '' }}">
				<label class="control-label" for="name">City</label>
				<div class="controls">
					<input class="span4" type="text" name="city" id="city" value="{{ Input::old('city', $location->city) }}" />
					{{ $errors->first('city', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<div class="control-group {{ $errors->has('state') ? 'error' : '' }}">
				<label class="control-label" for="state">State Abbrev</label>
				<div class="controls">
					<input class="span2" type="text" name="state" id="state" value="{{ Input::old('state', $location->state) }}" />
					{{ $errors->first('state', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<div class="control-group {{ $errors->has('zip') ? 'error' : '' }}">
				<label class="control-label" for="zip">Postal Code</label>
				<div class="controls">
					<input class="span2" type="text" name="zip" id="zip" value="{{ Input::old('zip', $location->zip) }}" />
					{{ $errors->first('zip', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<div class="control-group {{ $errors->has('country') ? 'error' : '' }}">
				<label class="control-label" for="state">Country Abbrev</label>
				<div class="controls">
					<input class="span2" type="text" name="country" id="country" value="{{ Input::old('country', $location->country) }}" />
					{{ $errors->first('country', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
		</div>


	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<a class="btn btn-link" href="{{ route('locations') }}">@lang('general.cancel')</a>
			<button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
		</div>
	</div>
</form>


@stop
