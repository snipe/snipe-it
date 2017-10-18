@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ $group->name }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('groups.edit', ['group' => $group->id]) }}" class="btn btn-sm btn-primary pull-right">{{ trans('admin/groups/titles.update') }} </a>
    <a href="{{ route('groups.index') }}" class="btn btn-default pull-right">{{ trans('general.back') }}</a>
@stop



{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-9">
            <div class="box box-default">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table table-responsive">
                                <table
                                        name="groups_users"
                                        id="table-users"
                                        class="table table-striped snipe-table"
                                        data-url="{{ route('api.users.index',['group_id'=> $group->id]) }}"
                                        data-cookie="true"
                                        data-click-to-select="true"
                                        data-cookie-id-table="groups_usersDetailTable">
                                    <thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">

            <ul class="list-unstyled">
                @foreach ($group->decodePermissions() as $permission_name => $permission)
                   <li>{!! ($permission == '1') ? '<i class="fa fa-check text-success"></i>' :  '<i class="fa fa-times text-danger"></i>' !!} {{ e(str_replace('.', ': ', ucwords($permission_name))) }} </li>
                @endforeach

            </ul>

        </div>
    </div>

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table', [
        'exportFile' => 'groups-export',
        'search' => true,
        'columns' => \App\Presenters\UserPresenter::dataTableLayout()
    ])

@stop
