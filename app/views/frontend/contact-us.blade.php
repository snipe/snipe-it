@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
Contact us ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>Contact us</h3>
</div>
<form method="post" action="">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<fieldset>
		<!-- Name -->
		<div  class="control-group{{ $errors->first('name', ' error') }}">
			<input type="text" id="name" name="name" class="input-block-level" placeholder="Name">
			{{ $errors->first('name', '<span class="help-block">:message</span>') }}
		</div>

		<!-- Email -->
		<div  class="control-group{{ $errors->first('email', ' error') }}">
			<input type="text" id="email" name="email" class="input-block-level" placeholder="Email">
			{{ $errors->first('email', '<span class="help-block">:message</span>') }}
		</div>
		<!-- Description -->
		<div  class="control-group{{ $errors->first('description', ' error') }}">
			<textarea rows="4" id="description" name="description" class="input-block-level" placeholder="Description"></textarea>
			{{ $errors->first('description', '<span class="help-block">:message</span>') }}
		</div>

		<!-- Form actions -->
		<button type="submit" class="btn btn-warning pull-right">Submit</button>
	</fieldset>
</form>
@stop
