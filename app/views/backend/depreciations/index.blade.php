@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.depreciations') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/depreciations') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>@lang('actions.create')</a>
        <h3>
            @lang('base.depreciations')
        </h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

                    <table id="example">
                        <thead>
                            <tr role="row">
                                <th class="col-md-4">@lang('general.name')</th>
                                <th class="col-md-2">@lang('base.depreciation_shortname')</th>
                                <th class="col-md-2 actions">@lang('actions.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($depreciations as $depreciation)
                            <tr>
                                <td>{{ $depreciation->name }}</td>
                                <td>{{ $depreciation->months }} @lang('general.months') </td>
                                <td>
                                <a href="{{ route('update/depreciations', $depreciation->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/depreciations', $depreciation->id) }}" data-content="@lang('admin/depreciations/message.delete.confirm')"
data-title="@lang('actions.delete')
 {{{ htmlspecialchars($depreciation->name) }}}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>


                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                        </div>

                    <!-- side address column -->
                    <div class="col-md-3 col-xs-12 address pull-right">
                        <br />
                        <h6>@lang('base.depreciation_about')</h6>
                        <p>@lang('admin/depreciations/message.about') </p>
                    </div>
 </div>
  </div>
@stop
