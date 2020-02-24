@extends('layouts/default')

{{-- Page title --}}
@section('title')

    {{ $department->name }}
    {{ trans('general.department') }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('departments.edit', ['department' => $department->id]) }}" class="btn btn-sm btn-primary pull-right">{{ trans('admin/departments/table.update') }} </a>
@stop

{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-12">

            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#details" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-info-circle"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.details') }}</span></a>
                    </li>
                    <li>
                        <a href="#users" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-users"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.users') }}</span></a>
                    </li>
                    <li>
                        <a href="#assets" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-barcode"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.assets') }}</span></a>
                    </li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="details">
                        <div class="row">
                            <div class="col-md-2 text-center">
                                <a href="{{ url('/') }}/uploads/departments/{{ $department->image }}" data-toggle="lightbox"><img src="{{ url('/') }}/uploads/departments/{{{ $department->image }}}" class="assetimg img-responsive"></a>
                            </div>
                  
                            <div class="col-md-10">
                                <div class="table table-responsive" style="margin-top: 10px;">
                                    <table class="table">
                                        <tbody>
                         
                                            @if ($department->company)
                                            <tr>
                                                <td>{{ trans('general.company') }}</td>
                                                <td><a href="{{ url('/companies/' . $department->company->id) }}">{{ $department->company->name }}</a></td>
                                            </tr>
                                            @endif


                                            @if ($department->location)
                                            <tr>
                                              <td>{{ trans('general.location') }}</td>
                                              <td>
                                                @can('superuser')
                                                  <a href="{{ route('locations.show', ['location' => $department->location->id]) }}">
                                                    {{ $department->location->name }}
                                                  </a>
                                                @else
                                                  {{ $department->location->name }}
                                                @endcan
                                              </td>
                                            </tr>
                                            @endif


                                            @if ($department->manager)
                                            <tr>
                                              <td>{{ trans('admin/users/table.manager') }}</td>
                                              <td>
                                                {!! $department->manager->present()->nameUrl() !!}
                                              </td>
                                            </tr>
                                            @endif

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="users">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table table-responsive" style="margin-top: 10px;">

                                    <table
                                        data-columns="{{ \App\Presenters\UserPresenter::dataTableLayout() }}"
                                        data-cookie-id-table="departmentsUsersTable"
                                        data-pagination="true"
                                        data-id-table="departmentsUsersTable"
                                        data-search="true"
                                        data-show-footer="true"
                                        data-side-pagination="server"
                                        data-show-columns="true"
                                        data-show-export="true"
                                        data-show-refresh="true"
                                        data-sort-order="asc"
                                        id="departmentsUsersTable"
                                        class="table table-striped snipe-table"
                                        data-url="{{ route('api.users.index',['department_id'=> $department->id]) }}"
                                        data-export-options='{
                                    "fileName": "export-departments-{{ str_slug($department->name) }}-{{ date('Y-m-d') }}",
                                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                                    }'>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="assets">
                        <div class="row">
                          <div class="col-md-12">
                            {{ Form::open([
                                      'method' => 'POST',
                                      'route' => ['hardware/bulkedit'],
                                      'class' => 'form-inline',
                                       'id' => 'bulkForm']) }}
                            <div id="toolbar">
                              <select name="bulk_actions" class="form-control select2" style="width: 150px;">
                                <option value="edit">Edit</option>
                                <option value="delete">Delete</option>
                                <option value="labels">Generate Labels</option>
                              </select>
                              <button class="btn btn-primary" id="bulkEdit" disabled>Go</button>
                            </div>
              
                            <!-- checked out assets table -->
                            <div class="table-responsive">
              
                              <table
                                      data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                                      data-cookie-id-table="assetsTable"
                                      data-pagination="true"
                                      data-id-table="assetsTable"
                                      data-search="true"
                                      data-side-pagination="server"
                                      data-show-columns="true"
                                      data-show-export="true"
                                      data-show-refresh="true"
                                      data-sort-order="asc"
                                      id="assetsListingTable"
                                      class="table table-striped snipe-table"
                                      data-url="{{route('api.assets.index',['department_id' => $department->id]) }}"
                                      data-export-options='{
                                            "fileName": "export-departments-{{ str_slug($department->name) }}-assets-{{ date('Y-m-d') }}",
                                            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                                            }'>
              
                              </table>
              
              
                              {{ Form::close() }}
                            </div>
                          </div><!-- /col -->
                        </div> <!-- row -->
                      </div> <!-- /.tab-pane assets -->
                
                </div>
            </div>
        </div>
    </div>

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')

@stop
