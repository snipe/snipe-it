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
<div class="row form-wrapper">
<form method="post" action="" class="form-horizontal">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Email -->
	<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
		<label class="col-md-3 control-label" for="email">@lang('admin/users/table.email')
		<i class='fa fa-asterisk'></i>
		</label>
		<div class="col-md-5">
			<input class="form-control" type="text" name="email" id="email" value="{{{ Input::old('email') }}}" />
			{{ $errors->first('email', '<br><span class="alert-msg">:message</span>') }}
		</div>
    </div>


    <!-- Form actions -->
    <div class="form-group">
        <label class="col-md-3 control-label"></label>
            <div class="col-md-7">
                <a class="btn btn-link" href="{{ route('home') }}">@lang('button.cancel')</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('button.submit')</button>
            </div>
        </div>
</form>
</div>
@stop
