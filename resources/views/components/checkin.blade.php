@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/components/general.checkin') }}
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  {{ trans('general.back') }}</a>
        <h3> {{ trans('general.checkin') }}</h3>
    </div>
</div>

<div class="row form-wrapper">
<!-- left column -->
<div class="col-md-10 column">

<form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

		@if ($component->name)
		<!-- consumable name -->
		<div class="form-group">
		<label class="col-sm-2 control-label">{{ trans('admin/components/general.component_name') }}</label>
			<div class="col-md-6">
			<p class="form-control-static">{{ $component->name }}</p>
			</div>
		</div>
		@endif
		
		<!-- Serial -->
		<div class="form-group">
		<label class="col-sm-2 control-label">{{ trans('admin/hardware/form.serial') }}</label>
			<div class="col-md-6">
			  <p class="form-control-static">{{ $component->serial }}</p>
			</div>
		</div>
		
		<!-- QTY -->
		<div class="form-group">
		<label class="col-sm-2 control-label">{{ trans('general.qty') }}</label>
			<div class="col-md-6">
			  <p class="form-control-static">{{ $component_asset->assigned_qty }}</p>
			</div>
		</div>
		

		<!-- Note -->
		<div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
			<label for="note" class="col-md-2 control-label">{{ trans('admin/hardware/form.notes') }}</label>
			<div class="col-md-7">
				<textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note', $component->note) }}</textarea>
				{!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
			</div>
		</div>

			
        <!-- Form actions -->
		<div class="form-group">
		<label class="col-md-2 control-label"></label>
			<div class="col-md-7">
				<a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
				<button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i>{{ trans('general.checkin') }}</button>
			</div>
		</div>

</form>
</div>
</div>

@stop
