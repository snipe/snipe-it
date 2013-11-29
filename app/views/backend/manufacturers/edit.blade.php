@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($manufacturer->id)
		Update Manufacturer
	@else
		Create manufacturer
	@endif
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">

	<div class="pull-right">
		<a href="{{ route('manufacturers') }}" class="btn-flat gray"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
	</div>

	<h3>
		@if ($manufacturer->id)
		Update Manufacturer
		@else
			Create manufacturer
		@endif

	</h3>
</div>


<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Tabs Content -->
	<div class="tab-content">

		<div class="tab-pane active" id="tab-general">
			<!-- Category Title -->
			<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
				<label class="control-label" for="name">Manufacturer Name</label>
				<div class="controls">
					<input type="text" name="name" id="name" value="{{ Input::old('name', $manufacturer->name) }}" />
					{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

		</div>

	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<a class="btn btn-link" href="{{ route('manufacturers') }}">@lang('general.cancel')</a>
			<button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
		</div>
	</div>
</form>


@stop
