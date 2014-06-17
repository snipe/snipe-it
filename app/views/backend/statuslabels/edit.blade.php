@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($statuslabel->id)
		@lang('admin/statuslabels/table.update') ::
	@else
		@lang('admin/statuslabels/table.create') ::
	@endif
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
    	<a href="{{ URL::previous() }}" class="btn-flat gray pull-right right">
    	<i class="icon-circle-arrow-left icon-white"></i>  @lang('general.back')</a>
		<h3>
		@if ($statuslabel->id)
			@lang('admin/statuslabels/table.update')
		@else
			@lang('admin/statuslabels/table.create')
		@endif
		</h3>
	</div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

		<!-- checked out assets table -->

		<form class="form-horizontal" method="post" action="" autocomplete="off">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />



			<!-- Asset Title -->
			<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
				<label for="name" class="col-md-3 control-label">Status Label Name</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $statuslabel->name) }}" />
						{{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>

			<!-- Form actions -->
				<div class="form-group">
				<label class="col-md-2 control-label"></label>
					<div class="col-md-7">
						<a class="btn btn-link" href="{{ URL::previous() }}">Cancel</a>
						<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
					</div>
				</div>
		</form>
		<br><br><br><br>


</div>

			<!-- side address column -->
			<div class="col-md-3 address pull-right">
			<br /><br />
				<h6>@lang('admin/statuslabels/table.about')</h6>
				<p>@lang('admin/statuslabels/table.info')</p>

			</div>


@stop