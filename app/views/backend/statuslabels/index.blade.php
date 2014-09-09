@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/statuslabels/table.title') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/statuslabel') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('general.create')</a>
        <h3>@lang('admin/statuslabels/table.title')</h3>
    </div>
</div>

<div class="row form-wrapper">
    <div class="col-md-9">
        @if ($statuslabels->count() > 0) 
        <table id="example">
            <thead>
                <tr role="row">
                    <th class="col-md-4">@lang('admin/statuslabels/table.name')</th>
                    <th class="col-md-4">@lang('general.inventory_state')</th>
                    <th class="col-md-2 actions">@lang('table.actions')</th>
                </tr>
            </thead>
        <tbody>
           
            @foreach($statuslabels as $label)
            <tr>
                <td><span style="visibility: hidden;">{{$label->id }}</span>{{{ $label->name }}}</td>
                <td>@if($label->inventory_state)
                        {{  $label->inventory_state->name }}  
                    @endif

                </td>
                <td>
                    <a href="{{ route('update/statuslabel', $label->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                    <a data-html="false" 
                        @if($label->isRequired())
                        disabled='true'
                        @endif
                        class="btn delete-asset btn-danger" 
                        data-toggle="modal" href="{{ route('delete/statuslabel', $label->id) }}" data-content="@lang('admin/statuslabels/message.delete.confirm')"
                        data-title="@lang('general.delete')
                        {{ htmlspecialchars($label->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    @else
        @lang('general.no_results') 
Im in the else
    @endif
    </div>

    <!-- side address column -->
   <div class="col-md-3 col-xs-12 address pull-right">
        <br /><br />
        <h6>@lang('admin/statuslabels/table.about')</h6>
        <p>@lang('admin/statuslabels/table.info')</p>

    </div>

</div>

@stop
