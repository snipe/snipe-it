@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/categories/general.view') {{ $category->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
        <div class="col-md-12">
            {{ HTML::linkAction('update/category', Lang::get('button.update'), array($category->id), array('class' => 'btn btn-warning pull-right')) }}
        
        <h3 class="name">        
        {{{ $category->name }}} </h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

    <div class="col-md-12" style="min-height: 130px;">

      


    </div>

    <!-- Software  table -->

        <h6>Category Assigned to {{{ $category->name }}}: ({{$category->has_models()}})</h6>
		<br> 
		<!-- checked out family table -->
		@if ($category->has_models() > 0)
		<table class="table table-hover">
			<thead>
				<tr>
                                    <th class="col-md-4"><span class="line"></span>@lang('general.name')</th>
                                    <th class="col-md-4"><span class="line"></span>Asset Count</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($category->models as $catmodel)
				<tr>
                                    <td>{{ HTML::linkAction('view/model', $catmodel->name, array($catmodel->id)) }} </td>                                    
                                    <td>{{ $catmodel->has_assets() }}</td>
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

           
        </div>
    </div>
</div>
@stop
