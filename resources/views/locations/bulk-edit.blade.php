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

            <p>{{ trans('admin/locations/general.bulk_update_help') }}</p>

            <div class="callout callout-warning">
                <i class="fa fa-warning"></i> {{ trans('admin/locations/general.bulk_update_warn', ['location_count' => count($locations)]) }}
            </div>

            <form class="form-horizontal" method="post" action="{{ route('locations/bulkeditsave') }}" autocomplete="off" role="form">
                {{ csrf_field() }}

                <div class="box box-default">
                    <div class="box-body">

                        <!-- Parent -->
                        @include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/locations/table.parent'), 'fieldname' => 'parent_id'])

                        <!-- Company -->
                        @if (\App\Models\Company::canManageUsersCompanies())
                            @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.select_company'), 'fieldname' => 'company_id'])
                        @endif

                        <!-- Manager -->
                        @include ('partials.forms.edit.user-select', ['translated_name' => trans('admin/users/table.manager'), 'fieldname' => 'manager_id'])

                        @foreach ($locations as $key => $value)
                            <input type="hidden" name="ids[{{ $value }}]" value="1">
                        @endforeach

                    </div> <!--/.box-body-->

                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                    </div>
                </div> <!--/.box.box-default-->
            </form>
        </div> <!--/.col-md-8-->
    </div>
@stop