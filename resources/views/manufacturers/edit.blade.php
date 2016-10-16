@extends('layouts/default')

{{-- Page title --}}
@section('title')
	@if ($item->id)
		{{ trans('admin/manufacturers/table.update') }}
	@else
		{{ trans('admin/manufacturers/table.create') }}
	@endif
	@parent
@stop

@section('header_right')
	<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
		{{ trans('general.back') }}
	</a>
@stop


{{-- Page content --}}
@section('content')

<div class="row">
	<div class="col-md-9">
		<form class="form form-horizontal" method="post" action="" autocomplete="off">
			{{ csrf_field() }}
			<!-- Horizontal Form -->
			<div class="box box-default">
				<div class="box-body">
					@include ('partials.forms.edit.name', ['translated_name' => trans('admin/manufacturers/table.name')])
				</div>
				@include ('partials.forms.edit.submit')
			</div>
		</form>
	</div>

	<!-- side address column -->
	<div class="col-md-3">
		<h4>Have Some Haiku</h4>
		<p>Serious error.<br>
			All shortcuts have disappeared.<br>
			Screen. Mind. Both are blank.
		</p>
	</div>

</div>

@stop
