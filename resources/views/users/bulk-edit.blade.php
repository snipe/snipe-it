@extends('layouts/default')
{{-- Page title --}}
@section('title')
    {{ trans('general.bulk_edit') }}
    @parent
@stop


@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')

    <style>
        .radio {
            margin-left: -20px;
        }
    </style>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <p>{{ trans('admin/users/general.bulk_update_help') }}</p>

            <div class="callout callout-warning">
                <i class="fas fa-exclamation-triangle"></i> {{ trans('admin/users/general.bulk_update_warn', ['user_count' => count($users)]) }}
            </div>

            <form class="form-horizontal" method="post" action="{{ route('users/bulkeditsave') }}" autocomplete="off" role="form">
                {{ csrf_field() }}

                <div class="box box-default">
                    <div class="box-body">


                        <!--  Department -->
                        @include ('partials.forms.edit.department-select', ['translated_name' => trans('general.department'), 'fieldname' => 'department_id'])


                        <div class="form-group">
                            <div class=" col-md-9 col-md-offset-3">
                                <label class="form-control">
                                    {{ Form::checkbox('null_department_id', '1', false) }}
                                    {{ trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.department'), 'user_count' => count($users)]) }}
                                </label>
                            </div>
                        </div>


                        <!-- Location -->
                        @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])

                        <div class="form-group">
                            <div class=" col-md-9 col-md-offset-3">
                                <label class="form-control">
                                    {{ Form::checkbox('null_location_id', '1', false) }}
                                    {{ trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.location'), 'user_count' => count($users)]) }}
                                </label>
                            </div>
                        </div>


                        <!-- Company -->
                        @if (\App\Models\Company::canManageUsersCompanies())
                            @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.select_company'), 'fieldname' => 'company_id'])

                            <div class="form-group">
                                <div class=" col-md-9 col-md-offset-3">
                                    <label class="form-control">
                                        {{ Form::checkbox('null_company_id', '1', false) }}
                                        {{ trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.company'), 'user_count' => count($users)]) }}
                                    </label>
                                </div>
                            </div>

                        @endif

                        <!-- Manager -->
                    @include ('partials.forms.edit.user-select', ['translated_name' => trans('admin/users/table.manager'), 'fieldname' => 'manager_id'])

                        <div class="form-group">
                            <div class=" col-md-9 col-md-offset-3">
                                <label class="form-control">
                                    {{ Form::checkbox('null_manager_id', '1', false) }}
                                    {{ trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('admin/users/table.manager'), 'user_count' => count($users)]) }}
                                </label>
                            </div>
                        </div>


                        <!-- Language -->
                        <div class="form-group {{ $errors->has('locale') ? 'has-error' : '' }}">
                            <label class="col-md-3 control-label" for="locale">{{ trans('general.language') }}</label>
                            <div class="col-md-8">
                                {!! Form::locales('locale', old('locale', ''), 'select2') !!}
                                {!! $errors->first('locale', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class=" col-md-9 col-md-offset-3">
                                <label class="form-control">
                                    {{ Form::checkbox('null_locale', '1', false) }}
                                    {{ trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.language'), 'user_count' => count($users)]) }}
                                </label>
                            </div>
                        </div>

                        <!-- City -->
                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="city">{{ trans('general.city') }}</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" name="city" id="city" aria-label="city" />
                                {!! $errors->first('city', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                         <!-- remote -->
                         <div class="form-group">
                            <div class="col-sm-3 control-label">
                                {{ trans('admin/users/general.remote') }}
                            </div>
                            <div class="col-sm-9">

                                    <label for="no_change" class="form-control">
                                        {{ Form::radio('remote', '', true, ['id' => 'no_change', 'aria-label'=>'no_change']) }}
                                        {{  trans('general.do_not_change') }}
                                    </label>
                                    <label for="remote" class="form-control">
                                        {{ Form::radio('remote', '1', old('remote'), ['id' => 'remote', 'aria-label'=>'remote']) }}
                                        {{ trans('admin/users/general.remote_label') }}
                                    </label>
                                    <label for="not_remote" class="form-control">
                                        {{ Form::radio('remote', '0', old('remote'), ['id' => 'not_remote', 'aria-label'=>'not_remote']) }}
                                        {{ trans('admin/users/general.not_remote_label') }}
                                    </label>


                            </div>
                        </div> <!--/form-group-->

                        <!-- ldap_sync -->
                        <div class="form-group">
                            <div class="col-sm-3 control-label">
                                {{ trans('general.ldap_sync') }}
                            </div>
                            <div class="col-sm-9">
                                    <label for="no_change" class="form-control">
                                        {{ Form::radio('ldap_import', '', true, ['id' => 'no_change', 'aria-label'=>'ldap_import']) }}
                                        {{  trans('general.do_not_change') }}
                                    </label>
                                    <label for="ldap_import" class="form-control">
                                        {{ Form::radio('ldap_import', '0', old('ldap_import'), ['id' => 'ldap_import', 'aria-label'=>'ldap_import']) }}
                                        {{ trans('general.ldap_import') }}
                                    </label>
                            </div>
                        </div> <!--/form-group-->

                        <!-- activated -->
                        <div class="form-group">
                            <div class="col-sm-3 control-label">
                                {{ trans('general.autoassign_licenses') }}
                            </div>
                            <div class="col-sm-9">

                                <label for="no_change_autoassign_licenses" class="form-control">
                                    {{ Form::radio('autoassign_licenses', '', true, ['id' => 'no_change_autoassign_licenses', 'aria-label'=>'no_change_autoassign_licenses']) }}
                                    {{  trans('general.do_not_change') }}
                                </label>
                                <label for="autoassign_licenses" class="form-control">
                                    {{ Form::radio('autoassign_licenses', '1', old('autoassign_licenses'), ['id' => 'autoassign_licenses', 'aria-label'=>'autoassign_licenses']) }}
                                    {{  trans('general.autoassign_licenses_help')}}
                                </label>
                                <label for="dont_autoassign_licenses" class="form-control">
                                    {{ Form::radio('autoassign_licenses', '0', old('autoassign_licenses'), ['id' => 'dont_autoassign_licenses', 'aria-label'=>'dont_autoassign_licenses']) }}
                                    {{  trans('general.no_autoassign_licenses_help')}}
                                </label>

                            </div>
                        </div> <!--/form-group-->

                        <!-- activated -->
                        <div class="form-group">
                            <div class="col-sm-3 control-label">
                                {{ trans('general.login_enabled') }}
                            </div>
                            <div class="col-sm-9">

                                    <label for="no_change" class="form-control">
                                        {{ Form::radio('activated', '', true, ['id' => 'no_change', 'aria-label'=>'no_change']) }}
                                        {{  trans('general.do_not_change') }}
                                    </label>
                                    <label for="activated" class="form-control">
                                        {{ Form::radio('activated', '1', old('activated'), ['id' => 'activated', 'aria-label'=>'activated']) }}
                                        {{  trans('admin/users/general.user_activated')}}
                                    </label>
                                    <label for="deactivated" class="form-control">
                                        {{ Form::radio('activated', '0', old('activated'), ['id' => 'deactivated', 'aria-label'=>'deactivated']) }}
                                        {{  trans('admin/users/general.user_deactivated')}}
                                    </label>

                            </div>
                        </div> <!--/form-group-->


                        <!--  Groups -->
                        <div class="form-group{{ $errors->has('groups') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="groups"> {{ trans('general.groups') }}</label>
                            <div class="col-md-6">
                                @if ((config('app.lock_passwords') || (!Auth::user()->isSuperUser())))
                                    <span class="help-block">{{  trans('admin/users/general.group_memberships_helpblock') }}</p>
                                @else
                                    <div class="controls">
                                        <select name="groups[]" id="groups[]" multiple="multiple" class="form-control" aria-label="groups">
                                        <option value="">{{  trans('admin/users/general.remove_group_memberships') }} </option>

                                  @foreach ($groups as $id => $group)
                                        <option value="{{ $id }}">{{ $group }} </option>
                                    @endforeach
                        </select>

                        <span class="help-block">
                          {{ trans('admin/users/table.groupnotes') }}
                        </span>
                      </div> <!--/controls-->
                        @endif
                    </div> <!--/col-md-5-->
                    </div>


                        <!-- Start Date -->
                        <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
                            <label for="start_date" class="col-md-3 control-label">{{ trans('general.start_date') }}</label>
                            <div class="col-md-4">
                                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                                    <input type="text" class="form-control" placeholder="{{ trans('general.start_date') }}" name="start_date" id="start_date" value="{{ old('start_date') }}">
                                    <span class="input-group-addon"><x-icon type="calendar" /></span>
                                </div>
                                {!! $errors->first('start_date', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
                            </div>
                            <div class="col-md-5">
                                <label class="form-control">
                                    {{ Form::checkbox('null_start_date', '1', false) }}
                                    {{ trans_choice('general.set_to_null', count($users),['selection_count' => count($users)]) }}
                                </label>
                            </div>
                        </div>

                        <!-- End Date -->
                        <div class="form-group {{ $errors->has('end_date') ? ' has-error' : '' }}">
                            <label for="end_date" class="col-md-3 control-label">{{ trans('general.end_date') }}</label>
                            <div class="col-md-4">
                                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                                    <input type="text" class="form-control" placeholder="{{ trans('general.end_date') }}" name="end_date" id="end_date" value="{{ old('end_date') }}">
                                    <span class="input-group-addon"><x-icon type="calendar" /></span>
                                </div>
                                {!! $errors->first('end_date', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
                            </div>
                            <div class="col-md-5">
                                <label class="form-control">
                                    {{ Form::checkbox('null_end_date', '1', false) }}
                                    {{ trans_choice('general.set_to_null', count($users),['selection_count' => count($users)]) }}
                                </label>
                            </div>
                        </div>


                        @foreach ($users as $user)
                            <input type="hidden" name="ids[{{ $user->id }}]" value="{{ $user->id }}">
                        @endforeach
                    </div> <!--/.box-body-->

                    <div class="box-footer text-right">
                        <a class="btn btn-link pull-left" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>

                        <button type="submit" class="btn btn-success"{{ (config('app.lock_passwords') ? ' disabled' : '') }}>
                            <x-icon type="checkmark" />
                            {{ trans('general.update') }}
                        </button>

                    </div><!-- /.box-footer -->
                </div> <!--/.box.box-default-->
            </form>
        </div> <!--/.col-md-8-->
    </div>
@stop
