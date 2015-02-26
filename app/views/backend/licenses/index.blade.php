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
<div class="table-responsive">
<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.title')</th>
            <th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.serial')</th>
            <th class="col-sm-1">@lang('admin/licenses/form.seats')</th>
            <th class="col-sm-1">@lang('admin/licenses/form.remaining_seats')</th>
            <th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.purchase_date')</th>
            <th class="col-md-1 actions" tabindex="0" rowspan="1" colspan="1">@lang('table.actions')</th>
        </tr>
    </thead>
    <tbody>


        @foreach ($licenses as $license)

                @if ($license->licenseseats)

                <tr>
                    <td><a href="{{ route('view/license', $license->id) }}">{{{ $license->name }}}</a>
                     </td>
                    <td><a href="{{ route('view/license', $license->id) }}">{{{ mb_strimwidth($license->serial, 0, 50, "...") }}}</a>
                    </td>
                    <td>
                    	{{{ $license->totalSeatsByLicenseID() }}}
                    </td>
                    <td>
                    	{{{ $license->remaincount() }}}
                    </td>
                    <td>
                    {{{ $license->purchase_date }}}
                    </td>
                    <td>
                    <a href="{{ route('update/license', $license->id) }}" class="btn btn-warning"><i class="fa fa-pencil icon-white"></i></a>
                        <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/license', $license->id) }}"
                        data-content="@lang('admin/licenses/message.delete.confirm')"
                        data-title="@lang('general.delete')
                         {{ htmlspecialchars($license->name) }}?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>
                    </td>



                </tr>
                @endif


        @endforeach







    </tbody>
</table>
</div>
@stop
