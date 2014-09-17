@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($user->id)
		@lang('base.user_update')
		{{ $user->fullName() }} ::
	@else
		@lang('base.user_create') ::
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
        @if ($user->id)
        @lang('base.user_update')
        @elseif(isset($clone_user))
            @lang('base.user_clone')
        @else
            @lang('base.user_create')
        @endif
        </h3>
            
    </div>                            
</div>

<!-- Tabs -->
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab-general" data-toggle="tab">@lang('general.general')</a></li>
    <li><a href="#tab-permissions" data-toggle="tab">@lang('general.permissions')</a></li>
</ul>

    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <!-- Tabs Content -->
    <div class="tab-content">
        <!-- General tab -->
        <div class="tab-pane active" id="tab-general">

         <div class="row form-wrapper">
             
            <div class="col-md-12 column">
            <br><br>

            <!-- First Name -->
            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="first_name">@lang('general.first_name')
                <i class='icon-asterisk'></i></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="first_name" id="first_name" value="{{{ Input::old('first_name', $user->first_name) }}}" />
                    {{ $errors->first('first_name', '<span class="alert-msg">:message</span>') }}
                </div>
            </div>

            <!-- Last Name -->
            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="first_name">@lang('general.last_name') <i class='icon-asterisk'></i></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="last_name" id="last_name" value="{{{ Input::old('last_name', $user->last_name) }}}" />
                    {{ $errors->first('last_name', '<span class="alert-msg">:message</span>') }}
                </div>
            </div>

            <!-- Email -->
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="email">@lang('general.email') <i class='icon-asterisk'></i></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="email" id="email" value="{{{ Input::old('email', $user->email) }}}" />
                    {{ $errors->first('email', '<span class="alert-msg">:message</span>') }}
                </div>
            </div>

            <!-- Employee Number -->
            <div class="form-group {{ $errors->has('employee_num') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="employee_num">@lang('admin/users/form.employee_num')</label>
                <div class="col-md-3">
                    <input class="form-control" type="text" name="employee_num" id="employee_num" value="{{{ Input::old('employee_num', $user->employee_num) }}}" />
                    {{ $errors->first('employee_num', '<span class="alert-msg">:message</span>') }}
                </div>
            </div>


            <!-- Jobtitle -->
            <div class="form-group {{ $errors->has('jobtitle') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="jobtitle">@lang('admin/users/form.title')</label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="jobtitle" id="jobtitle" value="{{{ Input::old('jobtitle', $user->jobtitle) }}}" />
                    {{ $errors->first('jobtitle', '<span class="alert-msg">:message</span>') }}
                </div>
            </div>


            <!-- Manager -->
            <div class="form-group {{ $errors->has('manager_id') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="manager_id">@lang('admin/users/form.manager')</label>
                <div class="col-md-5">
                    {{ Form::select('manager_id', $manager_list , Input::old('manager_id', $user->manager_id), array('class'=>'select2', 'style'=>'width:250px')) }}
                    {{ $errors->first('manager_id', '<span class="alert-msg">:message</span>') }}
                </div>
            </div>

            <!-- Location -->
            <div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="location_id">@lang('base.location') 
                    <i class='icon-asterisk'></i></label>
                <div class="col-md-7">
                    {{ Form::select('location_id', $location_list , Input::old('location_id', $user->location_id), array('class'=>'select2', 'style'=>'width:250px')) }}
                    {{ $errors->first('location_id', '<span class="alert-msg">:message</span>') }}
                </div>
            </div>

            <!-- Phone -->
            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="phone">@lang('general.phone')</label>
                <div class="col-md-3">
                    <input class="form-control" type="text" name="phone" id="phone" value="{{{ Input::old('phone', $user->phone) }}}" />
                    {{ $errors->first('phone', '<span class="alert-msg">:message</span>') }}
                </div>
            </div>

            <!-- Password -->
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="password">@lang('general.password')
                @if (!$user->id)
                <i class='icon-asterisk'></i>
                @endif
                </label>
                <div class="col-md-2">
                   <input type="password" name="password" class="form-control" id="password" value="" />
                    {{ $errors->first('password', '<span class="alert-msg">:message</span>') }}
                </div>
            </div>

            <!-- Password Confirm -->
            <div class="form-group {{ $errors->has('password_confirm') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="password_confirm">@lang('general.password_confirm')
                @if (!$user->id)
                <i class='icon-asterisk'></i>
                @endif
                </label>
                <div class="col-md-2">
                   <input type="password" name="password_confirm" id="password_confirm"  class="form-control" value="" />
                    {{ $errors->first('password_confirm', '<span class="alert-msg">:message</span>') }}
                </div>
            </div>


            <!-- Activation Status -->
            <div class="form-group {{ $errors->has('activated') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="activated">@lang('admin/users/form.activated')</label>
                <div class="col-md-7">
                   <div class="controls">
                    <select{{ ($user->id === Sentry::getId() ? ' disabled="disabled"' : '') }} name="activated" id="activated">
                    @if ($user->id)
                    	<option value="1"{{ ($user->isActivated() ? ' selected="selected"' : '') }}>@lang('actions.yes')</option>
                        <option value="0"{{ ( ! $user->isActivated() ? ' selected="selected"' : '') }}>@lang('actions.no')</option>
                    @else
                    	<option value="1"{{ (Input::old('activated') == 1 ? ' selected="selected"' : '') }}>@lang('actions.yes')</option>
                        <option value="0">@lang('actions.no')</option>
                    @endif

                    </select>

                    {{ $errors->first('activated', '<span class="alert-msg">:message</span>') }}
                </div>
                </div>
            </div>


            <!-- Groups -->
            <div class="form-group {{ $errors->has('groups') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="groups">@lang('base.groups')</label>
                <div class="col-md-3">
                   <div class="controls">

                    <select name="groups[]" id="groups[]" multiple="multiple" class="form-control">
                        
                        @foreach ($groups as $group)
                        <option value="{{ $group->id }}"
                        {{ (in_array($group->id, $userGroups) ? ' selected="selected"' : '') }}>
                        {{{ $group->name }}}
                        </option>
                        @endforeach
                    </select>

                    <span class="help-block">
                    	@lang('admin/users/message.groupnotes')

                    </span>
                </div>
                </div>
            </div>


        </div>
          </div>
            </div>

        <!-- Permissions tab -->
        <div class="tab-pane" id="tab-permissions">
        <div class="row form-wrapper">
            <div class="col-md-12 column">
            <br><br>

                 @foreach ($permissions as $area => $permissions)
                    <fieldset>
                        <legend>{{ $area }}</legend>

                        @foreach ($permissions as $permission)
                        <div class="form-group">
                        	<label class="col-md-3 control-label" for="{{{ $permission['label'] }}}">
                        	{{{ $permission['label'] }}}
                        	</label>
                             <div class="col-md-2">
                             <div class="radio inline">
                                <label for="{{{ $permission['permission'] }}}_allow" onclick="">
                                    <input type="radio" value="1" id="{{{ $permission['permission'] }}}_allow" name="permissions[{{{ $permission['permission'] }}}]"{{ (array_get($userPermissions, $permission['permission']) == '1' ? ' checked="checked"' : '') }}>
                                    @lang('admin/users/form.allow')
                                </label>
                            </div>
                             </div>

                            <div class="col-md-2">
                             <div class="radio inline">
                                <label for="{{{ $permission['permission'] }}}_deny" onclick="">
                                    <input type="radio" value="-1" id="{{{ $permission['permission'] }}}_deny" name="permissions[{{{ $permission['permission'] }}}]"{{ (array_get($userPermissions, $permission['permission']) == '-1' ? ' checked="checked"' : '') }}>
                                    @lang('admin/users/form.deny')
                                </label>
                            </div>
                            </div>

                            @if ($permission['can_inherit'])
                            <div class="col-md-2">
                             <div class="radio inline">
                                <label for="{{{ $permission['permission'] }}}_inherit" onclick="">
                                    <input type="radio" value="0" id="{{{ $permission['permission'] }}}_inherit" name="permissions[{{{ $permission['permission'] }}}]"{{ (array_get($userPermissions, $permission['permission']) == '' ? ' checked="checked"' : '') }}>
                                    @lang('admin/users/form.inherit')
                                </label>
                            </div>
                            </div>
                            @endif
                        </div>
                        @endforeach

                    </fieldset>
                    @endforeach
                    <br><br>

            	</div>
            </div>
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

</form>

@stop
