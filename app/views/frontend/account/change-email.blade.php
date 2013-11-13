@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Change your Email
@stop

{{-- Account page content --}}
@section('account-content')
<div class="page-header">
	<h4>Change your Email</h4>
</div>

<form method="post" action="" class="form-horizontal" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Form type -->
	<input type="hidden" name="formType" value="change-email" />

	<!-- New Email -->
	<div class="control-group{{ $errors->first('email', ' error') }}">
		<label class="control-label" for="email">New Email</label>
		<div class="controls">
			<input type="text" name="email" id="email" value="" />
			{{ $errors->first('email', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Confirm New Email -->
	<div class="control-group{{ $errors->first('email_confirm', ' error') }}">
		<label class="control-label" for="email_confirm">Confirm New Email</label>
		<div class="controls">
			<input type="text" name="email_confirm" id="email_confirm" value="" />
			{{ $errors->first('email_confirm', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Current Password -->
	<div class="control-group{{ $errors->first('current_password', ' error') }}">
		<label class="control-label" for="current_password">Current Password</label>
		<div class="controls">
			<input type="password" name="current_password" id="current_password" value="" />
			{{ $errors->first('current_password', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<hr>

	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">Update Email</button>

			<a href="{{ route('forgot-password') }}" class="btn btn-link">I forgot my password</a>
		</div>
	</div>
</form>
@stop
