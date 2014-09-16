@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($statuslabel->id)
        @lang('base.statuslabel_update') ::
    @else
        @lang('base.statuslabel_create') ::
    @endif
@parent
@stop

{{-- Page content --}}

@section('content')

<form class="form-horizontal" method="post" action="" autocomplete="off">
    
<div class="row header">
    <div class="col-md-10">
            
        <button type="submit" class="btn btn-success pull-right"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>            
        <a href="{{ URL::previous() }}" class="btn btn-default pull-right"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
            
        <h3>
        @if ($statuslabel->id)
            @lang('base.statuslabel_update')
        @elseif(isset($clone_statuslabel))
            @lang('base.statuslabel_clone')
        @else
            @lang('base.statuslabel_create')
        @endif
        </h3>
            
    </div>                            
</div>

<div class="col-md-12">

        <!-- checked out assets table -->

            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />



            <!-- Asset Title -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">@lang('base.statuslabel')
                <i class='icon-asterisk'></i></label>
                </label>
                    <div class="col-md-5">
                        <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $statuslabel->name) }}}" />
                        {{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>
            
            <div class="form-group {{ $errors->has('inventory_state_id') ? ' has-error' : '' }}">
                <label for="inventory_state_id" class="col-md-2 control-label">@lang('base.inventorystate')
                <i class='icon-asterisk'></i></label>
                <div class="col-md-5">
                    {{ Form::select('inventory_state_id', $inventory_state_list , Input::old('inventory_state_id', $statuslabel->inventory_state_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('inventory_state_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>

            <!-- Form actions -->
            <div class="form-group">
                <label class="col-md-2 control-label"></label>
                <div class="col-md-7">
                        <a href="{{ URL::previous() }}" class="btn btn-default"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
                        <button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>
                </div>
            </div>
            


</div>

</form>
        
@stop
