@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('general.accessories') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/accessory') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> @lang('general.create')</a>
        <h3>@lang('general.accessories')</h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">
            {{ Datatable::table()
                ->addColumn(Lang::get('admin/accessories/table.title'), 
                            Lang::get('admin/accessories/general.total'), 
                            Lang::get('admin/accessories/general.remaining'), 
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
                            'sAjaxSource'=>route('api.accessories.list'),
                            'dom' =>'T<"clear">lfrtip',
                            'tableTools' => array(
                                'sSwfPath'=> Config::get('app.url').'/assets/swf/copy_csv_xls_pdf.swf',
                                'aButtons'=>array(
                                    array(
                                    	'sExtends'=>'copy',
                                    	'sButtonText'=>'Copy',
                                    	'mColumns'=>array(0,1,2),
                                    	'bFooter'=>false,
                                	),
                                    array(
                                    	'sExtends'=>'print',
                                    	'sButtonText'=>'Print',
                                    	'mColumns'=>array(0,1,2),
                                    	'bShowAll'=>true,
                                    	'bFooter'=>true,
                                	),
                                    array(
                                        'sExtends'=>'collection',
                                        'sButtonText'=>'Export',
                                        'aButtons'=>array(
                                            array(
                                            	'sExtends'=>'csv',
                                            	'sButtonText'=>'csv',
                                            	'mColumns'=>array(0,1,2),
                                            	'bFooter'=>false,
                                        	),
                                            array(
                                            	'sExtends'=>'xls',
                                            	'sButtonText'=>'XLS',
                                            	'mColumns'=>array(0,1,2),
                                            	'bFooter'=>false,
                                        	),
                                            array(
                                            	'sExtends'=>'pdf',
                                            	'sButtonText'=>'PDF',
                                            	'mColumns'=>array(0,1,2),
                                            	'bFooter'=>false,
                                        	)
                                        )
                                    ),
                                ) 
                            ),
                            'columnDefs'=> array(
                                array('bSortable'=>false,'targets'=>array(3)),
                                ),
                            'order'=>array(array(0,'asc')),
                        )
                    )
                ->render() }}
        </div>


        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
            <br /><br />
            <h6>@lang('admin/accessories/general.about_accessories_title')</h6>
            <p>@lang('admin/accessories/general.about_accessories_text') </p>

        </div>
    </div>
</div>
@stop
