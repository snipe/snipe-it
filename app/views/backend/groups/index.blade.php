@extends('backend/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('base.groups') ::
@parent
@stop

{{-- Content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/group') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i> @lang('actions.create')</a>
        <h3>@lang('base.groups')</h3>
    </div>
</div>



<div class="user-profile">
<div class="row profile">
    <div class="col-md-9 bio">
<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-3">@lang('general.name')</th>
            <th class="col-md-2">@lang('base.users')</th>
            <th class="col-md-2">@lang('general.created')</th>
            <th class="col-md-1 actions">@lang('actions.actions')</th>
        </tr>
    </thead>
    <tbody>
        @if ($groups->count() >= 1)
        @foreach ($groups as $group)
        <tr>
            <td>{{ $group->name }}</td>
            <td>{{ $group->users()->count() }}</td>
            <td>{{ $group->created_at->diffForHumans() }}</td>
            <td>
                <a href="{{ route('update/group', $group->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/group', $group->id) }}" data-content="@lang('admin/groups/message.delete.confirm')"
data-title="@lang('actions.delete')"
{{ htmlspecialchars($group->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="5">@lang('general.no_results')</td>
        </tr>
        @endif
    </tbody>
</table>
        
    </div>

<!-- side address column -->
<div class="col-md-3 col-xs-12 address pull-right">
    <br />
    <h6>@lang('base.group_about')</h6>
    <p>@lang('admin/groups/message.about') </p>

</div>
</div>
</div>

@stop
