@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($manufacturer->id)
		@lang('admin/manufacturers/table.update') ::
	@else
		@lang('admin/manufacturers/table.create') ::
	@endif
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
    	<a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('general.back')</a>
		<h3>
		@if ($manufacturer->id)
			@lang('admin/manufacturers/table.update')
		@else
			@lang('admin/manufacturers/table.create')
		@endif
	</h3>
	</div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">




<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- Name -->
			<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
				<label for="name" class="col-md-3 control-label">@lang('admin/manufacturers/table.name')</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $manufacturer->name) }}" />
						{{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>


		<!-- Form actions -->
		<div class="form-group">
		<label class="col-md-2 control-label"></label>
			<div class="col-md-7">
				@if ($manufacturer->id)
				<a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
				@else
				<a class="btn btn-link" href="{{ route('manufacturers') }}">@lang('general.cancel')</a>
				@endif
				<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
			</div>
		</div>

</form>
<br><br><br><br>

</div>

	<!-- side address column -->
   <div class="col-md-3 col-xs-12 address pull-right">
		<br /><br />
		<h6>Have Some Haiku</h6>
		<p>Serious error.<br>
		All shortcuts have disappeared.<br>
		Screen. Mind. Both are blank.</p>


	</div>

</div>

@stop
