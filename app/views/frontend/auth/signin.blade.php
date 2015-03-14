@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Account Sign in ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <h3>Sign in into your account</h3>
    </div>
</div>

<div class="row form-wrapper">

    <form method="post" action="{{ route('signin') }}" class="form-horizontal">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <div class="form-group">
                <label class="col-md-6 control-label"></label>
                    <div class="col-md-5">
                        <br><a href="{{ route('forgot-password') }}" class="btn btn-link">I forgot my password</a>
                    </div>
                </div>

            <!-- Email -->
            <div class="form-group{{ $errors->first('email', ' error') }}">
                <label for="email" class="col-md-3 control-label">Email</label>
                    <div class="col-md-5">
                        <input class="form-control" type="email" name="email" id="email" value="{{{ Input::old('email') }}}" />
                        {{ $errors->first('email', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Password -->
            <div class="form-group{{ $errors->first('password', ' error') }}">
                <label for="password" class="col-md-3 control-label">Password</label>
                    <div class="col-md-5">
                        <input class="form-control" type="password" name="password" id="password" value="{{{ Input::old('password') }}}" />
                        {{ $errors->first('password', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>
            
            <!-- Form Actions -->
            <div class="form-group checkbox">
    		<div class="checkbox col-md-offset-3 col-md-3 col-sm-12">
    			<label>			
    				 	{{ Form::checkbox('remember-me', '1', Input::old('remember-me')) }}
    				 	Remember me	                 
    			</label>
    		</div>
                <div class="col-md-6 col-sm-12">
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-success"><i class="fa fa-ok icon-white"></i> Sign in</button>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <a href="{{ route('forgot-password') }}" class="btn btn-link">I forgot my password</a>
                    </div>
                </div>
            </div>
    </form>
</div>
@stop
