@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	Checkin License
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">

	<div class="pull-right">
		<a href="{{ route('licenses') }}"  class="btn-flat gray"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
	</div>

	<h3>Checkin License</h3>
</div>


<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- Asset Tag -->
			<div class="control-group">
				<label class="control-label" for="asset_tag">Asset Tag</label>
				<div class="controls">
					<input class="span4" readonly="readonly" type="text" name="asset_tag" id="asset_tag" value="{{ $licenseseat->license->asset_tag }}" />
				</div>
			</div>

			<!-- Asset Name -->
			<div class="control-group">
				<label class="control-label" for="name">Asset Name</label>
				<div class="controls">
					<input class="span4" readonly="readonly" type="text" name="name" id="asset_name" value="{{ $licenseseat->license->name }}" />
				</div>
			</div>
			<!-- Serial -->
			<div class="control-group">
				<label class="control-label" for="serial">Serial</label>
				<div class="controls">
					<input class="span4" readonly="readonly" type="text" name="serial" id="serial" value="{{ $licenseseat->license->serial }}" />
				</div>
			</div>

			<!-- Notes -->
			<div class="control-group {{ $errors->has('note') ? 'error' : '' }}">
				<label class="control-label" for="note">Notes</label>
				<div class="controls">
					<input class="span6" type="text" name="note" id="note" value="{{ Input::old('note', $licenseseat->note) }}" />
					{{ $errors->first('note', '<span class="help-inline"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>



			<!-- Form actions -->
			<div class="control-group">
				<div class="controls">
					<a class="btn btn-link" href="{{ route('licenses') }}">@lang('general.cancel')</a>
					<button type="submit" class="btn-flat success">@lang('general.checkin')</button>
				</div>
			</div>
</form>


@stop
