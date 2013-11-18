@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

	@if ($depreciation->id)
		Update Depreciation
	@else
		Create Depreciation
	@endif

@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		@if ($depreciation->id)
			Update Depreciation
		@else
			Create Depreciation
		@endif

		<div class="pull-right">
			<a href="{{ route('depreciations') }}" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>


<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Tabs Content -->
	<div class="tab-content">


	<div class="tab-pane active" id="tab-general">
			<!-- Class Title -->
			<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
				<label class="control-label" for="name">Depreciation Class Name</label>
				<div class="controls">
					<input class="span6" type="text" name="name" id="name" value="{{ Input::old('name', $depreciation->name) }}" />
					{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
			<!-- Months -->
			<div class="control-group {{ $errors->has('months') ? 'error' : '' }}">
				<label class="control-label" for="name">Number of Months</label>
				<div class="controls">
					<input class="span2" type="text" name="months" id="months" value="{{ Input::old('months', $depreciation->months) }}" />
					{{ $errors->first('months', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
		</div>


	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<a class="btn btn-link" href="{{ route('depreciations') }}">@lang('general.cancel')</a>
			<button type="submit" class="btn btn-success">@lang('general.save')</button>
		</div>
	</div>
</form>


@stop
