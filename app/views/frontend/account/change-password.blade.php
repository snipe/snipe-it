@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Change your Password
@stop

{{-- Account page content --}}
@section('account-content')
<div class="row header">

    <div class="col-md-12">
		<h3>Change Your Password</h3>
	</div>
</div>

<div class="row form-wrapper">
<form method="post" action="" class="form-horizontal" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Old Password -->
	<div class="form-group {{ $errors->has('old_password') ? ' has-error' : '' }}">
		<label for="old_password" class="col-md-2 control-label">Old Password</label>
		<div class="col-md-5">
			<input class="form-control" type="text" name="old_password" id="old_password" />
			{{ $errors->first('old_password', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
		</div>
	</div>

	<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
		<label for="password" class="col-md-2 control-label">New Password</label>
		<div class="col-md-5">
			<input class="form-control" type="password" name="password" id="password" />
			{{ $errors->first('password', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
		</div>
	</div>


	<div class="form-group {{ $errors->has('password_confirm') ? ' has-error' : '' }}">
		<label for="password_confirm" class="col-md-2 control-label">New Password</label>
		<div class="col-md-5">
			<input class="form-control" type="password" name="password_confirm" id="password_confirm" />
			{{ $errors->first('password_confirm', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
		</div>
	</div>

	<hr>

	<!-- Form actions -->
	<div class="form-group">
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
				<div class="form-group{{ $errors->first('old_password', ' error') }}">
					<label class="control-label" for="old_password">Old Password</label>
					<div class="controls">
						<input type="password" name="old_password" id="old_password" value="" />
						{{ $errors->first('old_password', '<span class="help-block">:message</span>') }}
					</div>
				</div>

				<!-- New Email -->
				<div class="form-group{{ $errors->first('email', ' error') }}">
					<label class="control-label" for="email">New Email</label>
					<div class="controls">
						<input type="email" name="email" id="email" value="" />
						{{ $errors->first('email', '<span class="help-block">:message</span>') }}
					</div>
				</div>

				<!-- Confirm New Email -->
				<div class="form-group{{ $errors->first('email_confirm', ' error') }}">
					<label class="control-label" for="email_confirm">Confirm New Email</label>
					<div class="controls">
						<input type="email" name="email_confirm" id="email_confirm" value="" />
						{{ $errors->first('email_confirm', '<span class="help-block">:message</span>') }}
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
	</div>
</div>
@stop
