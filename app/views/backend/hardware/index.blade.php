@extends('backend/layouts/default')

@section('title0')
    @if (Input::get('Pending') || Input::get('Undeployable') || Input::get('Deleted') || Input::get('Requestable') || Input::get('RTD')  || Input::get('Deployed') || Input::get('Archived'))
        @if (Input::get('Pending'))
            @lang('general.pending')
        @elseif (Input::get('RTD'))
            @lang('general.ready_to_deploy')
        @elseif (Input::get('Undeployable'))
            @lang('general.undeployable')
        @elseif (Input::get('Deployed'))
            @lang('general.deployed')
         @elseif (Input::get('Requestable'))
            @lang('admin/hardware/general.requestable')
        @elseif (Input::get('Archived'))
            @lang('general.archived')
         @elseif (Input::get('Deleted'))
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
    ->addColumn('name', 'asset_tag', 'serial', 'assigned_to')       // these are the column headings to be shown
    ->setUrl(route('api.hardware'))   // this is the route where data will be retrieved
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
