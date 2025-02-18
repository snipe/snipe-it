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
      <form class="form-horizontal" method="post" autocomplete="off"
            action="{{ (isset($user->id)) ? route('users.update', ['user' => $user->id]) : route('users.store') }}"
            enctype="multipart/form-data" id="userForm">
      {{csrf_field()}}

      @if($user->id)
          {{ method_field('PUT') }}
      @endif
        <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#info" data-toggle="tab">{{ trans('general.information') }} </a></li>
          <li><a href="#permissions" data-toggle="tab">{{ trans('general.permissions') }} </a></li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="info">
            <div class="row">
              <div class="col-md-12">
                <!-- First Name -->
                 @include('partials.forms.edit.name-first')

                <!-- Last Name -->
                @include('partials.forms.edit.name-last')

                <!-- Username -->
                <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="username">{{ trans('admin/users/table.username') }}</label>

                  <div class="col-md-6">
                    @if ($user->ldap_import!='1' || str_contains(Route::currentRouteName(), 'clone'))
                      <input
                        class="form-control"
                        type="text"
                        name="username"
                        id="username"
                        value="{{ old('username', $user->username) }}"
                        autocomplete="off"
                        maxlength="191"
                        readonly
                        {{  (Helper::checkIfRequired($user, 'username')) ? ' required' : '' }}
                        onfocus="this.removeAttribute('readonly');"
                        {{ ((config('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}
                      >

                    @else
                        <!-- insert the old username so we don't break validation -->
                         {{ trans('general.managed_ldap') }}
                          <input type="hidden" name="username" value="{{ old('username', $user->username) }}">
                    @endif
                  </div>


                    @if (config('app.lock_passwords') && ($user->id))
                        <!-- disallow changing existing usernames on the demo -->
                        <div class="col-md-8 col-md-offset-3">
                            <p class="text-warning"><x-icon type="lock" /> {{ trans('general.feature_disabled') }}</p>
                        </div>
                    @endif

                    @if ($errors->first('username'))
                        <div class="col-md-8 col-md-offset-3">
                            {!! $errors->first('username', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                        </div>
                    @endif

                </div>

                <!-- Password -->
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="password">
                    {{ trans('admin/users/table.password') }}
                  </label>
                  <div class="col-md-6">
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
                        {{  ((Helper::checkIfRequired($user, 'password')) && (!$user->id)) ? ' required' : '' }}
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
                  <div class="col-md-6">
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
                    {{  (!$user->id) ? ' required' : '' }}
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

              <!-- Activation Status (Can the user login?) -->
                  <div class="form-group {{ $errors->has('activated') ? 'has-error' : '' }}">
                          <div class="col-md-9 col-md-offset-3">

                              <!-- checkbox($name, $value = 1, $checked = null, $options = array() -->
                              @if (config('app.lock_passwords'))
                                  <!-- demo mode - disallow changes -->
                                  <label class="form-control form-control--disabled">
                                      <input type="checkbox" value="1" name="activated" class="disabled" {{ (old('activated', $user->activated)) == '1' ? ' checked="checked"' : '' }} disabled="disabled" aria-label="activated">
                                      {{ trans('admin/users/general.activated_help_text') }}

                                  </label>
                                  <p class="text-warning"><x-icon type="lock" /> {{ trans('general.feature_disabled') }}</p>

                              @elseif ($user->id === Auth::user()->id)
                                  <!-- disallow the user from editing their own login status -->
                                  <label class="form-control form-control--disabled">
                                      {{ Form::checkbox('activated', '1', old('activated', $user->activated), ['disabled' => true, 'checked'=> 'checked', 'aria-label'=>'update_real_loc']) }}
                                      {{ trans('admin/users/general.activated_help_text') }}
                                  </label>
                                  <p class="text-warning">{{ trans('admin/users/general.activated_disabled_help_text') }}</p>
                              @else
                                  <!-- everything is normal - as you were -->
                                  <label class="form-control">
                                      <input type="checkbox" value="1" name="activated"{{ ((old('activated') == '1') || ($user->activated) == '1') ? ' checked="checked"' : '' }} aria-label="activated" id="activated">
                                      {{ trans('admin/users/general.activated_help_text') }}
                                  </label>
                              @endif

                          </div>
                  </div>

                  <!-- Email -->
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="email">{{ trans('admin/users/table.email') }} </label>
                  <div class="col-md-6">
                    <input
                      class="form-control"
                      type="text"
                      name="email"
                      id="email"
                      maxlength="191"
                      value="{{ old('email', $user->email) }}"
                      {{ ((config('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}
                      autocomplete="off"
                      readonly
                      {{  (Helper::checkIfRequired($user, 'email')) ? ' required' : '' }}
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

                          <div class="col-md-8 col-md-offset-3">
                              <label class="form-control form-control--disabled">

                                  {{ Form::checkbox('email_user', '1', old('email_user'), ['id' => "email_user_checkbox", 'aria-label'=>'email_user']) }}

                                  {{ trans('admin/users/general.email_user_creds_on_create') }}
                              </label>

                              <p class="help-block"> {{ trans('admin/users/general.send_email_help') }}</p>

                          </div>
                      </div> <!--/form-group-->
                  @endif

                  @include ('partials.forms.edit.image-upload', ['fieldname' => 'avatar', 'image_path' => app('users_upload_path')])

                  {{-- FIXME - copypasta from hardware/edit.blade.php <start> --}}
                  <div id='custom_fields_content'>
                      <!-- Custom Fields -->
                      @if ($user->getFieldset())
                          @include("models/custom_fields_form",["item" => $user])
                      @endif
                  </div>
                  {{-- FIXME - copypasts from hardware/edit.blade.php <end> --}}


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
                              <div class="col-md-6">
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
                                          value="{{ old('employee_num', $user->employee_num) }}"
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
                                          value="{{ old('jobtitle', $user->jobtitle) }}"
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

                          <!-- VIP checkbox -->

                          <div class="form-group">
                              <div class="col-md-7 col-md-offset-3">

                                  <label class="form-control" for="vip">
                                      <input type="checkbox" value="1" name="vip" {{ (old('vip', $user->vip)) == '1' ? ' checked="checked"' : '' }} aria-label="vip">
                                      {{ trans('admin/users/general.vip_label') }}
                                  </label>

                                  <p class="help-block">{{ trans('admin/users/general.vip_help') }}</p>
                              </div>
                          </div>

                          <!-- Auto assign checkbox -->

                          <div class="form-group">
                              <div class="col-md-7 col-md-offset-3">

                                  <label class="form-control" for="autoassign_licenses">
                                      <input type="checkbox" value="1" name="autoassign_licenses" {{ (old('autoassign_licenses', $user->autoassign_licenses)) == '1' ? " checked='checked'" : '' }} aria-label="autoassign_licenses">
                                      {{ trans('general.autoassign_licenses') }}
                                  </label>

                                  <p class="help-block">{{ trans('general.autoassign_licenses_help_long') }}</p>
                              </div>
                          </div>


                          <!-- remote checkbox -->
                          <div class="form-group">
                              <div class="col-md-7 col-md-offset-3">
                                  <label for="remote" class="form-control">
                                      <input type="checkbox" value="1" name="remote" {{ (old('remote', $user->remote)) == '1' ? ' checked="checked"' : '' }} aria-label="remote">
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
                                  <input class="form-control" type="text" name="state" id="state" value="{{ old('state', $user->state) }}" maxlength="191" />
                                  {!! $errors->first('state', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                              </div>
                          </div>

                          <!-- Country -->
                          <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                              <label class="col-md-3 control-label" for="country">{{ trans('general.country') }}</label>
                              <div class="col-md-6">
                                  {!! Form::countries('country', old('country', $user->country), 'col-md-12 select2') !!}

                                  <p class="help-block">{{ trans('general.countries_manually_entered_help') }}</p>
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
                                      <div class="col-md-9 col-md-offset-3">

                                          @if (config('app.lock_passwords'))

                                              <label class="form-control form-control--disabled" for="two_factor_optin">
                                                  <input type="checkbox" value="1" name="two_factor_optin" {{ (old('two_factor_optin', $user->two_factor_optin)) == '1' ? ' checked="checked"' : '' }} aria-label="two_factor_optin" disabled>
                                                  {{ trans('admin/settings/general.two_factor') }}
                                              </label>

                                          @else

                                              <label class="form-control" for="two_factor_optin">
                                                  <input type="checkbox" value="1" name="two_factor_optin" {{ (old('two_factor_optin', $user->two_factor_optin)) == '1' ? ' checked="checked"' : '' }} aria-label="two_factor_optin">
                                                  {{ trans('admin/settings/general.two_factor') }}
                                              </label>
                                              <p class="help-block">{{ trans('admin/users/general.two_factor_admin_optin_help') }}</p>

                                          @endif

                                      </div>
                                  </div>
                              @endif

                              @if ((Auth::user()->isSuperUser()) && ($user->two_factor_active_and_enrolled()) && ($snipeSettings->two_factor_enabled!='0') && ($snipeSettings->two_factor_enabled!=''))
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

                                          <span class="help-block">{{ trans('admin/users/general.group_memberships_helpblock') }}</span>
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
                                      <p>{{ trans('admin/users/table.nogroup') }} <code>{{ trans('admin/settings/general.admin_settings') }} <i class="fa fa-cogs"></i> > {{ trans('general.groups') }} <i class="fas fa-user-friends"></i></code> </p>
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
          <x-redirect_submit_options
                  index_route="users.index"
                  :button_label="trans('general.save')"
                  :options="[
                        'index' => trans('admin/hardware/form.redirect_to_all', ['type' => 'users']),
                        'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.user')]),
                        ]"
          />
      </div><!-- nav-tabs-custom -->
    </form>
  </div> <!--/col-md-8-->
</div><!--/row-->
@stop

@section('moar_scripts')

<script nonce="{{ csrf_token() }}">

$(document).ready(function() {


    // If the "user can login" check box is checked, show them the ability to email the user credentials
    $("#activated").change(function() {
        if (this.checked) {
            $("#email_user_row").show();
        } else {
            $("#email_user_row").hide();
        }
    });


    // Set some defaults
    $('#email_user_checkbox').prop("disabled", true);
    $('#email_user_checkbox').prop("checked", false);
    $("#email_user_checkbox").removeAttr('checked');

    // If the email address is longer than 5 characters, enable the "send email" checkbox
    $('#email').on('keyup',function(){
        //event.preventDefault();

        @if (!config('app.lock_passwords'))

        if (this.value.length > 5){
            console.log('email field is ' + this.value.length + ' - enable the checkbox');
            $('#email_user_checkbox').prop("disabled", false);
            $("#email_user_checkbox").parent().removeClass("form-control--disabled");
        } else {
            console.log('email field is ' + this.value.length + ' - DISABLE the checkbox');
            $('#email_user_checkbox').prop("disabled", true);
            $('#email_user_checkbox').prop("checked", false);
            $("#email_user_checkbox").parent().addClass("form-control--disabled");
        }

        @endif
    });


	// Check/Uncheck all radio buttons in the group
    $('tr.header-row input:radio').change(function() {
        value = $(this).attr('value');
        area = $(this).data('checker-group');
        $('.radiochecker-'+area+'[value='+value+']').prop('checked', true);
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
        'passwordLength': {{ ($settings->pwd_secure_min + 5) }},
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
        $("#two_factor_reseticon").html('<i class="fas fa-spinner spin"></i> ');
        $.ajax({
            url: '{{ route('api.users.two_factor_reset', ['id'=> $user->id]) }}',
            type: 'POST',
            data: {},
            headers: {
                "X-Requested-With": 'XMLHttpRequest',
                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') // TODO` - we should do this in ajaxSetup
            },
            dataType: 'json',

            success: function (data) {
                $("#two_factor_reseticon").html('');
                $("#two_factor_resetstatus").html('<span class="text-success"><i class="fas fa-check"></i> ' + data.message + '</span>');
            },

            error: function (data) {
                $("#two_factor_reseticon").html('');
                $("#two_factor_resetstatus").html('<span class="text-danger"><i class="fas fa-exclamation-triangle text-danger"></i> ' + data.message + '</span>');
            }


        });
    });


});
</script>


@stop
