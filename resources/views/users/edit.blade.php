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

    .permissions.table > tbody {
        border: 1px solid;
    }

    .header-row {
      border-bottom: 1px solid #ccc;
    }

    .permissions-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
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
    <form class="form-horizontal" method="post" autocomplete="off" action="{{ (isset($user->id)) ? route('users.update', ['user' => $user->id]) : route('users.store') }}" enctype="multipart/form-data" id="userForm">
      {{csrf_field()}}

      @if($user->id)
          {{ method_field('PUT') }}
      @endif
        <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">{{ trans('general.information') }} </a></li>
          <li><a href="#permissions" data-toggle="tab">{{ trans('general.permissions') }} </a></li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <div class="row">
              <div class="col-md-12">
                <!-- First Name -->
                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="first_name">{{ trans('general.first_name') }}</label>
                  <div class="col-md-6{{  (Helper::checkIfRequired($user, 'first_name')) ? ' required' : '' }}">
                    <input class="form-control" type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" maxlength="191" />
                    {!! $errors->first('first_name', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                  </div>
                </div>

                <!-- Last Name -->
                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="last_name">{{ trans('general.last_name') }} </label>
                  <div class="col-md-6{{  (Helper::checkIfRequired($user, 'last_name')) ? ' required' : '' }}">
                    <input class="form-control" type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" maxlength="191" />
                    {!! $errors->first('last_name', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                  </div>
                </div>

                <!-- Username -->
                <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="username">{{ trans('admin/users/table.username') }}</label>
                  <div class="col-md-6{{  (Helper::checkIfRequired($user, 'username')) ? ' required' : '' }}">
                    @if ($user->ldap_import!='1' || str_contains(Route::currentRouteName(), 'clone'))
                      <input
                        class="form-control"
                        type="text"
                        name="username"
                        id="username"
                        value="{{ Request::old('username', $user->username) }}"
                        autocomplete="off"
                        maxlength="191"
                        readonly
                        onfocus="this.removeAttribute('readonly');"
                        {{ ((config('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}
                      >
                      @if (config('app.lock_passwords') && ($user->id))
                        <p class="help-block">{{ trans('admin/users/table.lock_passwords') }}</p>
                      @endif
                    @else
                      {{ trans('general.managed_ldap') }}
                          <input type="hidden" name="username" value="{{ Request::old('username', $user->username) }}">

                    @endif

                    {!! $errors->first('username', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                  </div>
                </div>

                <!-- Password -->
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="password">
                    {{ trans('admin/users/table.password') }}
                  </label>
                  <div class="col-md-6{{  (Helper::checkIfRequired($user, 'password')) ? ' required' : '' }}">
                    @if ($user->ldap_import!='1' || str_contains(Route::currentRouteName(), 'clone') )
                      <input
                        type="password"
                        name="password"
                        class="form-control"
                        id="password"
                        value=""
                        maxlength="500"
                        autocomplete="off"
                        readonly
                        onfocus="this.removeAttribute('readonly');"
                        {{ ((config('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}>
                    @else
                      {{ trans('general.managed_ldap') }}
                    @endif
                    <span id="generated-password"></span>
                    {!! $errors->first('password', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                  </div>
                  <div class="col-md-2">
                    @if ($user->ldap_import!='1')
                      <a href="#" class="left" id="genPassword">{{ trans('general.generate') }}</a>
                    @endif
                  </div>
                </div>


                @if ($user->ldap_import!='1' || str_contains(Route::currentRouteName(), 'clone'))
                <!-- Password Confirm -->
                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="password_confirmation">
                    {{ trans('admin/users/table.password_confirm') }}
                  </label>
                  <div class="col-md-6{{  ((Helper::checkIfRequired($user, 'password_confirmation')) && (!$user->id)) ? ' required' : '' }}">
                    <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirm"
                    class="form-control"
                    value=""
                    maxlength="500"
                    autocomplete="off"
                    aria-label="password_confirmation"
                    readonly
                    onfocus="this.removeAttribute('readonly');"
                    {{ ((config('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}
                    >
                    @if (config('app.lock_passwords') && ($user->id))
                    <p class="help-block">{{ trans('admin/users/table.lock_passwords') }}</p>
                    @endif
                    {!! $errors->first('password_confirmation', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                  </div>
                </div>
                @endif

              <!-- Activation Status -->
                  <div class="form-group {{ $errors->has('activated') ? 'has-error' : '' }}">

                      <div class="form-group">
                          <div class="col-md-3 control-label">
                              {{ Form::label('activated', trans('general.login_enabled')) }}
                          </div>
                          <div class="col-md-9">
                              @if (config('app.lock_passwords'))
                                  <div class="icheckbox disabled" style="padding-left: 10px;">
                                      <input type="checkbox" value="1" name="activated" class="minimal disabled" {{ (old('activated', $user->activated)) == '1' ? ' checked="checked"' : '' }} disabled="disabled" aria-label="activated">
                                      <!-- this is necessary because the field is disabled and will reset -->
                                      <input type="hidden" name="activated" value="{{ (int)$user->activated }}">
                                      {{ trans('admin/users/general.activated_help_text') }}
                                      <p class="help-block">{{ trans('general.feature_disabled') }}</p>

                                  </div>
                              @elseif ($user->id === Auth::user()->id)
                                  <div class="icheckbox disabled" style="padding-left: 10px;">
                                      <input type="checkbox" value="1" name="activated" class="minimal disabled" {{ (old('activated', $user->activated)) == '1' ? ' checked="checked"' : '' }} disabled="disabled">
                                      <!-- this is necessary because the field is disabled and will reset -->
                                      <input type="hidden" name="activated" value="1" aria-label="activated">
                                      {{ trans('admin/users/general.activated_help_text') }}
                                      <p class="help-block">{{ trans('admin/users/general.activated_disabled_help_text') }}</p>
                                  </div>
                              @else
                                  <div style="padding-left: 10px;">
                                      <input type="checkbox" value="1" id="activated" name="activated" class="minimal" {{ (old('activated', $user->activated)) == '1' ? ' checked="checked"' : '' }} aria-label="activated">
                                      {{ trans('admin/users/general.activated_help_text') }}
                                  </div>
                              @endif

                              {!! $errors->first('activated', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}

                          </div>
                      </div>
                  </div>


                  <!-- Email -->
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="email">{{ trans('admin/users/table.email') }} </label>
                  <div class="col-md-6{{  (Helper::checkIfRequired($user, 'email')) ? ' required' : '' }}">
                    <input
                      class="form-control"
                      type="text"
                      name="email"
                      id="email"
                      maxlength="191"
                      value="{{ Request::old('email', $user->email) }}"
                      {{ ((config('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}
                      autocomplete="off"
                      readonly
                      onfocus="this.removeAttribute('readonly');">
                    @if (config('app.lock_passwords') && ($user->id))
                    <p class="help-block">{{ trans('admin/users/table.lock_passwords') }}</p>
                    @endif
                    {!! $errors->first('email', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                  </div>
                </div>


                  <!-- Email user -->
                  @if (!$user->id)
                      <div class="form-group" id="email_user_row">
                          <div class="col-sm-3">
                          </div>
                          <div class="col-md-9">
                              <div class="icheckbox disabled" id="email_user_div">
                                  {{ Form::checkbox('email_user', '1', Request::old('email_user'),['class' => 'minimal', 'disabled'=>true, 'id' => 'email_user_checkbox']) }}
                                  Email this user their credentials?

                              </div>
                              <p class="help-block">
                                  {{ trans('admin/users/general.send_email_help') }}
                              </p>


                          </div>
                      </div> <!--/form-group-->
                  @endif
                  <!-- Image -->
                  @if ($user->avatar)
                      <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
                          <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
                          <div class="col-md-5">
                              {{ Form::checkbox('image_delete') }}
                              <img src="{{ Storage::disk('public')->url(app('users_upload_path').e($user->avatar)) }}" class="img-responsive" />
                              {!! $errors->first('image_delete', '<span class="alert-msg"><br>:message</span>') !!}
                          </div>
                      </div>
                  @endif

                  @include ('partials.forms.edit.image-upload', ['fieldname' => 'avatar'])

                  <!-- begin optional disclosure arrow stuff -->
                  <div class="form-group">
                      <label class="col-md-3 control-label"></label>

                      <div class="col-md-9 col-sm-9 col-md-offset-3">

                          <a id="optional_user_info" class="text-primary">
                              <i class="fa fa-caret-right fa-2x" id="optional_user_info_icon"></i>
                              <strong>{{ trans('admin/hardware/form.optional_infos') }}</strong>
                          </a>

                      </div>

                      <div id="optional_user_details" class="col-md-12" style="display:none">
                          <!-- everything here should be what is considered optional -->
                          <br>
                          <!-- Company -->
                          @if (\App\Models\Company::canManageUsersCompanies())
                              @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.select_company'), 'fieldname' => 'company_id'])
                          @endif


                          <!-- language -->
                          <div class="form-group {{ $errors->has('locale') ? 'has-error' : '' }}">
                              <label class="col-md-3 control-label" for="locale">{{ trans('general.language') }}</label>
                              <div class="col-md-9">
                                  {!! Form::locales('locale', old('locale', $user->locale), 'select2') !!}
                                  {!! $errors->first('locale', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                              </div>
                          </div>

                          <!-- Employee Number -->
                          <div class="form-group {{ $errors->has('employee_num') ? 'has-error' : '' }}">
                              <label class="col-md-3 control-label" for="employee_num">{{ trans('general.employee_number') }}</label>
                              <div class="col-md-6">
                                  <input
                                          class="form-control"
                                          type="text"
                                          aria-label="employee_num"
                                          name="employee_num"
                                          maxlength="191"
                                          id="employee_num"
                                          value="{{ Request::old('employee_num', $user->employee_num) }}"
                                  />
                                  {!! $errors->first('employee_num', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                              </div>
                          </div>


                          <!-- Jobtitle -->
                          <div class="form-group {{ $errors->has('jobtitle') ? 'has-error' : '' }}">
                              <label class="col-md-3 control-label" for="jobtitle">{{ trans('admin/users/table.title') }}</label>
                              <div class="col-md-6">
                                  <input
                                          class="form-control"
                                          type="text"
                                          maxlength="191"
                                          name="jobtitle"
                                          id="jobtitle"
                                          value="{{ Request::old('jobtitle', $user->jobtitle) }}"
                                  />
                                  {!! $errors->first('jobtitle', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                              </div>
                          </div>


                          <!-- Manager -->
                          @include ('partials.forms.edit.user-select', ['translated_name' => trans('admin/users/table.manager'), 'fieldname' => 'manager_id'])

                          <!--  Department -->
                          @include ('partials.forms.edit.department-select', ['translated_name' => trans('general.department'), 'fieldname' => 'department_id'])

                          @include ('partials.forms.edit.datepicker', ['translated_name' => trans('general.start_date'), 'fieldname' => 'start_date', 'item' => $user])

                          @include ('partials.forms.edit.datepicker', ['translated_name' => trans('general.end_date'), 'fieldname' => 'end_date', 'item' => $user])


                          <!-- remote checkbox -->
                          <div class="form-group">
                              <div class="col-md-7 col-md-offset-3">
                                  <label for="remote">
                                      <input type="checkbox" value="1" name="remote" class="minimal" {{ (old('remote', $user->remote)) == '1' ? ' checked="checked"' : '' }} aria-label="remote">
                                      {{ trans('admin/users/general.remote_label') }}

                                  </label>
                                  <p class="help-block">{{ trans('admin/users/general.remote_help') }}
                                  </p>
                              </div>
                          </div>

                          <!-- Location -->
                          @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])

                          <!-- Phone -->
                          <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                              <label class="col-md-3 control-label" for="phone">{{ trans('admin/users/table.phone') }}</label>
                              <div class="col-md-6">
                                  <input class="form-control" type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" maxlength="191" />
                                  {!! $errors->first('phone', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                              </div>
                          </div>

                          <!-- Website URL -->
                          <div class="form-group {{ $errors->has('website') ? ' has-error' : '' }}">
                              <label for="website" class="col-md-3 control-label">{{ trans('general.website') }}</label>
                              <div class="col-md-6">
                                  <input class="form-control" type="text" name="website" id="website" value="{{ old('website', $user->website) }}" maxlength="191" />
                                  {!! $errors->first('website', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                              </div>
                          </div>

                          <!-- Address -->
                          <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                              <label class="col-md-3 control-label" for="address">{{ trans('general.address') }}</label>
                              <div class="col-md-6">
                                  <input class="form-control" type="text" name="address" id="address" value="{{ old('address', $user->address) }}" maxlength="191" />
                                  {!! $errors->first('address', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                              </div>
                          </div>

                          <!-- City -->
                          <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                              <label class="col-md-3 control-label" for="city">{{ trans('general.city') }}</label>
                              <div class="col-md-6">
                                  <input class="form-control" type="text" name="city" id="city" aria-label="city" value="{{ old('city', $user->city) }}" maxlength="191" />
                                  {!! $errors->first('city', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                              </div>
                          </div>

                          <!-- State -->
                          <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                              <label class="col-md-3 control-label" for="state">{{ trans('general.state') }}</label>
                              <div class="col-md-6">
                                  <input class="form-control" type="text" name="state" id="state" value="{{ old('state', $user->state) }}" maxlength="3" />
                                  {!! $errors->first('state', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                              </div>
                          </div>

                          <!-- Country -->
                          <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                              <label class="col-md-3 control-label" for="country">{{ trans('general.country') }}</label>
                              <div class="col-md-6">
                                  {!! Form::countries('country', old('country', $user->country), 'col-md-6 select2') !!}
                                  {!! $errors->first('country', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                              </div>
                          </div>

                          <!-- Zip -->
                          <div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
                              <label class="col-md-3 control-label" for="zip">{{ trans('general.zip') }}</label>
                              <div class="col-md-3">
                                  <input class="form-control" type="text" name="zip" id="zip" value="{{ old('zip', $user->zip) }}" maxlength="10" />
                                  {!! $errors->first('zip', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                              </div>
                          </div>

                          <!-- Notes -->
                          <div class="form-group{!! $errors->has('notes') ? ' has-error' : '' !!}">
                              <label for="notes" class="col-md-3 control-label">{{ trans('admin/users/table.notes') }}</label>
                              <div class="col-md-6">
                                  <textarea class="form-control" rows="5" id="notes" name="notes">{{ old('notes', $user->notes) }}</textarea>
                                  {!! $errors->first('notes', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
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
                                                  {{ Form::checkbox('two_factor_optin', '1', Request::old('two_factor_optin', $user->two_factor_optin),['class' => 'minimal', 'disabled'=>'disabled']) }} {{ trans('admin/settings/general.two_factor_enabled_text') }}
                                                  <p class="help-block">{{ trans('general.feature_disabled') }}</p>
                                              </div>
                                          @else
                                              {{ Form::checkbox('two_factor_optin', '1', Request::old('two_factor_optin', $user->two_factor_optin),['class' => 'minimal']) }} {{ trans('admin/settings/general.two_factor_enabled_text') }}
                                              <p class="help-block">{{ trans('admin/users/general.two_factor_admin_optin_help') }}</p>

                                          @endif

                                      </div>
                                  </div>
                              @endif

                              <!-- Reset Two Factor -->
                              <div class="form-group">
                                  <div class="col-md-8 col-md-offset-3 two_factor_resetrow">
                                      <a class="btn btn-default btn-sm pull-left" id="two_factor_reset" style="margin-right: 10px;"> {{ trans('admin/settings/general.two_factor_reset') }}</a>
                                      <span id="two_factor_reseticon"></span>
                                      <span id="two_factor_resetresult"></span>
                                      <span id="two_factor_resetstatus"></span>
                                  </div>
                                  <div class="col-md-8 col-md-offset-3 two_factor_resetrow">
                                      <p class="help-block">{{ trans('admin/settings/general.two_factor_reset_help') }}</p>
                                  </div>
                              </div>
                          @endif

                          <!-- Groups -->
                          <div class="form-group{{ $errors->has('groups') ? ' has-error' : '' }}">
                              <label class="col-md-3 control-label" for="groups[]"> {{ trans('general.groups') }}</label>
                              <div class="col-md-6">

                                  @if ($groups->count())
                                      @if ((Config::get('app.lock_passwords') || (!Auth::user()->isSuperUser())))

                                          @if (count($userGroups->keys()) > 0)
                                              <ul>
                                                  @foreach ($groups as $id => $group)
                                                      {!! ($userGroups->keys()->contains($id) ? '<li>'.e($group).'</li>' : '') !!}
                                                  @endforeach
                                              </ul>
                                          @endif

                                          <span class="help-block">{{ trans('admin/users/general.group_memberships_helpblock') }}</p>
                                  @else
                                   <div class="controls">
                                    <select
                                            name="groups[]"
                                            aria-label="groups[]"
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
                           @else
                               <p>No groups have been created yet. Visit <code>Admin Settings > Permission Groups</code> to add one.</p>
                           @endif

                              </div>
                          </div>
                      </div>
                  </div>





              </div> <!--/col-md-12-->
            </div>
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="permissions">
            <div class="col-md-12">
              @if (!Auth::user()->isSuperUser())
                <p class="alert alert-warning">{{ trans('admin/users/general.superadmin_permission_warning') }}</p>
              @endif

              @if (!Auth::user()->hasAccess('admin'))
                <p class="alert alert-warning">{{ trans('admin/users/general.admin_permission_warning') }}</p>
              @endif
            </div>

            <table class="table table-striped permissions">
              <thead>
                <tr class="permissions-row">
                  <th class="col-md-5">{{ trans('admin/groups/titles.permission') }}</th>
                  <th class="col-md-1">{{ trans('admin/groups/titles.grant') }}</th>
                  <th class="col-md-1">{{ trans('admin/groups/titles.deny') }}</th>
                  <th class="col-md-1">{{ trans('admin/users/table.inherit') }}</th>
                </tr>
              </thead>
                @include('partials.forms.edit.permissions-base')
            </table>
          </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
        <div class="box-footer text-right">
          <button type="submit" accesskey="s" class="btn btn-primary"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
        </div>
      </div><!-- nav-tabs-custom -->
    </form>
  </div> <!--/col-md-8-->
</div><!--/row-->
@stop

@section('moar_scripts')

<script nonce="{{ csrf_token() }}">
$(document).ready(function() {

    $('#activated').on('ifChecked', function(event){
        console.log('user activated is checked');
        $("#email_user_row").show();
	});

    $('#activated').on('ifUnchecked', function(event){
        $("#email_user_row").hide();
    });

    $('#email').on('keyup',function(){
        event.preventDefault();

        if(this.value.length > 5){
            $('#email_user_checkbox').iCheck('enable');
        } else {
            $('#email_user_checkbox').iCheck('disable').iCheck('uncheck');
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

    $("#optional_user_info").on("click",function(){
        $('#optional_user_details').fadeToggle(100);
        $('#optional_user_info_icon').toggleClass('fa-caret-right fa-caret-down');
        var optional_user_info_open = $('#optional_user_info_icon').hasClass('fa-caret-down');
        document.cookie = "optional_user_info_open="+optional_user_info_open+'; path=/';
    });

    var all_cookies = document.cookie.split(';')
    for(var i in all_cookies) {
        var trimmed_cookie = all_cookies[i].trim(' ')
        if (trimmed_cookie.startsWith('optional_user_info_open=')) {
            elems = all_cookies[i].split('=', 2)
            if (elems[1] == 'true') {
                $('#optional_user_info').trigger('click')
            }
        }
    }

    $("#two_factor_reset").click(function(){
        $("#two_factor_resetrow").removeClass('success');
        $("#two_factor_resetrow").removeClass('danger');
        $("#two_factor_resetstatus").html('');
        $("#two_factor_reseticon").html('<i class="fas fa-spinner spin"></i>');
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
                $("#two_factor_resetstatus").html('<i class="fas fa-check text-success"></i>' + data.message);
            },

            error: function (data) {
                $("#two_factor_reseticon").html('');
                $("#two_factor_reseticon").html('<i class="fas fa-exclamation-triangle text-danger"></i>');
                $('#two_factor_resetstatus').text(data.message);
            }


        });
    });


});
</script>


@stop
