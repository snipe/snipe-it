@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.statuslabels') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/statuslabel') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i> @lang('actions.create')</a>
        <h3>@lang('base.statuslabels')</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

            <br>
            <!-- checked out assets table -->

            <table id="example">
            <thead>
                <tr role="row">
                    <th class="col-md-4">@lang('general.name')</th>
                    <th class="col-md-4">@lang('base.inventorystate')</th>
                    <th class="col-md-2 actions">@lang('actions.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statuslabels as $statuslabel)
                <tr>
                    <td><span style="visibility: hidden;">{{$statuslabel->id }}</span>{{{ $statuslabel->name }}}</td>
                    <td>@if($statuslabel->inventory_state)
                            {{  $statuslabel->inventory_state->name }}  
                        @endif
                        
                    </td>
                    <td>
                        <a href="{{ route('update/statuslabel', $statuslabel->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                        <a data-html="false" 
                            @if($statuslabel->isRequired())
                            disabled='true'
                            @endif
                            class="btn delete-asset btn-danger" 
                            data-toggle="modal" href="{{ route('delete/statuslabel', $statuslabel->id) }}" data-content="@lang('admin/statuslabels/message.delete.confirm')"
                            data-title="@lang('actions.delete')
                 {{ htmlspecialchars($statuslabel->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        </div>

    <!-- side address column -->
   <div class="col-md-3 col-xs-12 address pull-right">
        <h4>@lang('base.statuslabel_about')</h4>
        <br>
        <p>@lang('admin/statuslabels/message.about')</p>
    </div>

</div>

@stop
