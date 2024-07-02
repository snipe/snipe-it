@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ $company->name }}
    @parent
@stop

{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">


                    <li class="active">
                        <a href="#asset_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md">
                            <i class="fas fa-barcode" aria-hidden="true"></i>
                            </span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.assets') }}
                                {!! ($company->assets()->AssetsForShow()->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($company->assets()->AssetsForShow()->count()).'</badge>' : '' !!}

                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="#licenses_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md">
                            <i class="far fa-save"></i>
                            </span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.licenses') }}
                                {!! ($company->licenses->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($company->licenses->count()).'</badge>' : '' !!}
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="#accessories_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md">
                            <i class="far fa-keyboard"></i>
                            </span> <span class="hidden-xs hidden-sm">{{ trans('general.accessories') }}
                                {!! ($company->accessories->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($company->accessories->count()).'</badge>' : '' !!}
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="#consumables_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md">
                            <i class="fas fa-tint"></i></span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.consumables') }}
                                {!! ($company->consumables->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($company->consumables->count()).'</badge>' : '' !!}
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="#components_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md">
                            <i class="far fa-hdd"></i></span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.components') }}
                                {!! (($company->components) && ($company->components->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($company->components->count()).'</badge>' : '' !!}
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="#users_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md">
                            <i class="fas fa-users"></i></span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.people') }}
                                {!! (($company->users) && ($company->users->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($company->users->count()).'</badge>' : '' !!}
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="#files_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md">
                            <i class="far fa-file fa"></i></span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.files') }}
                            {!! ($company->uploads->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($company->uploads->count()).'</badge>' : '' !!}
                            </span>
                        </a>
                    </li>

                </ul>

                <div class="tab-content">

                    <div class="tab-pane fade in active" id="asset_tab">
                        <!-- checked out assets table -->
                        <div class="table table-responsive">
                            @include('partials.asset-bulk-actions')

                            <table
                                    data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                                    data-cookie-id-table="assetsListingTable"
                                    data-pagination="true"
                                    data-id-table="assetsListingTable"
                                    data-search="true"
                                    data-side-pagination="server"
                                    data-show-columns="true"
                                    data-show-export="true"
                                    data-show-refresh="true"
                                    data-sort-order="asc"
                                    data-toolbar="#assetsBulkEditToolbar"
                                    data-bulk-button-id="#bulkAssetEditButton"
                                    data-bulk-form-id="#assetsBulkForm"
                                    data-click-to-select="true"
                                    id="assetsListingTable"
                                    class="table table-striped snipe-table"
                                    data-url="{{route('api.assets.index',['company_id' => $company->id]) }}"
                                    data-export-options='{
                              "fileName": "export-companies-{{ str_slug($company->name) }}-assets-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                            </table>
                        </div>
                    </div><!-- /asset_tab -->

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
                                    data-url="{{route('api.licenses.index',['company_id' => $company->id]) }}"
                                    data-export-options='{
                              "fileName": "export-companies-{{ str_slug($company->name) }}-licenses-{{ date('Y-m-d') }}",
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
                                    data-url="{{route('api.accessories.index',['company_id' => $company->id]) }}"
                                    data-export-options='{
                              "fileName": "export-companies-{{ str_slug($company->name) }}-accessories-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                            </table>

                        </div>
                    </div><!-- /accessories-tab -->


                    <div class="tab-pane" id="files_tab">
                        <div class="row">

                        <div class="col-md-12 col-sm-12">
              <div class="table-responsive">
                  <table
                          data-cookie-id-table="userUploadsTable"
                          data-id-table="userUploadsTable"
                          id="userUploadsTable"
                          data-search="true"
                          data-pagination="true"
                          data-side-pagination="client"
                          data-show-columns="true"
                          data-show-fullscreen="true"
                          data-show-export="true"
                          data-show-footer="true"
                          data-toolbar="#upload-toolbar"
                          data-show-refresh="true"
                          data-sort-order="asc"
                          data-sort-name="name"
                          class="table table-striped snipe-table"
                          data-export-options='{
                    "fileName": "export-license-uploads-{{ str_slug($user->name) }}-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","delete","download","icon"]
                    }'>

                  <thead>
                    <tr>
                        <th data-visible="true" data-field="icon" data-sortable="true">{{trans('general.file_type')}}</th>
                        <th class="col-md-2" data-searchable="true" data-visible="true" data-field="image">{{ trans('general.image') }}</th>
                        <th class="col-md-2" data-searchable="true" data-visible="true" data-field="filename" data-sortable="true">{{ trans('general.file_name') }}</th>
                        <th class="col-md-1" data-searchable="true" data-visible="true" data-field="filesize">{{ trans('general.filesize') }}</th>
                        <th class="col-md-2" data-searchable="true" data-visible="true" data-field="notes" data-sortable="true">{{ trans('general.notes') }}</th>
                        <th class="col-md-1" data-searchable="true" data-visible="true" data-field="download">{{ trans('general.download') }}</th>
                        <th class="col-md-2" data-searchable="true" data-visible="true" data-field="created_at" data-sortable="true">{{ trans('general.created_at') }}</th>
                        <th class="col-md-1" data-searchable="true" data-visible="true" data-field="actions">{{ trans('table.actions') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($company->uploads as $file)
                        <tr>
                            <td>
                                <i class="{{ Helper::filetype_icon($file->filename) }} icon-med" aria-hidden="true"></i>
                                <span class="sr-only">{{ Helper::filetype_icon($file->filename) }}</span>
                            </td>
                            <td>
                                @if ($file->filename)
                                    @if (Storage::exists('private_uploads/users/'.$file->filename) || Storage::exists('private_uploads/assets/'.$file->filename))
                                        @if (Helper::checkUploadIsImage($file->get_src('users')))
                                            <a href="{{ route('show/userfile', [$file->item_id, $file->id, 'inline' => 'true']) }}" data-toggle="lightbox" data-type="image">
                                                <img src="{{ route('show/userfile', [$file->item_id, $file->id, 'inline' => 'true']) }}" class="img-thumbnail" style="max-width: 50px;">
                                            </a>
                                        @elseif (Helper::checkUploadIsImage($file->get_src('assets')))
                                            <a href="{{ route('show/assetfile', [$file->item_id, $file->id, 'inline' => 'true']) }}" data-toggle="lightbox" data-type="image">
                                                <img src="{{ route('show/assetfile', [$file->item_id, $file->id, 'inline' => 'true']) }}" class="img-thumbnail" style="max-width: 50px;">
                                            </a>
                                        @else
                                            {{ trans('general.preview_not_available') }}
                                        @endif
                                    @else
                                        <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                        {{ trans('general.file_not_found') }}
                                    @endif
                                @endif
                            </td>
                            <td>{{ $file->filename }}</td>
                            <td data-value="{{ (Storage::exists('private_uploads/users/'.$file->filename)) ? Storage::size('private_uploads/users/'.$file->filename) : (Storage::exists('private_uploads/assets/'.$file->filename) ? Storage::size('private_uploads/assets/'.$file->filename) : '') }}">
                                @if (Storage::exists('private_uploads/users/'.$file->filename))
                                    {{ Helper::formatFilesizeUnits(Storage::size('private_uploads/users/'.$file->filename)) }}
                                @elseif (Storage::exists('private_uploads/assets/'.$file->filename))
                                    {{ Helper::formatFilesizeUnits(Storage::size('private_uploads/assets/'.$file->filename)) }}
                                @endif
                            </td>
                            <td>
                                @if ($file->note)
                                    {{ $file->note }}
                                @endif
                            </td>
                            <td>
                                @if ($file->filename)
                                    @if (Storage::exists('private_uploads/users/'.$file->filename))
                                        <a href="{{ route('show/userfile', [$file->item_id, $file->id]) }}" class="btn btn-sm btn-default">
                                            <i class="fas fa-download" aria-hidden="true"></i>
                                            <span class="sr-only">{{ trans('general.download') }}</span>
                                        </a>
                                        <a href="{{ route('show/userfile', [$file->item_id, $file->id, 'inline' => 'true']) }}" class="btn btn-sm btn-default" target="_blank">
                                            <i class="fa fa-external-link" aria-hidden="true"></i>
                                        </a>
                                    @elseif (Storage::exists('private_uploads/assets/'.$file->filename))
                                        <a href="{{ route('show/assetfile', [$file->item_id, $file->id]) }}" class="btn btn-sm btn-default">
                                            <i class="fas fa-download" aria-hidden="true"></i>
                                            <span class="sr-only">{{ trans('general.download') }}</span>
                                        </a>
                                        <a href="{{ route('show/assetfile', [$file->item_id, $file->id, 'inline' => 'true']) }}" class="btn btn-sm btn-default" target="_blank">
                                            <i class="fa fa-external-link" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                @endif
                            </td>
                            <td>{{ $file->created_at }}</td>
                            <td>
                                <a class="btn delete-asset btn-danger btn-sm hidden-print" href="{{ route('userfile.destroy', [$user->id, $file->id]) }}" data-content="Are you sure you wish to delete this file?" data-title="Delete {{ $file->filename }}?">
                                    <i class="fa fa-trash icon-white" aria-hidden="true"></i>
                                    <span class="sr-only">{{ trans('general.delete') }}</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
              </div>
            </div>
          </div> <!--/ROW-->
        </div><!--/FILES-->

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
                                    data-url="{{route('api.consumables.index',['company_id' => $company->id]) }}"
                                    data-export-options='{
                              "fileName": "export-companies-{{ str_slug($company->name) }}-consumables-{{ date('Y-m-d') }}",
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
                                    data-url="{{route('api.components.index',['company_id' => $company->id]) }}"
                                    data-export-options='{
                              "fileName": "export-companies-{{ str_slug($company->name) }}-components-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>

                            </table>
                        </div>
                    </div><!-- /consumables-tab -->

                    <div class="tab-pane" id="users_tab">
                        <div class="table-responsive">

                            <table
                                    data-columns="{{ \App\Presenters\UserPresenter::dataTableLayout() }}"
                                    data-cookie-id-table="usersTable"
                                    data-pagination="true"
                                    data-id-table="usersTable"
                                    data-search="true"
                                    data-side-pagination="server"
                                    data-show-columns="true"
                                    data-show-export="true"
                                    data-show-refresh="true"
                                    data-sort-order="asc"
                                    id="usersTable"
                                    class="table table-striped snipe-table"
                                    data-url="{{route('api.users.index',['company_id' => $company->id]) }}"
                                    data-export-options='{
                              "fileName": "export-companies-{{ str_slug($company->name) }}-users-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>

                            </table>
                        </div>
                    </div><!-- /consumables-tab -->             




                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
        </div>
    </div>

@stop
@section('moar_scripts')
    @include ('partials.bootstrap-table')

@stop

