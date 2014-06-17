@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

	@if ($depreciation->id)
		@lang('admin/depreciations/general.update_depreciation') ::
	@else
		@lang('admin/depreciations/general.update_depreciation') ::
	@endif

@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
    	<a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="icon-circle-arrow-left icon-white"></i>  @lang('general.back')</a>
		<h3>
		@if ($depreciation->id)
			@lang('admin/depreciations/general.update_depreciation')
		@else
			@lang('admin/depreciations/general.update_depreciation')
		@endif
		</h3>
	</div>
</div>
<div class="row form-wrapper">

<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- Name -->
			<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
				<label for="name" class="col-md-4 control-label">@lang('admin/depreciations/general.depreciation_name')</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $depreciation->name) }}" />
						{{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<!-- Name -->
			<div class="form-group {{ $errors->has('months') ? ' has-error' : '' }}">
				<label for="months" class="col-md-4 control-label">@lang('admin/depreciations/general.number_of_months')</label>
					<div class="col-md-1">
						<input class="form-control" type="text" name="months" id="months" value="{{ Input::old('name', $depreciation->months) }}" />
						{{ $errors->first('months', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<!-- Form actions -->
			<div class="form-group">
			<label class="col-md-4 control-label"></label>
				<div class="col-md-7">
					<a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
					<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
				</div>
			</div>

		</form>

</div>

@stop
