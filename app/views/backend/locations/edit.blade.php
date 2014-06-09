@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

	@if ($location->id)
		@lang('admin/locations/table.update') ::
	@else
		@lang('admin/locations/table.create') ::
	@endif

@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
    	<a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="icon-circle-arrow-left icon-white"></i>  @lang('general.back')</a>
		<h3>
		@if ($location->id)
			@lang('admin/locations/table.update')
		@else
			@lang('admin/locations/table.create')
		@endif
		</h3>
	</div>
</div>

<div class="row form-wrapper">

<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- Location Name -->
			<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
				<label for="name" class="col-md-2 control-label">@lang('admin/locations/table.name')</label>
					<div class="col-md-12">
						<div class="col-xs-8">
						<input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $location->name) }}" />
					</div>
					{{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<!-- Address -->
			<div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
				<label for="address" class="col-md-2 control-label">@lang('admin/locations/table.address')</label>
					<div class="col-md-12">
						<div class="col-xs-8">
						<input class="form-control" type="text" name="address" id="address" value="{{ Input::old('address', $location->address) }}" />
					</div>
					{{ $errors->first('address', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<!-- Address -->
			<div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">
				<label for="address2" class="col-md-2 control-label"></label>
					<div class="col-md-12">
						<div class="col-xs-8">
						<input class="form-control" type="text" name="address2" id="address2" value="{{ Input::old('address2', $location->address2) }}" />
					</div>
					{{ $errors->first('address2', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<!-- City -->
			<div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
				<label for="city" class="col-md-2 control-label">@lang('admin/locations/table.city')</label>
					<div class="col-md-12">
						<div class="col-xs-8">
						<input class="form-control" type="text" name="city" id="city" value="{{ Input::old('city', $location->city) }}" />
					</div>
					{{ $errors->first('city', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<!-- City -->
			<div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
				<label for="state" class="col-md-2 control-label">@lang('admin/locations/table.state')</label>
					<div class="col-md-12">
						<div class="col-xs-2">
						<input class="form-control" type="text" name="state" id="state" value="{{ Input::old('state', $location->state) }}" />
					</div>
					{{ $errors->first('state', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<!-- Zip -->
			<div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
				<label for="zip" class="col-md-2 control-label">@lang('admin/locations/table.zip')</label>
					<div class="col-md-12">
						<div class="col-xs-3">
						<input class="form-control" type="text" name="zip" id="zip" value="{{ Input::old('zip', $location->zip) }}" />
					</div>
					{{ $errors->first('zip', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<!-- Country -->
			<div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
				<label for="country" class="col-md-2 control-label">@lang('admin/locations/table.country')</label>
					<div class="col-md-12">
						<div class="col-xs-2">
						<input class="form-control" type="text" name="country" id="country" value="{{ Input::old('country', $location->country) }}" />
						</div>
						{{ $errors->first('country', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
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


@stop
