@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	 @lang('admin/licenses/general.checkout') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
		<a href="{{ URL::previous() }}" class="btn-flat gray pull-right">
		<i class="icon-circle-arrow-left icon-white"></i> @lang('general.back')</a>
		<h3>
			@lang('admin/licenses/general.checkout')
		</h3>
	</div>
</div>

<div class="row form-wrapper">
<!-- left column -->
<div class="col-md-10 column">

<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- Asset name -->
		  	<div class="form-group">
			<label class="col-sm-2 control-label">@lang('admin/hardware/form.name')</label>
				<div class="col-md-6">
				  <p class="form-control-static">{{ $licenseseat->license->name }}</p>
				</div>
		  	</div>

			<!-- Serial -->
		  	<div class="form-group">
			<label class="col-sm-2 control-label">@lang('admin/hardware/form.serial')</label>
				<div class="col-md-6">
				  <p class="form-control-static">{{ $licenseseat->license->serial }}</p>
				</div>
		  	</div>

			<!-- User -->
			<div class="form-group {{ $errors->has('assigned_to') ? ' has-error' : '' }}">
				<label for="assigned_to" class="col-md-2 control-label">@lang('admin/hardware/form.checkout_to')</label>
				<div class="col-md-7">
					{{ Form::select('assigned_to', $users_list , Input::old('assigned_to', $licenseseat->assigned_to), array('class'=>'select2', 'style'=>'min-width:350px')) }}
					{{ $errors->first('assigned_to', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Note -->
			<div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
				<label for="note" class="col-md-2 control-label">@lang('admin/hardware/form.notes')</label>
				<div class="col-md-7">
					<input class="col-md-6 form-control" type="text" name="note" id="note" value="{{ Input::old('note', $licenseseat->note) }}" />
					{{ $errors->first('note', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>


			<!-- Form actions -->
			<div class="form-group">
			<label class="col-md-2 control-label"></label>
				<div class="col-md-7">
					<a class="btn btn-link" href="{{ route('licenses') }}">@lang('general.cancel')</a>
					<button type="submit"  class="btn btn-success"><i class="icon-ok icon-white"></i>  @lang('general.checkout')</button>
				</div>
			</div>


</form>

</div>
</div>

@stop
