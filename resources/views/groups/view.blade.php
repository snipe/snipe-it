@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ $group->name }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('groups.edit', ['group' => $group->id]) }}" class="btn btn-primary text-right">{{ trans('admin/groups/titles.update') }} </a>
    <a href="{{ route('groups.index') }}" class="btn btn-default pull-right">{{ trans('general.back') }}</a>
@stop



{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-9">
            <div class="box box-default">
                <div class="box-body">
                    <div class="row">
                    {{ Form::open(['route' => ['api.users.assignusergroup'],'method' => 'GET', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'user-form' ]) }}
                        <div id="assigned_user" class="form-group"{!!  (isset($style)) ? ' style="'.e($style).'"' : ''  !!}>

                            {{ Form::label('Select User', trans('general.user'), array('class' => 'col-md-2 control-label')) }}
                            <div class="col-md-6 {{ 'required' }}">
                                <select class="js-data-ajax" data-endpoint="users" data-placeholder="{{ trans('general.select_user') }}" name="assigned_user" style="width: 100%" id="assigned_user_select" aria-label="assigned_user">
                                    @if ($user_id = old('assigned_user', (isset($item)) ? $item->{'assigned_user'} : ''))
                                        <option value="{{ $user_id }}" selected="selected" role="option" aria-selected="true"  role="option">
                                            {{ (\App\Models\User::find($user_id)) ? \App\Models\User::find($user_id)->present()->fullName : '' }}
                                        </option>
                                    @else
                                        <option value=""  role="option">{{ trans('general.select_user') }}</option>
                                    @endif
                                </select>
                            </div>


                            <div class="col-md-1 col-sm-1 text-left">
                                @can('admin')
                                    <button type='submit'>Add</button>
                                @endcan
                            </div>

                        </div>

                        {{Form::close()}}

                        <div class="col-md-12">
                            <div class="table table-responsive">

                                <table
                                    data-columns="{{  \App\Presenters\UserPresenter::dataTableLayout() }}"
                                    data-cookie-id-table="groupsUsersTable"
                                    data-pagination="true"
                                    data-search="true"
                                    data-side-pagination="server"
                                    data-show-columns="true"
                                    data-show-export="true"
                                    data-show-refresh="true"
                                    id="groupsUsersTable"
                                    class="table table-striped snipe-table"
                                    data-url="{{ route('api.users.index',['group_id'=> $group->id]) }}"
                                    data-export-options='{
                                    "fileName": "export-{{ str_slug($group->name) }}-group-users-{{ date('Y-m-d') }}",
                                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                                        }'>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">

            @if (is_array($group->decodePermissions()))
            <ul class="list-unstyled">
                @foreach ($group->decodePermissions() as $permission_name => $permission)
                   <li>{!! ($permission == '1') ? '<i class="fas fa-check text-success" aria-hidden="true"></i><span class="sr-only">GRANTED: </span>' :  '<i class="fas fa-times text-danger" aria-hidden="true"></i><span class="sr-only">DENIED: </span>' !!} {{ e(str_replace('.', ': ', ucwords($permission_name))) }} </li>
                @endforeach

            </ul>
            @else
                <p>This group has no permissions.</p>
            @endif

        </div>
    </div>

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')
@stop
