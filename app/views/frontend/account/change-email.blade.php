@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Change your Email
@stop

{{-- Account page content --}}
@section('content')
<div class="row header">

    <div class="col-md-12">
        <h3>@lang('general.changeemail')</h3>
    </div>
</div>

<div class="row form-wrapper">
	@if (Config::get('app.lock_passwords') && ($user->id)) 
 	<p class="help-block">@lang('admin/users/table.lock_passwords')</p>
 	@endif


<form method="post" action="" class="form-horizontal" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <!-- Form type -->
    <input type="hidden" name="formType" value="change-email" />

    <!-- New Email -->
    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
        <label for="email" class="col-md-2 control-label">New Email
         <i class='fa fa-asterisk'></i>
         </label>
        <div class="col-md-5">
            <input class="form-control" type="email" name="email" id="email" value="{{{ Input::old('email', $user->email) }}}" {{ ((Config::get('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}>
            {{ $errors->first('email', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
        </div>
    </div>
    <!-- Confirm New Email -->
    <div class="form-group {{ $errors->has('email_confirm') ? ' has-error' : '' }}">
        <label for="email_confirm" class="col-md-2 control-label">Confirm New Email
        <i class='fa fa-asterisk'></i>
        </label>
        <div class="col-md-5">
            <input class="form-control" type="email" name="email_confirm" id="email_confirm" {{ ((Config::get('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}>
            {{ $errors->first('email_confirm', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
        </div>
    </div>

    <!-- Current Password -->
    <div class="form-group {{ $errors->has('current_password') ? ' has-error' : '' }}">
        <label for="current_password" class="col-md-2 control-label">Current Password
        <i class='fa fa-asterisk'></i>
        </label>
        <div class="col-md-5">
            <input class="form-control" type="password" name="current_password" id="current_password" {{ ((Config::get('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}>
            {{ $errors->first('current_password', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
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
