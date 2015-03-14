@extends('backend/layouts/default')

@section('title0')
			
    @if (Input::get('status'))
        @if (Input::get('status')=='Pending')
            @lang('general.pending')
        @elseif (Input::get('status')=='RTD')
            @lang('general.ready_to_deploy')
        @elseif (Input::get('status')=='Undeployable')
            @lang('general.undeployable')
        @elseif (Input::get('status')=='Deployable')
            @lang('general.deployed')
         @elseif (Input::get('status')=='Requestable')
            @lang('admin/hardware/general.requestable')
        @elseif (Input::get('status')=='Archived')
            @lang('general.archived')
         @elseif (Input::get('status')=='Deleted')
            @lang('general.deleted')
        @endif
    @else
            @lang('general.all')
    @endif

    @lang('general.assets')
@stop

{{-- Page title --}}
@section('title')
    @yield('title0') :: @parent
@stop

{{-- Page content --}}
@section('content')

<style>
.dataTables_filter {padding-right: 20px;}

</style>

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/hardware') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> @lang('general.create')</a>
        <h3>@yield('title0')</h3>
    </div>
</div>

<div class="row form-wrapper">



 {{ Form::open([
      'method' => 'POST',
      'route' => ['hardware/bulkedit'],
	  'class' => 'form-horizontal' ]) }}



{{ Datatable::table()
    ->addColumn(Lang::get('admin/hardware/form.name'), 
    	Lang::get('admin/hardware/table.asset_tag'), 
    	Lang::get('admin/hardware/table.serial'), 
    	Lang::get('admin/hardware/table.status'),
    	Lang::get('admin/hardware/form.model'),
    	Lang::get('admin/hardware/table.eol'),
    	Lang::get('admin/hardware/table.checkout_date'), 
    	Lang::get('admin/hardware/table.change'), 
    	Lang::get('table.actions'))
    ->setUrl(route('api.hardware', Input::get('status')))   // this is the route where data will be retrieved
    ->setOptions(
            array(
                'dom' =>'CT<"clear">lfrtip',
                'stateSave' => true,
                'deferRender' => true,
                'tableTools' => array('sSwfPath'=> asset('assets/swf/copy_csv_xls_pdf.swf') ),
            )
        )
    ->render() }}

 {{ Form::close() }}

</div>
<script>
	


	$(function() {

	    $('input.one_required').change(function() {

	        var check_checked = $('input.one_required:checked').length;
	        console.warn(check_checked);
	        if (check_checked > 0) {
	            $('#bulkEdit').removeAttr('disabled');
	        }
	        else {
	            $('#bulkEdit').attr('disabled', 'disabled');
	        }
	    });
	});
</script>



@stop
