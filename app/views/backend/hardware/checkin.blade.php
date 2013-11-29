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

<div class="row header">
    <div class="col-md-12">
		<a href="{{ route('hardware') }}" class="btn-flat gray pull-right"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		<h3> Checkin Asset </h3>
	</div>
</div>

<div class="row form-wrapper">
<!-- left column -->
<div class="col-md-10 column">

<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- Asset tag -->
			<div class="form-group">
			<label class="col-sm-2 control-label">Asset Tag</label>
				<div class="col-md-6">
				  <p class="form-control-static">{{ $asset->asset_tag }}</p>
				</div>
		  	</div>

			<!-- Asset name -->
		  	<div class="form-group">
			<label class="col-sm-2 control-label">Asset Name</label>
				<div class="col-md-6">
				  <p class="form-control-static">{{ $asset->name }}</p>
				</div>
		  	</div>
			<!-- Note -->
			<div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
				<label for="note" class="col-md-2 control-label">Note</label>
				<div class="col-md-7">
					<input class="col-md-6 form-control" type="text" name="note" id="note" value="{{ Input::old('note', $asset->note) }}" />
					{{ $errors->first('note', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
				</div>
			</div>
			<!-- Form actions -->
				<div class="form-group">
				<label class="col-md-2 control-label"></label>
					<div class="col-md-7">
						@if ($asset->id)
						<a class="btn btn-link" href="{{ route('view/hardware', $asset->id) }}">@lang('general.cancel')</a>
						@else
						<a class="btn btn-link" href="{{ route('hardware') }}">Cancel</a>
						@endif
						<button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i>@lang('general.checkin')</button>
					</div>
				</div>

</form>
</div>
</div>

@stop
