@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Bulk Edit
    @parent
@stop


@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <p>{{ trans('admin/users/general.bulk_update_help') }}</p>

            <div class="callout callout-warning">
                <i class="fa fa-warning"></i> {{ trans('admin/users/general.bulk_update_warn', ['user_count' => count($users)]) }}
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

                        <!-- activated -->
                        <div class="form-group">
                            <div class="col-sm-3 control-label">
                                Activated
                            </div>
                            <div class="col-sm-9">
                                <div class="checkbox">
                                    <label for="activated">
                                        {{ Form::radio('activated', '', true) }} Do not change activation status <br>
                                        {{ Form::radio('activated', '1', Input::old('activated')) }}  User is activated<br>
                                        {{ Form::radio('activated', '0', Input::old('activated')) }}  User is de-activated

                                    </label>
                                </div>
                            </div>
                        </div> <!--/form-group-->


                        <!--  Groups -->
                        <div class="form-group{{ $errors->has('groups') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="groups"> {{ trans('general.groups') }}</label>
                            <div class="col-md-6">
                                @if ((Config::get('app.lock_passwords') || (!Auth::user()->isSuperUser())))

                                    <span class="help-block">Only superadmins may edit group memberships.</p>
                                @else
                                    <div class="controls">
                                        <select name="groups[]" id="groups[]" multiple="multiple" class="form-control">
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

                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
                    </div>
                </div> <!--/.box.box-default-->
            </form>
        </div> <!--/.col-md-8-->
    </div>
@stop
