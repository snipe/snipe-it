@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($asset->id)
	Checkout Asset to User::
	@else
	Checkout Asset to User ::
	@endif
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
	@if ($asset->id)
	Checkout Asset to User
	@else
	Create Asset
	@endif

		<div class="pull-right">
			<a href="{{ route('assets') }}" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>


<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Tabs Content -->
	<div class="tab-content">

		<div class="tab-pane active" id="tab-general">

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

			<!-- User -->
			<div class="control-group {{ $errors->has('assigned_to') ? 'error' : '' }}">
				<label class="control-label" for="parent">Checkout to</label>
				<div class="controls">

					{{ Form::select('assigned_to', $users_list , Input::old('assigned_to', $asset->assigned_to), array('class'=>'select2', 'style'=>'min-width:350px')) }}
					{{ $errors->first('assigned_to', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

		</div>

	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<a class="btn btn-link" href="{{ route('assets') }}">@lang('general.cancel')</a>
			<button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i>@lang('general.checkout')</button>
		</div>
	</div>
</form>


@stop
