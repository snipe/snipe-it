@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($user->id)
		@lang('admin/users/table.updateuser')
		{{ $user->fullName() }} ::
	@else
		@lang('admin/users/table.createuser') ::
	@endif

@parent
@stop

{{-- Page content --}}
@section('content')

<style>
.form-horizontal .control-label {
  padding-top: 0px;
}

input[type='text'][disabled], input[disabled], textarea[disabled], input[readonly], textarea[readonly], .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
  background-color: white;
  color: #555555;
  cursor:text;
}

</style>

<div class="page-header">

        <div class="pull-right">
            <a href="{{ route('users') }}" class="btn-flat gray"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>
        </div>
    <h3>
        @if ($user->id)
            @lang('admin/users/table.updateuser')
            {{ $user->fullName() }}
	@elseif(isset($clone_user))
            @lang('admin/users/table.cloneuser')
        @else
            @lang('admin/users/table.createuser')
	@endif
    </h3>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
    <li><a href="#tab-permissions" data-toggle="tab">Permissions</a></li>
</ul>

<form class="form-horizontal" method="post" action="" autocomplete="off">
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
                <label class="col-md-3 control-label" for="first_name">@lang('general.first_name')
                <i class='fa fa-asterisk'></i></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="first_name" id="first_name" value="{{{ Input::old('first_name', $user->first_name) }}}" />
                    {{ $errors->first('first_name', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>

            <!-- Last Name -->
            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="last_name">@lang('general.last_name') <i class='fa fa-asterisk'></i></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="last_name" id="last_name" value="{{{ Input::old('last_name', $user->last_name) }}}" />
                    {{ $errors->first('last_name', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>


			<!-- Username -->
            <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="username">@lang('admin/users/table.username') <i class='fa fa-asterisk'></i></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="username" id="username" value="{{{ Input::old('username', $user->username) }}}"  {{ ((Config::get('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }} autocomplete="false" readonly onfocus="this.removeAttribute('readonly');">
                    @if (Config::get('app.lock_passwords') && ($user->id))
					 	              <p class="help-block">@lang('admin/users/table.lock_passwords')</p>
					          @endif

                    {{ $errors->first('username', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>

			<!-- Password -->
			<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
				<label class="col-md-3 control-label" for="password">@lang('admin/users/table.password')
				@if (!$user->id)
					<i class='fa fa-asterisk'></i>
				@endif
				</label>
				<div class="col-md-5">
					<input type="password" name="password" class="form-control" id="password" value="" {{ ((Config::get('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }} autocomplete="false" readonly onfocus="this.removeAttribute('readonly');">
					<span id="generated-password"></span>
						{{ $errors->first('password', '<br><span class="alert-msg">:message</span>') }}
				</div>
				<div class="col-md-4">
					 <a href="#" class="left" id="genPassword">Generate</a>
				</div>


			</div>


			<!-- Password Confirm -->
			<div class="form-group {{ $errors->has('password_confirm') ? 'has-error' : '' }}">
				<label class="col-md-3 control-label" for="password_confirm">@lang('admin/users/table.password_confirm')
				@if (!$user->id)
				<i class='fa fa-asterisk'></i>
				@endif
				</label>
				<div class="col-md-5">
				<input type="password" name="password_confirm" id="password_confirm"  class="form-control" value="" {{ ((Config::get('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }} autocomplete="off">
				@if (Config::get('app.lock_passwords') && ($user->id))
					<p class="help-block">@lang('admin/users/table.lock_passwords')</p>
				@endif
					{{ $errors->first('password_confirm', '<br><span class="alert-msg">:message</span>') }}
				</div>
			</div>

			<!-- Email -->
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="email">@lang('admin/users/table.email') </label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="email" id="email" value="{{{ Input::old('email', $user->email) }}}"  {{ ((Config::get('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }} autocomplete="off"  readonly onfocus="this.removeAttribute('readonly');">
                     @if (Config::get('app.lock_passwords') && ($user->id))
          					 	<p class="help-block">@lang('admin/users/table.lock_passwords')</p>
          					 @endif

                    {{ $errors->first('email', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>

          <!-- Company -->
          @if (Company::canManageUsersCompanies())
              <!-- Company -->
              <div class="form-group {{ $errors->has('company_id') ? 'has-error' : '' }}">
                  <div class="col-md-3 control-label">
                      {{ Form::label('company_id', Lang::get('general.company')) }}
                  </div>
                  <div class="col-md-7">
                      {{ Form::select('company_id', $company_list , Input::old('company_id', $user->company_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                      {{ $errors->first('company_id', '<br><span class="alert-msg">:message</span>') }}
                  </div>
              </div>
            @endif



        	<!-- Employee Number -->
            <div class="form-group {{ $errors->has('employee_num') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="employee_num">@lang('admin/users/table.employee_num')</label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="employee_num" id="employee_num" value="{{{ Input::old('employee_num', $user->employee_num) }}}" />
                    {{ $errors->first('employee_num', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>


            <!-- Jobtitle -->
            <div class="form-group {{ $errors->has('jobtitle') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="jobtitle">@lang('admin/users/table.title')</label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="jobtitle" id="jobtitle" value="{{{ Input::old('jobtitle', $user->jobtitle) }}}" />
                    {{ $errors->first('jobtitle', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>


			<!-- Manager -->
            <div class="form-group {{ $errors->has('manager_id') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="manager_id">@lang('admin/users/table.manager')</label>
                <div class="col-md-7">
                    {{ Form::select('manager_id', $manager_list , Input::old('manager_id', $user->manager_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                    {{ $errors->first('manager_id', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>

			<!-- Location -->
            <div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="location_id">@lang('admin/users/table.location')
                    </label>
                <div class="col-md-7">
                    {{ Form::select('location_id', $location_list , Input::old('location_id', $user->location_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                    {{ $errors->first('location_id', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>

			<!-- Phone -->
            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="phone">@lang('admin/users/table.phone')</label>
                <div class="col-md-4">
                    <input class="form-control" type="text" name="phone" id="phone" value="{{{ Input::old('phone', $user->phone) }}}" />
                    {{ $errors->first('phone', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>

			<!-- Activation Status -->
            <div class="form-group {{ $errors->has('activated') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="activated">@lang('admin/users/table.activated')</label>
                <div class="col-md-7">
                   <div class="controls">
                    <select{{ ($user->id === Sentry::getId() ? ' disabled="disabled"' : '') }} name="activated" id="activated" {{ ((Config::get('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}>
                    @if ($user->id)
                    	<option value="1"{{ ($user->isActivated() ? ' selected="selected"' : '') }}>@lang('general.yes')</option>
                        <option value="0"{{ ( ! $user->isActivated() ? ' selected="selected"' : '') }}>@lang('general.no')</option>
                    @else
                    	<option value="1"{{ (Input::old('activated') == 1 ? ' selected="selected"' : '') }}>@lang('general.yes')</option>
                        <option value="0">@lang('general.no')</option>
                    @endif

                    </select>

                    {{ $errors->first('activated', '<br><span class="alert-msg">:message</span>') }}
                </div>
                </div>
            </div>

	<!-- Notes -->
            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                <label for="notes" class="col-md-3 control-label">@lang('admin/users/table.notes')</label>
                <div class="col-md-7">
                    <textarea class="form-control" id="notes" name="notes">{{{ Input::old('notes', $user->notes) }}}</textarea>
                    {{ $errors->first('notes', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Groups -->
            <div class="form-group {{ $errors->has('groups') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="groups">@lang('general.groups')</label>
                <div class="col-md-5">
                   <div class="controls">

                    <select name="groups[]" id="groups[]" multiple="multiple" class="form-control" {{ ((Config::get('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}>

                        @foreach ($groups as $group)
                        <option value="{{ $group->id }}"
                        {{ (in_array($group->id, $userGroups) ? ' selected="selected"' : '') }}>
                        {{{ $group->name }}}
                        </option>
                        @endforeach
                    </select>

                    <span class="help-block">
                    	@lang('admin/users/table.groupnotes')

                    </span>
                </div>
                </div>
            </div>

            <!-- Email user -->
            @if (!$user->id)

			<div class="form-group">
				<div class="col-sm-3">
				</div>
				<div class="col-sm-9">
					<div class="checkbox">
						<label for="email_user">
							{{ Form::checkbox('email_user', '1', Input::old('email_user'), array('id'=>'email_user','disabled'=>'disabled')) }}

							Email this user their credentials? <span class="help-text" id="email_user_warn">(Cannot send email. No user email address specified.)</span>
						</label>
					</div>
				</div>
			</div>
			@endif



        </div>
          </div>
            </div>

        <!-- Permissions tab -->
        <div class="tab-pane" id="tab-permissions">
        <div class="row form-wrapper">
            <div class="col-md-12 column">
            <br><br>

            @if (Config::get('app.lock_passwords') && ($user->id))
		 	        <p class="help-block">@lang('admin/users/table.lock_passwords')</p>
		 	     @endif

          @if ((($user->id!='')) && (!Sentry::getUser()->hasAccess('superuser')))
            <p class="alert alert-warning">Only superadmins may edit a user's permissions.</p>
          @endif

                 @foreach ($permissions as $area => $permissions)
                    <fieldset>
                        <legend>{{ $area }}</legend>

                        @foreach ($permissions as $permission)
                        <p>{{{ $permission['note'] }}}</p>

                        <div class="form-group">
                        	<label class="col-md-3 control-label" for="{{{ $permission['label'] }}}">
                        	{{{ $permission['label'] }}}
                        	</label>

                          @if ((($user->id!='')) && (!Sentry::getUser()->hasAccess('superuser')))

                          <div class="col-md-8">

                            @if (array_get($userPermissions, $permission['permission'])=='1')
                              Enabled
                            @elseif (array_get($userPermissions, $permission['permission'])=='-1')
                              Inherit
                            @else
                              Deny
                            @endif
                          </div>

                          @else
                             <div class="col-md-2">
                             <div class="radio inline">
                                <label for="{{{ $permission['permission'] }}}_allow" onclick="">
                                    <input type="radio" value="1" id="{{{ $permission['permission'] }}}_allow" name="permissions[{{{ $permission['permission'] }}}]"{{ (array_get($userPermissions, $permission['permission']) == '1' ? ' checked="checked"' : '') }}{{ ((Config::get('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}>
                                    @lang('admin/users/table.allow')
                                </label>
                            </div>
                             </div>

                            <div class="col-md-2">
                             <div class="radio inline">
                                <label for="{{{ $permission['permission'] }}}_deny" onclick="">
                                    <input type="radio" value="-1" id="{{{ $permission['permission'] }}}_deny" name="permissions[{{{ $permission['permission'] }}}]"{{ (array_get($userPermissions, $permission['permission']) == '-1' ? ' checked="checked"' : '') }}>
                                    @lang('admin/users/table.deny')
                                </label>
                            </div>
                            </div>

                            @if ($permission['can_inherit'])
                            <div class="col-md-2">
                             <div class="radio inline">
                                <label for="{{{ $permission['permission'] }}}_inherit" onclick="">
                                    <input type="radio" value="0" id="{{{ $permission['permission'] }}}_inherit" name="permissions[{{{ $permission['permission'] }}}]"{{ (array_get($userPermissions, $permission['permission']) == '' ? ' checked="checked"' : '') }}>
                                    @lang('admin/users/table.inherit')
                                </label>
                            </div>
                            </div>
                            @endif
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
		<label class="col-md-3 control-label"></label>
			<div class="col-md-7">
				<a class="btn btn-link" href="{{ route('users') }}">@lang('button.cancel')</a>
				<button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
			</div>
		</div>

</form>

<script>
$(document).ready(function() {

	$('#email').on('keyup',function(){

	    if(this.value.length > 0){
	        $("#email_user").prop("disabled",false);
			$("#email_user_warn").html("");
	    } else {
	        $("#email_user").prop("disabled",true);
			$("#email_user").prop("checked",false);
	    }

	});
});
</script>

<script src="{{ asset('assets/js/pGenerator.jquery.js') }}"></script>

<script>
$(document).ready(function(){

    $('#genPassword').pGenerator({
        'bind': 'click',
        'passwordElement': '#password',
        'displayElement': '#generated-password',
        'passwordLength': 16,
        'uppercase': true,
        'lowercase': true,
        'numbers':   true,
        'specialChars': true,
        'onPasswordGenerated': function(generatedPassword) {
			 $('#password_confirm').val($('#password').val());
        }
    });
});
</script>

@stop
