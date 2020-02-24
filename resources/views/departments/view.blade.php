@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.department') }}:
    {{ $department->name }}
    
    @parent
@stop

@section('header_right')
    <a href="{{ route('departments.edit', ['department' => $department->id]) }}" class="btn btn-sm btn-primary pull-right">{{ trans('admin/departments/table.update') }} </a>
@stop

{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-9">

            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#users_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md"><i class="fa fa-users"></i></span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.people') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#assets_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md"><i class="fa fa-barcode"></i></span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.assets') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#licenses_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md"><i class="fa fa-floppy-o"></i></span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.licenses') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#accessories_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md"><i class="fa fa-keyboard-o"></i></span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.accessories') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#consumables_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md"><i class="fa fa-tint"></i></span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.consumables') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#components_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md"><i class="fa fa-hdd-o"></i></span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.components') }}</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="users_tab">
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
                    <div class="tab-pane fade" id="assets_tab">
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
                                      data-toolbar="#toolbar"
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
                      <div class="tab-pane" id="licenses_tab">
                        <div class="table-responsive">

                            <table
                                    data-columns="{{ \App\Presenters\LicensePresenter::dataTableLayout() }}"
                                    data-cookie-id-table="licensesTable"
                                    data-pagination="true"
                                    data-id-table="licensesTable"
                                    data-search="true"
                                    data-side-pagination="server"
                                    data-show-columns="true"
                                    data-show-export="true"
                                    data-show-refresh="true"
                                    data-sort-order="asc"
                                    id="licensesTable"
                                    class="table table-striped snipe-table"
                                    data-url="{{route('api.licenses.index',['department_id' => $department->id]) }}"
                                    data-export-options='{
                              "fileName": "export-companies-{{ str_slug($department->name) }}-licenses-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                            </table>

                        </div>
                    </div><!-- /licenses-tab -->

                    <div class="tab-pane" id="accessories_tab">
                        <div class="table-responsive">

                            <table
                                    data-columns="{{ \App\Presenters\AccessoryPresenter::dataTableLayout() }}"
                                    data-cookie-id-table="accessoriesTable"
                                    data-pagination="true"
                                    data-id-table="accessoriesTable"
                                    data-search="true"
                                    data-side-pagination="server"
                                    data-show-columns="true"
                                    data-show-export="true"
                                    data-show-refresh="true"
                                    data-sort-order="asc"
                                    id="accessoriesTable"
                                    class="table table-striped snipe-table"
                                    data-url="{{route('api.accessories.index',['department_id' => $department->id]) }}"
                                    data-export-options='{
                              "fileName": "export-companies-{{ str_slug($department->name) }}-accessories-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                            </table>

                        </div>
                    </div><!-- /accessories-tab -->

                    <div class="tab-pane" id="consumables_tab">
                        <div class="table-responsive">

                            <table
                                    data-columns="{{ \App\Presenters\ConsumablePresenter::dataTableLayout() }}"
                                    data-cookie-id-table="consumablesTable"
                                    data-pagination="true"
                                    data-id-table="consumablesTable"
                                    data-search="true"
                                    data-side-pagination="server"
                                    data-show-columns="true"
                                    data-show-export="true"
                                    data-show-refresh="true"
                                    data-sort-order="asc"
                                    id="consumablesTable"
                                    class="table table-striped snipe-table"
                                    data-url="{{route('api.consumables.index',['department_id' => $department->id]) }}"
                                    data-export-options='{
                              "fileName": "export-companies-{{ str_slug($department->name) }}-consumables-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                            </table>

                        </div>
                    </div><!-- /consumables-tab -->

                    <div class="tab-pane" id="components_tab">
                        <div class="table-responsive">

                            <table
                                    data-columns="{{ \App\Presenters\ComponentPresenter::dataTableLayout() }}"
                                    data-cookie-id-table="componentsTable"
                                    data-pagination="true"
                                    data-id-table="componentsTable"
                                    data-search="true"
                                    data-side-pagination="server"
                                    data-show-columns="true"
                                    data-show-export="true"
                                    data-show-refresh="true"
                                    data-sort-order="asc"
                                    id="componentsTable"
                                    class="table table-striped snipe-table"
                                    data-url="{{route('api.components.index',['department_id' => $department->id]) }}"
                                    data-export-options='{
                              "fileName": "export-companies-{{ str_slug($department->name) }}-components-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>

                            </table>
                        </div>
                    </div><!-- /consumables-tab -->


                
                </div>
            </div>
        </div><!-- left panel -->

        <div class="col-md-3">

            @if ($department->image!='')
              <div class="col-md-12 text-center" style="padding-bottom: 20px;">
                <a href="{{ url('/') }}/uploads/departments/{{ $department->image }}" data-toggle="lightbox"><img src="{{ url('/') }}/uploads/departments/{{{ $department->image }}}" class="assetimg img-responsive"></a>
            </div>
            @endif
              <div class="col-md-12">
                <ul class="list-unstyled" style="line-height: 25px; padding-bottom: 20px;">
                  @if ($department->company!='')
                    <li><strong>{{ trans('general.company') }}: </strong><a href="{{ url('/companies/' . $department->company->id) }}">{{ $department->company->name }}</a></li>
                   @endif
                    @if ($department->location!='')
                    <li><strong>{{ trans('general.location') }}: </strong>
                        @can('superuser')
                            <a href="{{ route('locations.show', ['location' => $department->location->id]) }}">
                            {{ $department->location->name }}
                            </a>
                        @else
                            {{ $department->location->name }}
                        @endcan
                    </li>
                    @endif
                    @if (($department->manager))
                      <li><strong>{{ trans('admin/users/table.manager') }}: </strong> {!! $department->manager->present()->nameUrl() !!}</li>
                    @endif
                </ul>
      
        
              </div>
        </div><!-- right panel -->

    </div>

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')

@stop
