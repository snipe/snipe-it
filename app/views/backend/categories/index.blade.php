@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/categories/general.asset_categories') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/category') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> @lang('general.create')</a>
        <h3>@lang('admin/categories/general.asset_categories')</h3>
    </div>
</div>

<div class="user-profile">
	<div class="row profile">
		<div class="col-md-9 bio">
			{{ Datatable::table()
                		->addColumn(Lang::get('admin/categories/table.title'),
                    			Lang::get('general.type'),
                    			Lang::get('general.assets'),
                    			Lang::get('admin/categories/table.require_acceptance'),
                    			Lang::get('admin/categories/table.eula_text'),
                    			Lang::get('table.actions'))
        			->setOptions(
	                        	array(
		                        	'language' => array(
					            	'search' => Lang::get('general.search'),
					            	'lengthMenu' => Lang::get('general.page_menu'),
					            	'loadingRecords' => Lang::get('general.loading'),
					            	'zeroRecords' => Lang::get('general.no_results'),
					            	'info' => Lang::get('general.pagination_info'), 
					            	'processing' => Lang::get('general.processing'),
					            	'paginate'=> array(
					            		'first'=>Lang::get('general.first'),
					            		'previous'=>Lang::get('general.previous'),
					            		'next'=>Lang::get('general.next'),
					            		'last'=>Lang::get('general.last'),
					            		),
					            	),
	                            		'sAjaxSource'=> route('api.categories.list'),
	                            		'dom' =>'CT<"clear">lfrtip',
	                            		'colVis'=> array('showAll'=>'Show All','restore'=>'Restore','exclude'=>array(5),'activate'=>'mouseover'),
	                            		'columnDefs'=> array(array('bSortable'=>false,'targets'=>array(5))),
	                            		'order'=>array(array(0,'asc')),
                        			)
                    			)
                		->render() }}
    		</div>


		<!-- side address column -->
		<div class="col-md-3 col-xs-12 address pull-right">
    			<br /><br />
    			<h6>@lang('admin/categories/general.about_asset_categories')</h6>
    			<p>@lang('admin/categories/general.about_categories') </p>
		</div>
	</div>
</div>
@stop
