@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
        	@lang('admin/hardware/form.bulk_delete') ::

@parent
@stop

{{-- Page content --}}

@section('content')

<div class="row header">
    <div class="col-md-12">
            <a href="{{ URL::previous() }}" class="btn-flat gray pull-right right"><i class="fa fa-arrow-left icon-white"></i> @lang('general.back')</a>
        <h3>

        	@lang('admin/hardware/form.bulk_delete')
        </h3>
    </div>
</div>

<div class="row form-wrapper">

      <div class="col-md-12 column">
        <p>@lang('admin/hardware/form.bulk_delete_help')</p>
        <p style="color: red"><strong><big>@lang('admin/hardware/form.bulk_delete_warn', ['asset_count' => count($assets)])</big></strong></p>


  			 <form class="form-horizontal" method="post" action="{{ route('hardware/bulkdelete') }}" autocomplete="off" role="form">
           <input type="hidden" name="_token" value="{{ csrf_token() }}" />
           <table class="table table-striped table-condensed">
            <thead>
              <tr>
                <td></td>
                <td>ID</td>
                <td>Name</td>
                <td>Location</td>
                <td>Assigned To</td>
              </tr>
            </thead>
            <tbody>
            @foreach ($assets as $asset)
            	<tr>
                <td><input type="checkbox" name="bulk_edit[]" value="{{{ $asset->id }}}" checked="checked"></td>
                <td>{{{ $asset->id }}}</td>
                <td>{{{ $asset->showAssetName() }}}</td>
                <td>
                  @if ($asset->assetloc)
                    {{{ $asset->assetloc->name }}}
                  @endif
                </td>
                <td>
                  @if ($asset->assigneduser)
                    {{{ $asset->assigneduser->fullName() }}} ({{{ $asset->assigneduser->username }}})
                  @endif
                </td>
              </tr>
            @endforeach

            </tbody>

          </table>

          <button class="btn btn-sm btn-default">Delete</button>

        </form>
    </div>
</div>
@stop
