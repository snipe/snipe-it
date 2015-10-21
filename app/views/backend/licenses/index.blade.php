@extends('backend/layouts/default')

{{-- Page title --}}
@lang('admin/licenses/general.software_licenses') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/licenses') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> Create New</a>
        <h3>@lang('admin/licenses/general.software_licenses')</h3>
    </div>
</div>

<div class="row form-wrapper">
    {{ Datatable::table()
                ->addColumn(Lang::get('admin/licenses/table.title'),
                            Lang::get('admin/licenses/table.serial'),
                            Lang::get('admin/licenses/form.to_name'),
                            Lang::get('admin/licenses/form.to_email'),
                            Lang::get('admin/licenses/form.seats'),
                            Lang::get('admin/licenses/form.remaining_seats'),
                            Lang::get('admin/licenses/table.purchase_date'),
                            Lang::get('admin/licenses/form.notes'),
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
                            'sAjaxSource'=>route('api.licenses.list'),
                            'dom' =>'CT<"clear">lfrtip',
                            'colVis'=> array('showAll'=>'Show All','restore'=>'Restore','exclude'=>array(8),'activate'=>'mouseover'),
                            'columnDefs'=> array(
                                array('bSortable'=>false,'targets'=>array(8)),
                                array('width'=>'20%','targets'=>array(8)),
                                ),
                            'order'=>array(array(0,'asc')),
                        )
                    )
                ->render() }}
</div>
@stop
