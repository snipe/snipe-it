@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/users/table.viewusers') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        @if (Config::get('ldap.url')!='')
            <a href="{{ route('ldap/user') }}" class="btn btn-default pull-right"><span class="fa fa-upload"></span> LDAP</a>
        @endif
	<a href="{{ route('import/user') }}" class="btn btn-default pull-right" style="margin-right: 5px;"><span class="fa fa-upload"></span> @lang('general.import')</a>
        <a href="{{ route('create/user') }}" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-plus icon-white"></i>  @lang('general.create')</a>
         @if (Input::get('status')=='deleted')
            <a class="btn btn-default pull-right" href="{{ URL::to('admin/users') }}" style="margin-right: 5px;">@lang('admin/users/table.show_current')</a>
        @else
            <a class="btn btn-default pull-right" href="{{ URL::to('admin/users?status=deleted') }}" style="margin-right: 5px;">@lang('admin/users/table.show_deleted')</a>
        @endif

        <h3>
        @if (Input::get('status')=='deleted')
            @lang('general.deleted')
        @else
            @lang('general.current')
        @endif
         @lang('general.users')
    </h3>
    </div>
</div>

<div class="row">
{{ Form::open([
     'method' => 'POST',
     'route' => ['users/bulkedit'],
	  'class' => 'form-horizontal' ]) }}


    {{ Datatable::table()
        ->addColumn('<div class="text-center"><input type="checkbox" id="checkAll" style="padding-left: 0px;"></div>',
    	    Lang::get('admin/users/table.name'),
    	    '<i class="fa fa-envelope fa-lg"></i>',
    	    Lang::get('admin/users/table.manager'),
            Lang::get('admin/users/table.location'),
            '<i class="fa fa-barcode fa-lg"></i>',
            '<i class="fa fa-certificate fa-lg"></i>',
            '<i class="fa fa-keyboard-o fa-lg"></i>',
            '<i class="fa fa-tint fa-lg"></i>',
    	    Lang::get('general.groups'),
    	    Lang::get('table.actions'))
        ->setOptions(
        array(
            'language' => array(
                'search' => Lang::get('general.search'),
                'lengthMenu' => Lang::get('general.page_menu'),
                'loadingRecords' => Lang::get('general.loading'),
                'zeroRecords' => Lang::get('general.no_results'),
                'info' => Lang::get('general.pagination_info'),
                'processing' => '<i class="fa fa-spinner fa-spin"></i> '.Lang::get('general.processing'),
                'paginate'=> array(
                    'first'=>Lang::get('general.first'),
                    'previous'=>Lang::get('general.previous'),
                    'next'=>Lang::get('general.next'),
                    'last'=>Lang::get('general.last'),
                    ),
                ),
            'sAjaxSource'=> route('api.users.list', Input::get('status')),
            'dom' =>'CT<"clear">lfrtip',
            'colVis'=>
                array(
                    'showAll'=>'Show All',
                    'restore'=>'Restore',
                    'exclude'=>array(0,10),
                    'activate'=>'mouseover'
                ),
            'columnDefs'=>
                array(
                    array(
                        'visible'=>false,
                        'targets'=>array()
                    ),
                    array(
                    'orderable'=>false,
                    'targets'=>array(0,10)
                    )
                ),
            'order'=>array(array(1,'asc')),
            )
        )
    ->render('backend/users/datatable') }}

 {{ Form::close() }}
</div>
</div>

<script>

	$(function() {

		function checkForChecked() {

	        var check_checked = $('input.one_required:checked').length;

	        if (check_checked > 0) {
	            $('#bulkEdit').removeAttr('disabled');
	        }
	        else {
	            $('#bulkEdit').attr('disabled', 'disabled');
	        }
	    }

	    $('table').on('change','input.one_required',checkForChecked);

	    $("#checkAll").change(function () {
			$("input:checkbox").prop('checked', $(this).prop("checked"));
			checkForChecked();
		});

	});


</script>

@stop
