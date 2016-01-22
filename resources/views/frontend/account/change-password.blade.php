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
        <i class='fa fa-asterisk'></i>
        </label>
        <div class="col-md-5">
            <input class="form-control" type="password" name="old_password" id="old_password" {{ (Config::get('app.lock_passwords') ? ' disabled' : '') }}>
            {{ $errors->first('old_password', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
        </div>
    </div>

    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="col-md-2 control-label">New Password
        <i class='fa fa-asterisk'></i></label>
        <div class="col-md-5">
            <input class="form-control" type="password" name="password" id="password" {{ (Config::get('app.lock_passwords') ? ' disabled' : '') }}>
            {{ $errors->first('password', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
        </div>
    </div>


    <div class="form-group {{ $errors->has('password_confirm') ? ' has-error' : '' }}">
        <label for="password_confirm" class="col-md-2 control-label">New Password
        <i class='fa fa-asterisk'></i>
        </label>
        <div class="col-md-5">
            <input class="form-control" type="password" name="password_confirm" id="password_confirm"  {{ (Config::get('app.lock_passwords') ? ' disabled' : '') }}>
            {{ $errors->first('password_confirm', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
            @if (Config::get('app.lock_passwords'))
            	<p class="help-block">@lang('admin/users/table.lock_passwords')</p>
            @endif
        </div>
    </div>

    <hr>

    <!-- Form actions -->
    <div class="form-group">
	<label class="col-md-2 control-label"></label>
		<div class="col-md-7">
			<a class="btn btn-link" href="{{ route('view-assets') }}">@lang('button.cancel')</a>
			<button type="submit" class="btn btn-success" {{ ((Config::get('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
		</div>
	</div>

</form>
@stop
