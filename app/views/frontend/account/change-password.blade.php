@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Change your Password
@stop

{{-- Account page content --}}
@section('account-content')
<div class="page-header">
	<h4>Change your Password</h4>
</div>

<form method="post" action="" class="form-horizontal" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Old Password -->
	<div class="control-group{{ $errors->first('old_password', ' error') }}">
		<label class="control-label" for="old_password">Old Password</label>
		<div class="controls">
			<input type="password" name="old_password" id="old_password" value="" />
			{{ $errors->first('old_password', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- New Password -->
	<div class="control-group{{ $errors->first('password', ' error') }}">
		<label class="control-label" for="password">New Password</label>
		<div class="controls">
			<input type="password" name="password" id="password" value="" />
			{{ $errors->first('password', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Confirm New Password  -->
	<div class="control-group{{ $errors->first('password_confirm', ' error') }}">
		<label class="control-label" for="password_confirm">Confirm New Password</label>
		<div class="controls">
			<input type="password" name="password_confirm" id="password_confirm" value="" />
			{{ $errors->first('password_confirm', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<hr>

	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">Update Password</button>

			<a href="{{ route('forgot-password') }}" class="btn btn-link">I forgot my password</a>
		</div>
	</div>
</form>
@stop

@section('contenxt')

<div class="tabbable tabs-left">
	<!-- Tabs -->
	<ul class="nav nav-tabs">
		<li{{ Session::get('form', 'update-details') == 'update-details' ? ' class="active"' : '' }}><a href="#tab-general" data-toggle="tab">Profile</a></li>
		<li{{ Session::get('form') == 'change-password' ? ' class="active"' : '' }}><a href="#tab-password" data-toggle="tab">Change Password</a></li>
		<li{{ Session::get('form') == 'change-email' ? ' class="active"' : '' }}><a href="#tab-email" data-toggle="tab">Change Email</a></li>
	</ul>

	<!-- Tabs content -->
	<div class="tab-content">

		<!-- Change Email -->
		<div class="tab-pane{{ Session::get('form') == 'change-email' ? ' active' : '' }}" id="tab-email">
			<form method="post" action="" class="form-horizontal" autocomplete="off">
				<!-- CSRF Token -->
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />

				<!-- Form type -->
				<input type="hidden" name="formType" value="change-email" />

				<!-- Old Password -->
				<div class="control-group{{ $errors->first('old_password', ' error') }}">
					<label class="control-label" for="old_password">Old Password</label>
					<div class="controls">
						<input type="password" name="old_password" id="old_password" value="" />
						{{ $errors->first('old_password', '<span class="help-block">:message</span>') }}
					</div>
				</div>

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

				<!-- Form actions -->
				<div class="control-group">
					<div class="controls">
						<a class="btn" href="{{ route('home') }}">Cancel</a>

						<button type="submit" class="btn btn-info">Update</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@stop
