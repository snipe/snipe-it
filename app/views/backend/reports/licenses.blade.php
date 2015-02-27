@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('general.license_report') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="page-header">

    <div class="pull-right">
        <a href="{{ route('reports/export/licenses') }}" class="btn btn-flat gray pull-right"><i class="fa fa-download icon-white"></i>
        @lang('admin/hardware/table.dl_csv')</a>
        </div>

    <h3>@lang('general.license_report')</h3>
</div>

<div class="row">

<div class="table-responsive">
<table id="example">
        <thead>
            <tr role="row">
            <th class="col-sm-1">@lang('admin/licenses/table.title')</th>
            <th class="col-sm-1">@lang('admin/licenses/table.serial')</th>
            <th class="col-sm-1">@lang('admin/licenses/form.seats')</th>
            <th class="col-sm-1">@lang('admin/licenses/form.remaining_seats')</th>
            <th class="col-sm-1">@lang('admin/licenses/form.expiration')</th>
            <th class="col-sm-1">@lang('admin/licenses/form.date')</th>
            <th class="col-sm-1">@lang('admin/licenses/form.cost')</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($licenses as $license)
        <tr>
            <td>{{{ $license->name }}}</td>
            <td>{{{ mb_strimwidth($license->serial, 0, 50, "...") }}}</td>
            <td>{{ $license->seats }}</td>
            <td>{{ $license->remaincount() }}</td>
            <td>{{ $license->expiration_date }}</td>
            <td>{{ $license->purchase_date }}</td>
            <td>@lang('general.currency')
            {{{ number_format($license->purchase_cost) }}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@stop
