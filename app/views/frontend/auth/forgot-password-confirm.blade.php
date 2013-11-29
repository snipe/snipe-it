@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
Forgot Password ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>Forgot Password</h3>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- New Password -->
	<div class="form-group{{ $errors->first('password', ' error') }}">
		<label class="control-label" for="password">New Password</label>
		<div class="controls">
			<input type="password" name="password" id="password" value="{{ Input::old('password') }}" />
			{{ $errors->first('password', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Password Confirm -->
	<div class="form-group{{ $errors->first('password_confirm', ' error') }}">
		<label class="control-label" for="password_confirm">Password Confirmation</label>
		<div class="controls">
			<input type="password" name="password_confirm" id="password_confirm" value="{{ Input::old('password_confirm') }}" />
			{{ $errors->first('password_confirm', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Form actions -->
	<div class="form-group">
		<div class="controls">
			<a class="btn" href="{{ route('home') }}">Cancel</a>

			<button type="submit" class="btn btn-info">Submit</button>
		</div>
	</div>
</form>
@stop
