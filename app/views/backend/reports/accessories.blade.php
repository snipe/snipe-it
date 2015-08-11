@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('general.accessory_report') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="page-header">

    <div class="pull-right">
        <a href="{{ route('reports/export/accessories') }}" class="btn btn-flat gray pull-right"><i class="fa fa-download icon-white"></i>
        @lang('admin/accessories/table.dl_csv')</a>
        </div>

    <h3>@lang('general.accessory_report')</h3>
</div>

<div class="row">

<div class="table-responsive">
<table id="example">
        <thead>
            <tr role="row">
            <th class="col-sm-1">@lang('admin/accessories/table.title')</th>
            <th class="col-sm-1">@lang('admin/accessories/general.total')</th>
            <th class="col-sm-1">@lang('admin/accessories/general.remaining')</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($accessories as $accessory)
        <tr>
            <td>{{ $accessory->name }}</td>
            <td>{{ $accessory->qty }}</td>
            <td>{{ $accessory->numRemaining() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@stop
