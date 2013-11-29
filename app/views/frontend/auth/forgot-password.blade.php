@extends('frontend/layouts/default')

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

	<!-- Email -->
	<div class="form-group{{ $errors->first('email', ' error') }}">
		<label class="control-label" for="email">Email</label>
		<div class="controls">
			<input type="email" name="email" id="email" value="{{ Input::old('email') }}" />
			{{ $errors->first('email', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Form actions -->
	<div class="form-group">
		<div class="controls">
			<a class="btn" href="{{ route('home') }}">Cancel</a>

			<button type="submit" class="btn">Submit</button>
		</div>
	</div>
</form>
@stop
