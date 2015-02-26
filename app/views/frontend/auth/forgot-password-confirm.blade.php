@extends('backend/layouts/default')

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
	<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="col-md-3 control-label">New Password
         <i class='fa fa-asterisk'></i>
         </label>
        <div class="col-md-5">
            <input class="form-control" type="password" name="password" id="password" />
            {{ $errors->first('password', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
        </div>
    </div>

    <!-- Password Confirm -->
    <div class="form-group {{ $errors->has('password_confirm') ? ' has-error' : '' }}">
        <label for="password_confirm" class="col-md-3 control-label">Password Confirmation
         <i class='fa fa-asterisk'></i>
         </label>
        <div class="col-md-5">
            <input class="form-control" type="password" name="password_confirm" id="password_confirm" />
            {{ $errors->first('password_confirm', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
        </div>
    </div>


    <!-- Form actions -->
    <div class="form-group">
        <label class="col-md-3 control-label"></label>
            <div class="col-md-7">
                <a class="btn btn-link" href="{{ route('home') }}">@lang('button.cancel')</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-ok icon-white"></i> @lang('button.submit')</button>
            </div>
        </div>

</form>
@stop
