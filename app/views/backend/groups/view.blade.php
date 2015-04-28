@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/groups/table.view') -
{{{ $group->name }}} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('update/group', $group->id) }}" class="btn-flat white pull-right">
        @lang('admin/groups/table.update')</a>
        <a href="{{ URL::to('admin/groups') }}" class="btn-flat gray pull-right" style="margin-right:5px;"><i class="fa fa-arrow-left icon-white"></i> @lang('general.back')</a>
        <h3 class="name"> @lang('admin/groups/titles.group_management') - {{{ $group->name }}}</h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-12 bio">
            @if (count($users) > 0)
           <table id="example">
            <thead>
                <tr role="row">
                        <th class="col-md-3">@lang('admin/groups/table.name')</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($users as $user)
                    <tr>
                        <td><a href="{{ route('view/user', $user->id) }}">{{{ $user->first_name }}} {{{ $user->last_name }}}</a></td>
                    </tr>
                    @endforeach


                </tbody>
            </table>

            @else
            <div class="col-md-12">
                <div class="alert alert-info alert-block">
                    <i class="fa fa-info-circle"></i>
                    @lang('general.no_results')
                </div>
            </div>
            @endif
        </div>
@stop
