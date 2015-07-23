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

<div class="col-md-6 col-md-offset-1">

    <form method="post" action="{{ route('signin') }}" class="form-horizontal">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        
            <!-- Email -->
            <div class="form-group{{ $errors->first('email', ' error') }}">
                <label for="email" class="col-md-5 col-sm-12 control-label">Email</label>
                    <div class="col-md-7 col-sm-12">
                        <input class="form-control" type="email" name="email" id="email" value="{{{ Input::old('email') }}}" />
                        {{ $errors->first('email', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Password -->
            <div class="form-group{{ $errors->first('password', ' error') }}">
                <label for="password" class="col-md-5 col-sm-12 control-label">Password</label>
                    <div class="col-md-7 col-sm-12">
                        <input class="form-control" type="password" name="password" id="password" value="{{{ Input::old('password') }}}" />
                        {{ $errors->first('password', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>
            
            <!-- Form Actions -->
            <div class="col-md-7 col-sm-12 col-xs-12 col-md-offset-5">
       
	    		<div class="form-group checkbox col-md-4 col-sm-12 col-xs-7">
	    			<label>			
	    				 	{{ Form::checkbox('remember-me', '1', Input::old('remember-me'), array('style'=>'margin-left: 0px; margin-right: 5px;')) }}
	    				 	Remember me	                 
	    			</label>
	    		</div>
	    		<div class="col-md-4 col-sm-6 col-xs-6 pull-right">
	                 <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> Sign in</button>
	            </div>                    
	            
            </div>
            <div class="col-md-7 col-sm-12 col-xs-6 col-md-offset-5 text-right" style="padding-top: 15px;">
	                <a href="{{ route('forgot-password') }}">I forgot my password</a>
	            </div>
        
    </form>
</div>
@stop
