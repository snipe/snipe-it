@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Change your Password
@stop

{{-- Account page content --}}
@section('content')
<div class="row header">

    <div class="col-md-12">
        <h3>@lang('general.changepassword')</h3>
    </div>
</div>

<div class="row form-wrapper">
<form method="post" action="" class="form-horizontal" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <!-- Old Password -->
    <div class="form-group {{ $errors->has('old_password') ? ' has-error' : '' }}">
        <label for="old_password" class="col-md-2 control-label">Old Password
        <i class='icon-asterisk'></i>
        </label>
        <div class="col-md-5">
            <input class="form-control" type="password" name="old_password" id="old_password" />
            {{ $errors->first('old_password', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
        </div>
    </div>

    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="col-md-2 control-label">New Password
        <i class='icon-asterisk'></i></label>
        <div class="col-md-5">
            <input class="form-control" type="password" name="password" id="password" />
            {{ $errors->first('password', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
        </div>
    </div>


    <div class="form-group {{ $errors->has('password_confirm') ? ' has-error' : '' }}">
        <label for="password_confirm" class="col-md-2 control-label">New Password
        <i class='icon-asterisk'></i>
        </label>
        <div class="col-md-5">
            <input class="form-control" type="password" name="password_confirm" id="password_confirm" />
            {{ $errors->first('password_confirm', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
        </div>
    </div>

    <hr>

    <!-- Form actions -->
    <div class="form-group">
	<label class="col-md-2 control-label"></label>
		<div class="col-md-7">
			<a class="btn btn-link" href="{{ route('view-assets') }}">@lang('button.cancel')</a>
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
			<a href="{{ route('forgot-password') }}" class="btn btn-link">I forgot my password</a>
		</div>
	</div>

</form>
@stop