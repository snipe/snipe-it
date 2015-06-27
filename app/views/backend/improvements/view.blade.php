<?php
    use Carbon\Carbon;
?>
@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('admin/improvements/general.view') {{ $improvement->title }} ::
    @parent
@stop

{{-- Page content --}}
@section('content')
    <div class="row header">
        <div class="col-md-12">
            <h3 class="title">
                @lang('admin/improvements/general.view')
                {{{ " - " . $improvement->title }}}
            </h3>

            <div class="btn-group pull-right">

                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">@lang('button.actions')
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a href="{{ route('update/improvement', $improvement->id) }}">@lang('admin/improvements/general.edit')</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="user-profile ">
        <div class="row profile">
            <div class="col-md-9 bio">
                <!-- 1st Row Begin -->
                <div class="row">
                    <div class="col-md-12 col-sm-12" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
                        <strong>@lang('admin/improvements/form.improvement_type'): </strong>
                        {{{ $improvement->improvement_type }}}
                    </div>
                </div>
                <!-- 1st Row End -->
                <!-- 2nd Row Begin -->
                <div class="row">
                    <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
                        <strong>@lang('admin/improvements/table.asset_name'): </strong>
                        <a href="{{ route('view/hardware', $improvement->asset_id) }}">
                            {{{ $improvement->asset->name }}}
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
                        <strong>@lang('admin/improvements/table.supplier_name'): </strong>
                        <a href="{{ route('view/supplier', $improvement->supplier_id) }}">
                            {{{ $improvement->supplier->name }}}
                        </a>
                    </div>
                </div>
                <!-- 2nd Row End -->
                <!-- 3rd Row Begin -->
                <div class="row">
                    <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
                        <strong>@lang('admin/improvements/form.start_date'): </strong>
                        <?php $startDate = Carbon::parse($improvement->start_date); ?>
                        {{{ $startDate->toDateString() }}}
                    </div>
                    <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
                        <strong>@lang('admin/improvements/form.completion_date'): </strong>
                        <?php if (is_null($improvement->completion_date)) {
                            $calculationEndDate = Carbon::now();
                            $completionDate = NULL;
                        } else {
                            $completionDate = Carbon::parse($improvement->start_date);
                            $calculationEndDate = $completionDate;
                        }
                        ?>
                        {{{ $completionDate ? $completionDate->toDateString() : Lang::get('admin/improvements/message.improvement_incomplete') }}}
                    </div>
                    <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
                        <strong>@lang('admin/improvements/form.improvement_time'): </strong>
                        {{ $calculationEndDate->diffInDays($startDate) }}
                    </div>
                </div>
                <!-- 3rd Row End -->
                <!-- 4th Row Begin -->
                <div class="row">
                    <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
                        <strong>@lang('admin/improvements/form.cost'): </strong>
                        {{{ sprintf( Lang::get( 'general.currency' ) . '%01.2f', $improvement->cost) }}}
                    </div>
                    <div class="col-md-3 col-sm-3" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
                        <strong>@lang('admin/improvements/form.is_warranty'): </strong>
                        {{{ $improvement->is_warranty ? Lang::get('admin/improvements/message.warranty') : Lang::get('admin/improvements/message.not_warranty') }}}
                    </div>
                </div>
                <!-- 4th Row End -->
                <!-- 5th Row Begin -->
                <div class="row">
                    <div class="col-md-12 col-sm-12" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
                        <strong>@lang('admin/improvements/form.notes'): </strong>
                        {{{ $improvement->notes }}}
                    </div>
                </div>
                <!-- 5th Row End -->
            </div> <!-- col-md-9 bio end -->
        </div> <!-- row profile end -->
    </div> <!-- user-profile end -->
@stop