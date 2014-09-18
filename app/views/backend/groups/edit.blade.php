@extends('backend/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('base.groups') ::
@parent
@stop

{{-- Content --}}
@section('content')

<form class="form-horizontal" method="post" action="" autocomplete="off">
    
<div class="row header">
    <div class="col-md-10">
            
        <button type="submit" class="btn btn-success pull-right"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>            
        <a href="{{ URL::previous() }}" class="btn btn-default pull-right"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
            
        <h3>
            @lang('base.group_update')
        </h3>
            
    </div>                            
</div>

<div class="row form-wrapper">
<div class="col-md-10 column">

    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Name -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">@lang('general.name')
                 <i class='icon-asterisk'></i></label>
                 </label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $group->name) }}}" />
                        {{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>
            <br><br>


                    @foreach ($permissions as $area => $permissions)
                    
                        <legend>@lang('general.permissions')</legend>

                        @foreach ($permissions as $permission)
                        <div class="field-box">
                            <label for="name" class="col-md-2 control-label">{{{ $permission['label'] }}}</label>
                            <div class="col-md-8">
                                <label class="radio-inline">
                                    <input type="radio" value="1" id="{{{ $permission['permission'] }}}_allow" 
                                           name="permissions[{{{ $permission['permission'] }}}]"{{ (array_get($groupPermissions, $permission['permission']) === 1 ? ' 
                                           checked="checked"' : '') }}> @lang('actions.allow')
                                </label>

                                <label class="radio-inline">
                                    <input type="radio" value="0" id="{{{ $permission['permission'] }}}_deny" 
                                           name="permissions[{{{ $permission['permission'] }}}]"{{ ( ! array_get($groupPermissions, $permission['permission']) ? ' 
                                           checked="checked"' : '') }}> @lang('actions.deny')
                                </label>
                            </div>
                        </div>


                        @endforeach
                    @endforeach

                <br><br><br><br>

            <!-- Form actions -->
            <div class="form-group">
                <br>
                <label class="col-md-2 control-label"></label>
                    <div class="col-md-7">
                        <a href="{{ URL::previous() }}" class="btn btn-default"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
                        <button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>
                    </div>
            </div>

</div>
</div>

</form>

@stop
