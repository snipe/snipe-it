<?php
        use Carbon\Carbon;
?>
@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('general.improvement_report') ::
    @parent
@stop

{{-- Page content --}}
@section('content')
    <div class="page-header">

        <div class="pull-right">
            <a href="{{ route('reports/export/improvements') }}" class="btn btn-flat gray pull-right"><i class="fa fa-download icon-white"></i>
                @lang('admin/improvements/table.dl_csv')</a>
        </div>
        <h3>@lang('general.improvement_report')</h3>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table id="example">
                <thead>
                    <tr role="row">
                        <th class="col-sm-1">@lang('admin/improvements/table.asset_name')</th>
                        <th class="col-sm-1">@lang('admin/improvements/table.supplier_name')</th>
                        <th class="col-sm-1">@lang('admin/improvements/form.improvement_type')</th>
                        <th class="col-sm-1">@lang('admin/improvements/form.title')</th>
                        <th class="col-sm-1">@lang('admin/improvements/form.start_date')</th>
                        <th class="col-sm-1">@lang('admin/improvements/form.completion_date')</th>
                        <th class="col-sm-1">@lang('admin/improvements/form.improvement_time')</th>
                        <th class="col-sm-1">@lang('admin/improvements/form.cost')</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $totalDays = 0;
                    $totalCost = 0;
                ?>
                @foreach ($improvements as $improvement)
                    <tr>
                        <td>{{{ $improvement->asset->name }}}</td>
                        <td>{{{ $improvement->supplier->name }}}</td>
                        <td>{{{ $improvement->improvement_type }}}</td>
                        <td>{{{ $improvement->title }}}</td>
                        <td>{{{ $improvement->start_date }}}</td>
                        <td>{{{ $improvement->completion_date }}}</td>
                        @if (is_null($improvement->improvement_time))
                            <?php
                                $improvementTime = intval(Carbon::now()->diffInDays(Carbon::parse($improvement->start_date)));
                            ?>
                        @else
                            <?php
                                $improvementTime = intval($improvement->improvement_time);
                            ?>
                        @endif
                        <td>{{{ $improvementTime }}}</td>
                        <td>@lang('general.currency'){{ number_format($improvement->cost,2) }}</td>
                    </tr>
                    <?php
                        $totalDays += $improvementTime;
                        $totalCost += floatval($improvement->cost);
                    ?>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" align="right"><strong>Totals:</strong></td>
                        <td>{{number_format($totalDays)}}</td>
                        <td>@lang('general.currency'){{ number_format($totalCost,2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@stop