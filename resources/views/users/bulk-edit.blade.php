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


                        <!-- Location -->
                        @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])


                        <!-- Company -->
                        @if (\App\Models\Company::canManageUsersCompanies())
                            @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.select_company'), 'fieldname' => 'company_id'])
                        @endif

                        <!-- Manager -->
                    @include ('partials.forms.edit.user-select', ['translated_name' => trans('admin/users/table.manager'), 'fieldname' => 'manager_id'])

                        <!-- language -->
                        <div class="form-group {{ $errors->has('locale') ? 'has-error' : '' }}">
                            <label class="col-md-3 control-label" for="locale">{{ trans('general.language') }}</label>
                            <div class="col-md-8">
                                {!! Form::locales('locale', old('locale', $user->locale), 'select2') !!}
                                {!! $errors->first('locale', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
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
                                <div class="radio">
                                    <label for="remote">
                                        {{ Form::radio('remote', '', true, ['aria-label'=>'remote', 'class'=>'minimal']) }} {{  trans('general.do_not_change') }} <br>
                                        {{ Form::radio('remote', '1', old('remote'), ['aria-label'=>'remote', 'class'=>'minimal']) }}   {{ trans('admin/users/general.remote_label') }}<br>
                                        {{ Form::radio('remote', '0', old('remote'), ['aria-label'=>'remote', 'class'=>'minimal']) }}   {{ trans('admin/users/general.not_remote_label') }}

                                    </label>
                                </div>
                            </div>
                        </div> <!--/form-group-->

                        <!-- ldap_sync -->
                        <div class="form-group">
                            <div class="col-sm-3 control-label">
                                {{ trans('general.ldap_sync') }}
                            </div>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <label for="ldap_import">
                                        {{ Form::radio('ldap_import', '', true, ['aria-label'=>'ldap_import', 'class'=>'minimal']) }} {{  trans('general.do_not_change') }} <br>
                                        {{ Form::radio('ldap_import', '0', old('ldap_import'), ['aria-label'=>'ldap_import', 'class'=>'minimal']) }} {{ trans('general.ldap_import') }}
                                    </label>
                                </div>
                            </div>
                        </div> <!--/form-group-->

                        <!-- activated -->
                        <div class="form-group">
                            <div class="col-sm-3 control-label">
                                {{ trans('general.login_enabled') }}
                            </div>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <label for="activated">
                                        {{ Form::radio('activated', '', true, ['aria-label'=>'activated', 'class'=>'minimal']) }} {{  trans('general.do_not_change') }} <br>
                                        {{ Form::radio('activated', '1', old('activated'), ['aria-label'=>'activated', 'class'=>'minimal']) }}  {{  trans('admin/users/general.user_activated')}} <br>
                                        {{ Form::radio('activated', '0', old('activated'), ['aria-label'=>'activated', 'class'=>'minimal']) }}  {{  trans('admin/users/general.user_deactivated')}}

                                    </label>
                                </div>
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


                        @foreach ($users as $user)
                            <input type="hidden" name="ids[{{ $user->id }}]" value="{{ $user->id }}">
                        @endforeach
                    </div> <!--/.box-body-->

                    <div class="text-right box-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                    </div>
                </div> <!--/.box.box-default-->
            </form>
        </div> <!--/.col-md-8-->
    </div>
@stop
