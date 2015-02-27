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
        <a href="{{ route('create/hardware') }}" class="btn btn-success pull-right"><i class="fa fa-plus-sign icon-white"></i> @lang('general.create')</a>
        <h3>@yield('title0')</h3>
    </div>
</div>

<div class="row form-wrapper">

<?php $spanrows = 8; ?>


@if ($assets->count() > 0)


 {{ Form::open([
      'method' => 'POST',
      'route' => ['hardware/bulkedit'],
	  'class' => 'form-horizontal' ]) }}



<div class="table-responsive">
<table id="example">

    <thead>
        <tr role="row">
	        <th class="col-md-1" bSortable="false"></th>
            <th class="col-md-1" bSortable="true">@lang('admin/hardware/table.asset_tag')</th>
            <th class="col-md-3" bSortable="true">@lang('admin/hardware/table.asset_model')</th>
            @if (Setting::getSettings()->display_asset_name)
            <th class="col-md-3" bSortable="true">@lang('general.name')</th>
            <?php $spanrows++; ?>
            @endif
            <th class="col-md-2" bSortable="true">@lang('admin/hardware/table.serial')</th>
            <th class="col-md-2" bSortable="true">@lang('general.status')</th>
            <th class="col-md-2" bSortable="true">@lang('admin/hardware/table.location')</th>
            @if (Input::get('Deployed') && Setting::getSettings()->display_checkout_date)
            <th class="col-md-2" bSortable="true">@lang('admin/hardware/table.checkout_date')</th>
            <?php $spanrows++; ?>
            @endif
            @if (Setting::getSettings()->display_eol)
           	<th class="col-md-2">@lang('admin/hardware/table.eol')</th>
           	<?php $spanrows++; ?>
            @endif
            <th class="col-md-1">@lang('admin/hardware/table.change')</th>
            <th class="col-md-2 actions" bSortable="false">@lang('table.actions')</th>
        </tr>
    </thead>
    <tfoot>
    <tr>
      <td colspan="{{{ $spanrows }}}"><button class="btn btn-default" id="bulkEdit" disabled>Bulk Edit</button></td>
    </tr>
  </tfoot>
    <tbody>

        @foreach ($assets as $asset)
        <tr>
	        <td><input type="checkbox" name="edit_asset[{{ $asset->id }}]" class="one_required"></td>
            <td><a href="{{ route('view/hardware', $asset->id) }}">{{{ $asset->asset_tag }}}</a></td>
            <td><a href="{{ route('view/model', $asset->model->id) }}">{{{ $asset->model->name }}}</a></td>

            @if (Setting::getSettings()->display_asset_name)
                <td><a href="{{ route('view/hardware', $asset->id) }}">{{{ $asset->name }}}</a></td>
            @endif

            <td>{{{ $asset->serial }}}</td>


                <td>
                    @if (Input::get('Pending'))
                        @lang('general.pending')
                    @elseif (Input::get('RTD'))
                        @lang('general.ready_to_deploy')
                    @elseif (Input::get('Undeployable'))
                        @if ($asset->assetstatus)
                        	{{{ $asset->assetstatus->name }}}
                        @endif
                    @else
                    	@if ($asset->assigneduser)
							<a href="{{ route('view/user', $asset->assigned_to) }}">
							{{{ $asset->assigneduser->fullName() }}}
							</a>
						@else
							@if ($asset->assetstatus)
                        	{{{ $asset->assetstatus->name }}}
                        	@endif
						@endif
                    @endif
                </td>



            <td>
                @if ($asset->assigneduser && $asset->assetloc)
                    	<a href="{{ route('update/location', $asset->assetloc->id) }}">{{{ $asset->assetloc->name }}}</a>
                @elseif ($asset->defaultLoc)
                    	<a href="{{ route('update/location', $asset->defaultLoc->id) }}">{{{ $asset->defaultLoc->name }}}</a>

                @endif

            </td>
			@if (Input::get('Deployed') && Setting::getSettings()->display_checkout_date)
	            <td>
	                @if (count($asset->assetlog) > 0)
                        {{{ $asset->assetlog->first()->created_at }}}
	                @endif
	            </td>
            @endif
            @if (Setting::getSettings()->display_eol)
				<td>
				@if ($asset->model->eol)
					{{{ $asset->eol_date() }}}
				@endif
           		</td>
            @endif

            <td>

            @if (($asset->assetstatus) && (($asset->assetstatus->deployable == 1 ) && ($asset->deleted_at=='')))
				@if (($asset->assigned_to !='') && ($asset->assigned_to > 0))
					<a href="{{ route('checkin/hardware', $asset->id) }}" class="btn btn-primary">@lang('general.checkin')</a>
				@else
					<a href="{{ route('checkout/hardware', $asset->id) }}" class="btn btn-info">@lang('general.checkout')</a>
				@endif
            @endif

            </td>
            <td nowrap="nowrap">

            @if ($asset->deleted_at=='')
             	<a href="{{ route('update/hardware', $asset->id) }}" class="btn btn-warning"><i class="fa fa-pencil icon-white"></i></a>
            	 <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/hardware', $asset->id) }}" data-content="@lang('admin/hardware/message.delete.confirm')"
                data-title="@lang('general.delete')
                 {{ htmlspecialchars($asset->asset_tag) }}?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>
        	@else
                @if ($asset->model->deleted_at=='')
        		 <a href="{{ route('restore/hardware', $asset->id) }}" class="btn btn-warning"><i class="fa fa-recycle icon-white"></i></a>
                @endif
        	@endif

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
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
@else
<div class="col-md-9">
    <div class="alert alert-info alert-block">
        <i class="fa fa-info-circle"></i>
        @lang('general.no_results')
    </div>
</div>

</div>

@endif


@stop
