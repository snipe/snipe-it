@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.family') {{ $family->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
        <div class="col-md-12">
            {{ HTML::linkAction('update/family', Lang::get('actions.update'), array($family->id), array('class' => 'btn btn-warning pull-right')) }}
        
        <h3 class="name">        
        {{{ $family->name }}} </h3>
    </div>
</div>

<div class="row form-wrapper">
    <div class="col-md-9">


    <!-- Software  table -->

        <h6>[ {{{Lang::get('base.family_use')}}} : {{$family->has_licenses()}} ]</h6>
		<br>
		<!-- checked out family table -->
		@if ($family->has_licenses() > 0)
		<table id="example">
                    <thead>
                        <tr role="row">
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
		<div class="col-md-10">
			<div class="alert alert-info alert-block">
				<i class="icon-info-sign"></i>
				@lang('general.no_results')
			</div>
		</div>
		@endif
                
        </div>

        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
            <h4>@lang('base.family_about')</h4>
            <br>
            <p>@lang('admin/families/message.about') </p>
        </div>

</div>

@stop
