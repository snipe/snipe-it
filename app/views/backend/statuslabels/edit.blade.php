@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($statuslabel->id)
		Update Status Label ::
	@else
		Create New Status Label ::
	@endif
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('statuslabels') }}" class="btn-flat gray pull-right right"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		<h3>Status Labels</h3>
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
						<a class="btn btn-link" href="{{ route('statuslabels') }}">Cancel</a>
						<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
					</div>
				</div>
		</form>
		<br><br><br><br>


</div>

                    <!-- side address column -->
                    <div class="col-md-3 address pull-right">
					<br /><br />
						<h6>About Status Labels</h6>
						<p>Status labels are used to describe the various reasons why an asset <strong><em>cannot</em></strong> be deployed. </p>

						<p>It could be broken, out for diagnostics, out for
						repair, lost or stolen, etc. Status labels allow your team to show the progression.</p>

                    </div>


@stop