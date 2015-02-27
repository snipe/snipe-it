@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

 {{{ $manufacturer->name }}}
 @lang('general.manufacturer') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <div class="btn-group pull-right">
           <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">@lang('button.actions')
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                    <li><a href="{{ route('update/model', $manufacturer->id) }}">@lang('admin/categories/table.edit')</a></li>
                    <li><a href="{{ route('clone/model', $manufacturer->id) }}">@lang('admin/categories/table.clone')</a></li>
                    <li><a href="{{ route('create/hardware', $manufacturer->id) }}">@lang('admin/hardware/form.create')</a></li>
            </ul>
        </div>
        <h3>
            {{{ $manufacturer->name }}}
 @lang('general.manufacturer')

        </h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-12 bio">


                            <!-- checked out categories table -->
                            @if (count($manufacturer->assets) > 0)
                           <table id="example">
                            <thead>
                                <tr role="row">
                                        <th class="col-md-3">@lang('general.name')</th>
                                        <th class="col-md-3">@lang('general.asset_tag')</th>
                                        <th class="col-md-3">@lang('general.user')</th>
                                        <th class="col-md-2">@lang('table.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($manufacturer->assets as $modelassets)
                                    <tr>
                                        <td><a href="{{ route('view/hardware', $modelassets->id) }}">{{{ $modelassets->name }}}</a></td>
                                        <td><a href="{{ route('view/hardware', $modelassets->id) }}">{{{ $modelassets->asset_tag }}}</a></td>
                                        <td>
                                        @if ($modelassets->assigneduser)
                                        <a href="{{ route('view/user', $modelassets->assigned_to) }}">
                                        {{{ $modelassets->assigneduser->fullName() }}}
                                        </a>
                                        @endif
                                        </td>
                                        <td>
                                        @if ($modelassets->assigned_to != 0)
                                            <a href="{{ route('checkin/hardware', $modelassets->id) }}" class="btn-flat info">Checkin</a>
                                        @else
                                            <a href="{{ route('checkout/hardware', $modelassets->id) }}" class="btn-flat success">Checkout</a>
                                        @endif
                                        </td>

                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>

                            @else
                            <div class="col-md-9">
                                <div class="alert alert-info alert-block">
                                    <i class="fa fa-info-circle"></i>
                                    @lang('general.no_results')
                                </div>
                            </div>
                            @endif

                        </div>



@stop
