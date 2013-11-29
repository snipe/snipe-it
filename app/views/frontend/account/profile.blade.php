@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Your Profile
@stop

{{-- Account page content --}}
@section('account-content')
<div class="row header">

    <div class="col-md-12">
		<h3>Update Profile</h3>
	</div>
</div>

<div class="row form-wrapper">

<form method="post"  class="form-horizontal" action="" class="form-vertical" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- First Name -->
	<div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
		<label for="first_name" class="col-md-2 control-label">First Name</label>
		<div class="col-md-5">
			<input class="form-control" type="text" name="first_name" id="first_name" value="{{ Input::old('first_name', $user->first_name) }}" />
			{{ $errors->first('first_name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
		</div>
	</div>

	<!-- Last Name -->
	<div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
		<label for="last_name" class="col-md-2 control-label">Last Name</label>
		<div class="col-md-5">
			<input class="form-control" type="text" name="last_name" id="last_name" value="{{ Input::old('last_name', $user->last_name) }}" />
			{{ $errors->first('last_name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
		</div>
	</div>

	<!-- Website URL -->
	<div class="form-group {{ $errors->has('website') ? ' has-error' : '' }}">
		<label for="website" class="col-md-2 control-label">Website</label>
		<div class="col-md-5">
			<input class="form-control" type="text" name="website" id="website" value="{{ Input::old('website', $user->website) }}" />
			{{ $errors->first('website', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
		</div>
	</div>

	<!-- Location -->
		<div class="form-group {{ $errors->has('phone') ? 'error' : '' }}">
			<label class="col-md-2 control-label" for="location_id">Location</label>
			<div class="col-md-5">
				<div class="field-box">
				{{ Form::select('location_id', $location_list , Input::old('location_id', $user->location_id), array('class'=>'select2', 'style'=>'width:300px')) }}
				{{ $errors->first('location_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>
		</div>

	<!-- Gravatar Email -->
	<div class="form-group {{ $errors->has('gravatar') ? ' has-error' : '' }}">
		<label for="gravatar" class="col-md-2 control-label">Gravatar Email <small>(Private)</small></label>
		<div class="col-md-5">
			<input class="form-control" type="text" name="gravatar" id="gravatar" value="{{ Input::old('gravatar', $user->gravatar) }}" />
			{{ $errors->first('gravatar', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
			<p><img src="//secure.gravatar.com/avatar/{{ md5(strtolower(trim($user->gravatar))) }}" width="30" height="30" />
			<a href="http://gravatar.com"><small>Change your avatar at Gravatar.com</small></a>.
		</p>
		</div>
	</div>

	<!-- Form Actions -->
	<div class="form-group">
		<label class="col-md-2 control-label"></label>
		<div class="col-md-7">
			<a class="btn btn-link" href="{{ route('home') }}">@lang('general.cancel')</a>
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
		</div>
	</div>



</form>
</div>
@stop
