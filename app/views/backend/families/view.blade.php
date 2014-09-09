@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/families/general.view') {{ $family->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
        <div class="col-md-12">
            {{ HTML::linkAction('update/family', Lang::get('button.update'), array($family->id), array('class' => 'btn btn-warning pull-right')) }}
        
        <h3 class="name">        
        {{{ $family->name }}} </h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

    <div class="col-md-12" style="min-height: 130px;">

      


    </div>

    <!-- Software  table -->

        <h6>Software Assigned to {{{ $family->name }}}</h6>
		<br>
		<!-- checked out family table -->
		@if ($family->has_licenses() > 0)
		<table class="table table-hover">
			<thead>
				<tr>
                                    <th class="col-md-4"><span class="line"></span>@lang('general.name')</th>					
				</tr>
			</thead>
			<tbody>
				@foreach ($family->licenses as $licence)
				<tr>
					<td>{{ HTML::linkAction('view/license', $licence->name, array($licence->id)) }} </td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else

		<div class="col-md-12">
			<div class="alert alert-info alert-block">
				<i class="icon-info-sign"></i>
				@lang('general.no_results')
			</div>
		</div>
		@endif
        </div>

        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
    <br />
    <h6>@lang('admin/families/general.about_families')</h6>
    <p>@lang('admin/families/general.about_families_message') </p>
           
        </div>
    </div>
</div>
@stop
