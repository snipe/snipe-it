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
      margin: 15px;
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
    table, tbody {
      border: 1px solid #ccc;
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
                        {{ ((config('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}
                      >
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
                      onfocus="this.removeAttribute('readonly');"
                    >
                    @if (config('app.lock_passwords') && ($user->id))
                    <p class="help-block">{{ trans('admin/users/table.lock_passwords') }}</p>
                    @endif
                    {!! $errors->first('email', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Company -->
                @if (\App\Models\Company::canManageUsersCompanies())
                <!-- Company -->
                <div class="form-group {{ $errors->has('company_id') ? 'has-error' : '' }}">
                  <div class="col-md-3 control-label">
                    {{ Form::label('company_id', trans('general.company')) }}
                  </div>
                  <div class="col-md-8">
                    {{ Form::select('company_id', $company_list , Input::old('company_id', $user->company_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                    {!! $errors->first('company_id', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>
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
                <div class="form-group {{ $errors->has('manager_id') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="manager_id">{{ trans('admin/users/table.manager') }}</label>
                  <div class="col-md-8">
                    {{ Form::select('manager_id', $manager_list , Input::old('manager_id', $user->manager_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                    {!! $errors->first('manager_id', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                  <!--  Department -->
                  <div class="form-group {{ $errors->has('department_id') ? ' has-error' : '' }}">
                      <label for="status_id" class="col-md-3 control-label">
                          {{ trans('general.department') }}
                      </label>
                      <div class="col-md-7">
                          {{ Form::select('department_id', $department_list , Input::old('department_id', $user->department_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                          {!! $errors->first('department_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                      </div>
                  </div>


                  <!-- Location -->
                <div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="location_id">{{ trans('admin/users/table.location') }}
                  </label>
                  <div class="col-md-8">
                    {{ Form::select('location_id', $location_list , Input::old('location_id', $user->location_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                    {!! $errors->first('location_id', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Phone -->
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="phone">{{ trans('admin/users/table.phone') }}</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text" name="phone" id="phone" value="{{ Input::old('phone', $user->phone) }}" />
                    {!! $errors->first('phone', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Activation Status -->
                <div class="form-group {{ $errors->has('activated') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="activated">{{ trans('admin/users/table.activated') }}</label>
                  <div class="col-md-8">
                    <div class="controls">
                      <select
                        {{ ($user->id === Auth::user()->id ? ' disabled="disabled"' : '') }}
                        name="activated"
                        id="activated"
                        {{ ((config('app.lock_passwords') && ($user->id)) ? ' disabled' : '') }}
                      >
                        @if ($user->id)
                        <option value="1"{{ ($user->isActivated() ? ' selected="selected"' : '') }}>{{ trans('general.yes') }}</option>
                        <option value="0"{{ ( ! $user->isActivated() ? ' selected="selected"' : '') }}>{{ trans('general.no') }}</option>
                        @else
                        <option value="1"{{ (Input::old('activated') == 1 ? ' selected="selected"' : '') }}>{{ trans('general.yes') }}</option>
                        <option value="0">{{ trans('general.no') }}</option>
                        @endif
                      </select>
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
                      {{ Form::checkbox('two_factor_optin', '1', Input::old('two_factor_optin', $user->two_factor_optin),array('class' => 'minimal')) }}
                      {{ trans('admin/settings/general.two_factor_enabled_text') }}

                      <p class="help-block">{{ trans('admin/users/general.two_factor_admin_optin_help') }}</p>
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
                  <th class="col-md-5"><span class="line"></span>Permission</th>
                  <th class="col-md-1"><span class="line"></span>Grant</th>
                  <th class="col-md-1"><span class="line"></span>Deny</th>
                  <th class="col-md-1"><span class="line"></span>Inherit</th>
                </tr>
              </thead>

              @foreach ($permissions as $area => $permissionsArray)
              @if (count($permissionsArray) == 1)
              <tbody class="permissions-group">
                <?php $localPermission = $permissionsArray[0]; ?>
                <tr class="header-row permissions-row">
                  <td class="col-md-5 tooltip-base permissions-item"
                    data-toggle="tooltip"
                    data-placement="right"
                    title="{{ $localPermission['note'] }}"
                  >
                    <h4>{{ $area . ': ' . $localPermission['label'] }}</h4>
                  </td>

                  <td class="col-md-1 permissions-item">
                    @if (($localPermission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
                      {{ Form::radio('permission['.$localPermission['permission'].']', '1',$userPermissions[$localPermission['permission'] ] == '1',['disabled'=>"disabled"]) }}
                    @else
                      {{ Form::radio('permission['.$localPermission['permission'].']', '1',$userPermissions[$localPermission['permission'] ] == '1',['value'=>"grant"]) }}
                    @endif
                  </td>
                  <td class="col-md-1 permissions-item">
                    @if (($localPermission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
                      {{ Form::radio('permission['.$localPermission['permission'].']', '-1',$userPermissions[$localPermission['permission'] ] == '-1',['disabled'=>"disabled"]) }}
                    @else
                      {{ Form::radio('permission['.$localPermission['permission'].']', '-1',$userPermissions[$localPermission['permission'] ] == '-1',['value'=>"deny"]) }}
                    @endif
                  </td>
                  <td class="col-md-1 permissions-item">
                    @if (($localPermission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
                      {{ Form::radio('permission['.$localPermission['permission'].']','0',$userPermissions[$localPermission['permission'] ] == '0',['disabled'=>"disabled"] ) }}
                    @else
                      {{ Form::radio('permission['.$localPermission['permission'].']','0',$userPermissions[$localPermission['permission'] ] == '0',['value'=>"inherit"] ) }}
                    @endif
                  </td>
                </tr>
              </tbody>
              @else
              <tbody class="permissions-group">
                <tr class="header-row permissions-row">
                  <td class="col-md-5 header-name">
                    <h3>{{ $area }}</h3>
                  </td>
                  <td class="col-md-1 permissions-item">
                    {{ Form::radio("$area", '1',false,['value'=>"grant"]) }}
                  </td>
                  <td class="col-md-1 permissions-item">
                    {{ Form::radio("$area", '-1',false,['value'=>"deny"]) }}
                  </td>
                  <td class="col-md-1 permissions-item">
                    {{ Form::radio("$area", '0',false,['value'=>"inherit"] ) }}
                  </td>
                </tr>

                @foreach ($permissionsArray as $index => $permission)
                <tr class="permissions-row">
                  @if ($permission['display'])
                    <td
                      class="col-md-5 tooltip-base permissions-item"
                      data-toggle="tooltip"
                      data-placement="right"
                      title="{{ $permission['note'] }}"
                    >
                      {{ $permission['label'] }}
                    </td>
                    <td class="col-md-1 permissions-item">
                      @if (($permission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
                      {{ Form::radio('permission['.$permission['permission'].']', '1', $userPermissions[$permission['permission'] ] == '1', ["value"=>"grant", 'disabled'=>'disabled']) }}
                      @else
                      {{ Form::radio('permission['.$permission['permission'].']', '1', $userPermissions[ $permission['permission'] ] == '1', ["value"=>"grant"]) }}
                      @endif
                    </td>
                    <td class="col-md-1 permissions-item">
                      @if (($permission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
                      {{ Form::radio('permission['.$permission['permission'].']', '-1', $userPermissions[$permission['permission'] ] == '-1', ["value"=>"deny", 'disabled'=>'disabled']) }}
                      @else
                      {{ Form::radio('permission['.$permission['permission'].']', '-1', $userPermissions[$permission['permission'] ] == '-1', ["value"=>"deny"]) }}
                      @endif
                    </td>
                    <td class="col-md-1 permissions-item">
                      @if (($permission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
                      {{ Form::radio('permission['.$permission['permission'].']', '0', $userPermissions[$permission['permission']] =='0', ["value"=>"inherit", 'disabled'=>'disabled']) }}
                      @else
                      {{ Form::radio('permission['.$permission['permission'].']', '0', $userPermissions[$permission['permission']] =='0', ["value"=>"inherit"]) }}
                      @endif
                    </td>
                  @endif
                </tr>
                @endforeach
              </tbody>
              @endif
              @endforeach
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
});
</script>

<script nonce="{{ csrf_token() }}">
$('tr.header-row input:radio').click(function() {
  value = $(this).attr('value');
  $(this).parent().parent().siblings().each(function() {
    $(this).find('td input:radio[value='+value+']').prop("checked", true);
  })
});

$('.header-name').click(function() {
  $(this).parent().nextUntil('tr.header-row').slideToggle(500);
})
</script>

<script src="{{ asset('js/pGenerator.jquery.js') }}"></script>

<script nonce="{{ csrf_token() }}">


$(document).ready(function(){

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



</script>
@stop
