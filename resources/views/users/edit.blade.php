@extends('layouts/default')

{{-- Page title --}}
@section('title')
	@if ($user->id)
		{{ trans('admin/users/table.updateuser') }}
		{{ $user->present()->fullName() }}
	@else
		{{ trans('admin/users/table.createuser') }}
	@endif

@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
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
    table.permissions {
      display:flex;
      flex-direction: column;
    }

    .permissions.table > thead, .permissions.table > tbody {
      margin: 15px;
      margin-top: 0px;
    }
    .permissions.table > tbody+tbody {

    }
    .header-row {
      border-bottom: 1px solid #ccc;
    }

    .header-row h3 {
      margin:0px;
    }
    .permissions-row {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }
    .table > tbody > tr > td.permissions-item {
      padding: 1px;
      padding-left: 8px;
    }

    .header-name {
      cursor: pointer;
    }

</style>

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <form class="form-horizontal" method="post" autocomplete="off" action="{{ ($user) ? route('users.update', ['user' => $user->id]) : route('users.store') }}" id="userForm">
      {{csrf_field()}}

      @if($user->id)
          {{ method_field('PUT') }}
      @endif
        <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">Information</a></li>
          <li><a href="#tab_2" data-toggle="tab">Permissions</a></li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <div class="row">
              <div class="col-md-12">
                <!-- First Name -->
                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="first_name">{{ trans('general.first_name') }}</label>
                  <div class="col-md-8 {{  (\App\Helpers\Helper::checkIfRequired($user, 'first_name')) ? ' required' : '' }}">
                    <input class="form-control" type="text" name="first_name" id="first_name" value="{{ Input::old('first_name', $user->first_name) }}" />
                    {!! $errors->first('first_name', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Last Name -->
                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="last_name">{{ trans('general.last_name') }} </label>
                  <div class="col-md-8{{  (\App\Helpers\Helper::checkIfRequired($user, 'last_name')) ? ' required' : '' }}">
                    <input class="form-control" type="text" name="last_name" id="last_name" value="{{ Input::old('last_name', $user->last_name) }}" />
                    {!! $errors->first('last_name', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Username -->
                <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="username">{{ trans('admin/users/table.username') }}</label>
                  <div class="col-md-8{{  (\App\Helpers\Helper::checkIfRequired($user, 'username')) ? ' required' : '' }}">
                    @if ($user->ldap_import!='1')
                      <input
                        class="form-control"
                        type="text"
                        name="username"
                        id="username"
                        value="{{ Input::old('username', $user->username) }}"
                        autocomplete="off"
                        readonly
                        onfocus="this.removeAttribute('readonly');"
                        {{ ((config('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}
                      >
                      @if (config('app.lock_passwords') && ($user->id))
                        <p class="help-block">{{ trans('admin/users/table.lock_passwords') }}</p>
                      @endif
                    @else
                      (Managed via LDAP)
                          <input type="hidden" name="username" value="{{ Input::old('username', $user->username) }}">

                    @endif

                    {!! $errors->first('username', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Password -->
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="password">
                    {{ trans('admin/users/table.password') }}
                  </label>
                  <div class="col-md-5{{  (\App\Helpers\Helper::checkIfRequired($user, 'password')) ? ' required' : '' }}">
                    @if ($user->ldap_import!='1')
                      <input
                        type="password"
                        name="password"
                        class="form-control"
                        id="password"
                        value=""
                        autocomplete="off"
                        readonly
                        onfocus="this.removeAttribute('readonly');"
                        {{ ((config('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}>
                    @else
                      (Managed via LDAP)
                    @endif
                    <span id="generated-password"></span>
                    {!! $errors->first('password', '<span class="alert-msg">:message</span>') !!}
                  </div>
                  <div class="col-md-4">
                    @if ($user->ldap_import!='1')
                      <a href="#" class="left" id="genPassword">Generate</a>
                    @endif
                  </div>
                </div>

                @if ($user->ldap_import!='1')
                <!-- Password Confirm -->
                <div class="form-group {{ $errors->has('password_confirm') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="password_confirm">
                    {{ trans('admin/users/table.password_confirm') }}
                  </label>
                  <div class="col-md-5 {{  ((\App\Helpers\Helper::checkIfRequired($user, 'first_name')) && (!$user->id)) ? ' required' : '' }}">
                    <input
                    type="password"
                    name="password_confirm"
                    id="password_confirm"
                    class="form-control"
                    value=""
                    autocomplete="off"
                    readonly
                    onfocus="this.removeAttribute('readonly');"
                    {{ ((config('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}
                    >
                    @if (config('app.lock_passwords') && ($user->id))
                    <p class="help-block">{{ trans('admin/users/table.lock_passwords') }}</p>
                    @endif
                    {!! $errors->first('password_confirm', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>
                @endif

                <!-- Email -->
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="email">{{ trans('admin/users/table.email') }} </label>
                  <div class="col-md-8{{  (\App\Helpers\Helper::checkIfRequired($user, 'email')) ? ' required' : '' }}">
                    <input
                      class="form-control"
                      type="text"
                      name="email"
                      id="email"
                      value="{{ Input::old('email', $user->email) }}"
                      {{ ((config('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}
                      autocomplete="off"
                      readonly
                      onfocus="this.removeAttribute('readonly');">
                    @if (config('app.lock_passwords') && ($user->id))
                    <p class="help-block">{{ trans('admin/users/table.lock_passwords') }}</p>
                    @endif
                    {!! $errors->first('email', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Company -->
                @if (\App\Models\Company::canManageUsersCompanies())
                    @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.select_company'), 'fieldname' => 'company_id'])
                @endif

                <!-- language -->
                <div class="form-group {{ $errors->has('locale') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="locale">{{ trans('general.language') }}</label>
                  <div class="col-md-8">
                    {!! Form::locales('locale', Input::old('locale', $user->locale), 'select2') !!}
                    {!! $errors->first('locale', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Employee Number -->
                <div class="form-group {{ $errors->has('employee_num') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="employee_num">{{ trans('admin/users/table.employee_num') }}</label>
                  <div class="col-md-8">
                    <input
                      class="form-control"
                      type="text"
                      name="employee_num"
                      id="employee_num"
                      value="{{ Input::old('employee_num', $user->employee_num) }}"
                    />
                    {!! $errors->first('employee_num', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>


                <!-- Jobtitle -->
                <div class="form-group {{ $errors->has('jobtitle') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="jobtitle">{{ trans('admin/users/table.title') }}</label>
                  <div class="col-md-8">
                    <input
                      class="form-control"
                      type="text"
                      name="jobtitle"
                      id="jobtitle"
                      value="{{ Input::old('jobtitle', $user->jobtitle) }}"
                    />
                    {!! $errors->first('jobtitle', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>


                <!-- Manager -->
              @include ('partials.forms.edit.user-select', ['translated_name' => trans('admin/users/table.manager'), 'fieldname' => 'manager_id'])

                  <!--  Department -->
              @include ('partials.forms.edit.department-select', ['translated_name' => trans('general.department'), 'fieldname' => 'department_id'])


                  <!-- Location -->
              @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])

                <!-- Phone -->
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="phone">{{ trans('admin/users/table.phone') }}</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text" name="phone" id="phone" value="{{ Input::old('phone', $user->phone) }}" />
                    {!! $errors->first('phone', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                  <!-- Address -->
                  <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                      <label class="col-md-3 control-label" for="address">{{ trans('general.address') }}</label>
                      <div class="col-md-4">
                          <input class="form-control" type="text" name="address" id="address" value="{{ Input::old('address', $user->address) }}" />
                          {!! $errors->first('address', '<span class="alert-msg">:message</span>') !!}
                      </div>
                  </div>

                  <!-- City -->
                  <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                      <label class="col-md-3 control-label" for="city">{{ trans('general.city') }}</label>
                      <div class="col-md-4">
                          <input class="form-control" type="text" name="city" id="city" value="{{ Input::old('city', $user->city) }}" />
                          {!! $errors->first('city', '<span class="alert-msg">:message</span>') !!}
                      </div>
                  </div>

                  <!-- State -->
                  <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                      <label class="col-md-3 control-label" for="state">{{ trans('general.state') }}</label>
                      <div class="col-md-4">
                          <input class="form-control" type="text" name="state" id="state" value="{{ Input::old('state', $user->state) }}" maxlength="3" />
                          {!! $errors->first('state', '<span class="alert-msg">:message</span>') !!}
                      </div>
                  </div>

                  <!-- Country -->
                  <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                      <label class="col-md-3 control-label" for="city">{{ trans('general.country') }}</label>
                      <div class="col-md-4">
                          {!! Form::countries('country', Input::old('country', $user->country), 'select2') !!}
                          {!! $errors->first('country', '<span class="alert-msg">:message</span>') !!}
                      </div>
                  </div>

                  <!-- Zip -->
                  <div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
                      <label class="col-md-3 control-label" for="zip">{{ trans('general.zip') }}</label>
                      <div class="col-md-4">
                          <input class="form-control" type="text" name="zip" id="zip" value="{{ Input::old('zip', $user->zip) }}" maxlength="10" />
                          {!! $errors->first('zip', '<span class="alert-msg">:message</span>') !!}
                      </div>
                  </div>



                  <!-- Activation Status -->
                  <div class="form-group {{ $errors->has('activated') ? 'has-error' : '' }}">

                      <div class="form-group">
                          <div class="col-md-3 control-label">
                              {{ Form::label('activated', trans('admin/users/table.activated')) }}
                          </div>
                          <div class="col-md-9">
                              @if (config('app.lock_passwords'))
                                  <div class="icheckbox disabled" style="padding-left: 10px;">
                                      <input type="checkbox" value="1" name="activated" class="minimal disabled" {{ (old('activated', $user->activated)) == '1' ? ' checked="checked"' : '' }} disabled="disabled">
                                      {{ trans('admin/users/general.activated_help_text') }}
                                      <p class="help-block">{{ trans('general.feature_disabled') }}</p>
                                      kjasdhv
                                  </div>
                              @elseif ($user->id === Auth::user()->id)
                                  <div class="icheckbox disabled" style="padding-left: 10px;">
                                      <input type="checkbox" value="1" name="activated" class="minimal disabled" {{ (old('activated', $user->activated)) == '1' ? ' checked="checked"' : '' }} disabled="disabled">
                                      {{ trans('admin/users/general.activated_help_text') }}
                                      <p class="help-block">{{ trans('admin/users/general.activated_disabled_help_text') }}</p>

                                  </div>
                              @else
                                  <div style="padding-left: 10px;">
                                      <input type="checkbox" value="1" name="activated" class="minimal" {{ (old('activated', $user->activated)) == '1' ? ' checked="checked"' : '' }}>
                                  {{ trans('admin/users/general.activated_help_text') }}
                                  </div>
                              @endif

                              {!! $errors->first('activated', '<span class="alert-msg">:message</span>') !!}

                      </div>
                    </div>
                  </div>

                @if ($snipeSettings->two_factor_enabled!='')
                  @if ($snipeSettings->two_factor_enabled=='1')
                  <div class="form-group">
                    <div class="col-md-3 control-label">
                      {{ Form::label('two_factor_optin', trans('admin/settings/general.two_factor')) }}
                    </div>
                    <div class="col-md-9">
                        @if (config('app.lock_passwords'))
                            <div class="icheckbox disabled">
                            {{ Form::checkbox('two_factor_optin', '1', Input::old('two_factor_optin', $user->two_factor_optin),['class' => 'minimal', 'disabled'=>'disabled']) }} {{ trans('admin/settings/general.two_factor_enabled_text') }}
                                <p class="help-block">{{ trans('general.feature_disabled') }}</p>
                            </div>
                        @else
                            {{ Form::checkbox('two_factor_optin', '1', Input::old('two_factor_optin', $user->two_factor_optin),['class' => 'minimal']) }} {{ trans('admin/settings/general.two_factor_enabled_text') }}
                            <p class="help-block">{{ trans('admin/users/general.two_factor_admin_optin_help') }}</p>

                        @endif

                    </div>
                  </div>
                  @endif

                  <!-- Reset Two Factor -->
                  <div class="form-group">
                    <div class="col-md-8 col-md-offset-3 two_factor_resetrow">
                      <a class="btn btn-default btn-sm pull-left" id="two_factor_reset" style="margin-right: 10px;"> {{ trans('admin/settings/general.two_factor_reset') }}</a>
                      <span id="two_factor_reseticon">
                      </span>
                      <span id="two_factor_resetresult">
                      </span>
                      <span id="two_factor_resetstatus">
                      </span>
                    </div>
                    <div class="col-md-8 col-md-offset-3 two_factor_resetrow">
                      <p class="help-block">{{ trans('admin/settings/general.two_factor_reset_help') }}</p>
                    </div>
                  </div>
                @endif

                <!-- Notes -->
                <div class="form-group{!! $errors->has('notes') ? ' has-error' : '' !!}">
                  <label for="notes" class="col-md-3 control-label">{{ trans('admin/users/table.notes') }}</label>
                  <div class="col-md-8">
                    <textarea class="form-control" id="notes" name="notes">{{ Input::old('notes', $user->notes) }}</textarea>
                    {!! $errors->first('notes', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
                </div>

                  <!-- Groups -->
                  <div class="form-group{{ $errors->has('groups') ? ' has-error' : '' }}">
                      <label class="col-md-3 control-label" for="groups"> {{ trans('general.groups') }}</label>
                      <div class="col-md-5">

                          @if ((Config::get('app.lock_passwords') || (!Auth::user()->isSuperUser())))

                              @if (count($userGroups->keys()) > 0)
                                  <ul>
                                      @foreach ($groups as $id => $group)
                                          {!! ($userGroups->keys()->contains($id) ? '<li>'.e($group).'</li>' : '') !!}
                                      @endforeach
                                  </ul>
                              @endif

                              <span class="help-block">Only superadmins may edit group memberships.</p>
                                  @else
                                      <div class="controls">
                        <select
                                name="groups[]"
                                id="groups[]"
                                multiple="multiple"
                                class="form-control">

                            @foreach ($groups as $id => $group)
                                <option value="{{ $id }}"
                                        {{ ($userGroups->keys()->contains($id) ? ' selected="selected"' : '') }}>
                                    {{ $group }}
                                </option>
                            @endforeach
                        </select>

                        <span class="help-block">
                          {{ trans('admin/users/table.groupnotes') }}
                        </span>
                    </div>
                          @endif

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
                </div> <!--/form-group-->
                @endif
              </div> <!--/col-md-12-->
            </div>
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="tab_2">
            <div class="col-md-12">
              @if (!Auth::user()->isSuperUser())
                <p class="alert alert-warning">Only superadmins may grant a user superadmin access.</p>
              @endif
            </div>

            <table class="table table-striped permissions">
              <thead>
                <tr class="permissions-row">
                  <th class="col-md-5">Permission</th>
                  <th class="col-md-1">Grant</th>
                  <th class="col-md-1">Deny</th>
                  <th class="col-md-1">Inherit</th>
                </tr>
              </thead>


              @foreach ($permissions as $area => $permissionsArray)
              @if (count($permissionsArray) == 1)
                <?php $localPermission = $permissionsArray[0]; ?>
                <tr class="header-row permissions-row">
                  <td class="col-md-5 tooltip-base permissions-item"
                    data-toggle="tooltip"
                    data-placement="right"
                    title="{{ $localPermission['note'] }}">
                    <h4>{{ $area . ': ' . $localPermission['label'] }}</h4>
                  </td>

                  <td class="col-md-1 permissions-item">
                    @if (($localPermission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
                      {{ Form::radio('permission['.$localPermission['permission'].']', '1',$userPermissions[$localPermission['permission'] ] == '1',['disabled'=>"disabled", 'class'=>'minimal']) }}
                    @else
                      {{ Form::radio('permission['.$localPermission['permission'].']', '1',$userPermissions[$localPermission['permission'] ] == '1',['value'=>"grant", 'class'=>'minimal']) }}
                    @endif
                  </td>
                  <td class="col-md-1 permissions-item">
                    @if (($localPermission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
                      {{ Form::radio('permission['.$localPermission['permission'].']', '-1',$userPermissions[$localPermission['permission'] ] == '-1',['disabled'=>"disabled", 'class'=>'minimal']) }}
                    @else
                      {{ Form::radio('permission['.$localPermission['permission'].']', '-1',$userPermissions[$localPermission['permission'] ] == '-1',['value'=>"deny", 'class'=>'minimal']) }}
                    @endif
                  </td>
                  <td class="col-md-1 permissions-item">
                    @if (($localPermission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
                      {{ Form::radio('permission['.$localPermission['permission'].']','0',$userPermissions[$localPermission['permission'] ] == '0',['disabled'=>"disabled",'class'=>'minimal'] ) }}
                    @else
                      {{ Form::radio('permission['.$localPermission['permission'].']','0',$userPermissions[$localPermission['permission'] ] == '0',['value'=>"inherit", 'class'=>'minimal'] ) }}
                    @endif
                  </td>
                </tr>

              @else

                <tr class="header-row permissions-row">
                  <td class="col-md-5 header-name">
                    <h3>{{ $area }}</h3>
                  </td>
                  <td class="col-md-1 permissions-item">
                    {{ Form::radio("$area", '1',false,['value'=>"grant", 'class'=>'minimal', 'data-checker-group' => str_slug($area)]) }}
                  </td>
                  <td class="col-md-1 permissions-item">
                    {{ Form::radio("$area", '-1',false,['value'=>"deny", 'class'=>'minimal', 'data-checker-group' => str_slug($area)]) }}
                  </td>
                  <td class="col-md-1 permissions-item">
                    {{ Form::radio("$area", '0',false,['value'=>"inherit", 'class'=>'minimal', 'data-checker-group' => str_slug($area)] ) }}
                  </td>
                </tr>

                @foreach ($permissionsArray as $index => $permission)
                <tr class="permissions-row">
                  @if ($permission['display'])
                    <td
                      class="col-md-5 tooltip-base permissions-item"
                      data-toggle="tooltip"
                      data-placement="right"
                      title="{{ $permission['note'] }}">
                      {{ $permission['label'] }}
                    </td>
                    <td class="col-md-1 permissions-item">
                      @if (($permission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
                      {{ Form::radio('permission['.$permission['permission'].']', '1', $userPermissions[$permission['permission'] ] == '1', ["value"=>"grant", 'disabled'=>'disabled', 'class'=>'minimal radiochecker-'.str_slug($area)]) }}
                      @else
                      {{ Form::radio('permission['.$permission['permission'].']', '1', $userPermissions[ $permission['permission'] ] == '1', ["value"=>"grant",'class'=>'minimal radiochecker-'.str_slug($area)]) }}
                      @endif
                    </td>
                    <td class="col-md-1 permissions-item">
                      @if (($permission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
                      {{ Form::radio('permission['.$permission['permission'].']', '-1', $userPermissions[$permission['permission'] ] == '-1', ["value"=>"deny", 'disabled'=>'disabled', 'class'=>'minimal radiochecker-'.str_slug($area)]) }}
                      @else
                      {{ Form::radio('permission['.$permission['permission'].']', '-1', $userPermissions[$permission['permission'] ] == '-1', ["value"=>"deny",'class'=>'minimal radiochecker-'.str_slug($area)]) }}
                      @endif
                    </td>
                    <td class="col-md-1 permissions-item">
                      @if (($permission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
                      {{ Form::radio('permission['.$permission['permission'].']', '0', $userPermissions[$permission['permission']] =='0', ["value"=>"inherit", 'disabled'=>'disabled', 'class'=>'minimal radiochecker-'.str_slug($area)]) }}
                      @else
                      {{ Form::radio('permission['.$permission['permission'].']', '0', $userPermissions[$permission['permission']] =='0', ["value"=>"inherit", 'class'=>'minimal radiochecker-'.str_slug($area)]) }}
                      @endif
                    </td>
                  @endif
                </tr>
                @endforeach

              @endif
              @endforeach
              </tbody>
            </table>
          </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
        <div class="box-footer text-right">
          <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
        </div>
      </div><!-- nav-tabs-custom -->
    </form>
  </div> <!--/col-md-8-->
</div><!--/row-->
@stop

@section('moar_scripts')
<script src="{{ asset('js/pGenerator.jquery.js') }}"></script>

<script nonce="{{ csrf_token() }}">
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

	// Check/Uncheck all radio buttons in the group
    $('tr.header-row input:radio').on('ifClicked', function () {
        value = $(this).attr('value');
        area = $(this).data('checker-group');
        $('.radiochecker-'+area+'[value='+value+']').iCheck('check');
    });

    $('.header-name').click(function() {
        $(this).parent().nextUntil('tr.header-row').slideToggle(500);
    });

    $('.tooltip-base').tooltip({container: 'body'})
    $(".superuser").change(function() {
        var perms = $(this).val();
        if (perms =='1') {
            $("#nonadmin").hide();
        } else {
            $("#nonadmin").show();
        }
    });

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

    $("#two_factor_reset").click(function(){
        $("#two_factor_resetrow").removeClass('success');
        $("#two_factor_resetrow").removeClass('danger');
        $("#two_factor_resetstatus").html('');
        $("#two_factor_reseticon").html('<i class="fa fa-spinner spin"></i>');
        $.ajax({
            url: '{{ route('api.users.two_factor_reset', ['id'=> $user->id]) }}',
            type: 'POST',
            data: {},
            headers: {
                "X-Requested-With": 'XMLHttpRequest',
                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',

            success: function (data) {
                $("#two_factor_reseticon").html('');
                $("#two_factor_resetstatus").html('<i class="fa fa-check text-success"></i>' + data.message);
            },

            error: function (data) {
                $("#two_factor_reseticon").html('');
                $("#two_factor_reseticon").html('<i class="fa fa-exclamation-triangle text-danger"></i>');
                $('#two_factor_resetstatus').text(data.message);
            }


        });
    });


});
</script>


@stop
