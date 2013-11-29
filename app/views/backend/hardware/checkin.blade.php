@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($asset->id)
	Checkin Asset ::
	@else
	Checkin Asset ::
	@endif
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
		<div class="pull-right">
			<a href="{{ route('hardware') }}" class="btn-flat gray"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
		<h3> Checkin Asset </h3>
</div>

<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />


			<!-- Asset Tag -->
			<div class="control-group">
				<label class="control-label" for="asset_tag">Asset Tag</label>
				<div class="controls">
					<input class="span4" readonly="readonly" type="text" name="asset_tag" id="asset_tag" value="{{ $asset->asset_tag }}" />
				</div>
			</div>

			<!-- Asset Name -->
			<div class="control-group">
				<label class="control-label" for="name">Asset Name</label>
				<div class="controls">
					<input class="span4" readonly="readonly" type="text" name="name" id="asset_name" value="{{ $asset->name }}" />
				</div>
			</div>

			<!-- Notes -->
			<div class="control-group {{ $errors->has('note') ? 'error' : '' }}">
				<label class="control-label" for="note">Notes</label>
				<div class="controls">
					<input class="span6" type="text" name="note" id="note" value="{{ Input::old('note', $asset->note) }}" />
					{{ $errors->first('note', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>

			<!-- Form actions -->
			<div class="control-group">
				<div class="controls">
					<a class="btn btn-link" href="{{ route('hardware') }}">@lang('general.cancel')</a>
					<button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i>@lang('general.checkin')</button>
				</div>
			</div>

</form>


@stop
