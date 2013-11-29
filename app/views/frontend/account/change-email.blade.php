@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Change your Email
@stop

{{-- Account page content --}}
@section('account-content')
<div class="row header">

    <div class="col-md-12">
		<h3>Change Your Email</h3>
	</div>
</div>

<div class="row form-wrapper">

<form method="post" action="" class="form-horizontal" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Form type -->
	<input type="hidden" name="formType" value="change-email" />

	<!-- New Email -->
	<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
		<label for="email" class="col-md-2 control-label">New Email</label>
		<div class="col-md-5">
			<input class="form-control" type="email" name="email" id="email" value="{{ Input::old('email', $user->email) }}" />
			{{ $errors->first('email', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
		</div>
	</div>
	<!-- Confirm New Email -->
	<div class="form-group {{ $errors->has('email_confirm') ? ' has-error' : '' }}">
		<label for="email_confirm" class="col-md-2 control-label">New Email</label>
		<div class="col-md-5">
			<input class="form-control" type="email" name="email_confirm" id="email_confirm" />
			{{ $errors->first('email_confirm', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
		</div>
	</div>

	<!-- Current Password -->
	<div class="form-group {{ $errors->has('current_password') ? ' has-error' : '' }}">
		<label for="current_password" class="col-md-2 control-label">Current Password</label>
		<div class="col-md-5">
			<input class="form-control" type="password" name="current_password" id="current_password" />
			{{ $errors->first('current_password', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
		</div>
	</div>


	<hr>

	<!-- Form actions -->
	<div class="form-group">
		<div class="controls">
			<button type="submit" class="btn">Update Email</button>

			<a href="{{ route('forgot-password') }}" class="btn btn-link">I forgot my password</a>
		</div>
	</div>
</form>
@stop
