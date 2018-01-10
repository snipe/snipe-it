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
                            <i class="fa fa-barcode"></i>
                            </span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.assets') }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="#licenses_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md">
                            <i class="fa fa-floppy-o"></i>
                            </span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.licenses') }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="#accessories_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md">
                            <i class="fa fa-keyboard-o"></i>
                            </span> <span class="hidden-xs hidden-sm">{{ trans('general.accessories') }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="#consumables_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md">
                            <i class="fa fa-tint"></i></span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.consumables') }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="#components_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md">
                            <i class="fa fa-hdd-o"></i></span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.components') }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="#users_tab" data-toggle="tab">
                            <span class="hidden-lg hidden-md">
                            <i class="fa fa-users"></i></span>
                            <span class="hidden-xs hidden-sm">{{ trans('general.people') }}</span>
                        </a>
                    </li>



                </ul>

                <div class="tab-content">

                    <div class="tab-pane fade in active" id="asset_tab">
                        <!-- checked out assets table -->
                        <div class="table-responsive">
                            <table
                                    name="companyAssets"
                                    class="table table-striped snipe-table"
                                    id="table"
                                    data-search="true"
                                    data-url="{{route('api.assets.index',['company_id' => $company->id]) }}"
                                    data-export-file="{{ str_slug($company->name) }}-assets"
                                    data-cookie="true"
                                    data-cookie-id-table="companyAssetsTable"
                                    data-show-footer="true"
                                    data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}">

                            </table>
                        </div>
                    </div><!-- /asset_tab -->

                    <div class="tab-pane" id="licenses_tab">
                        <div class="table-responsive">
                            <table
                                    name="companyLicenses"
                                    class="table table-striped snipe-table"
                                    id="companyLicenses"
                                    data-url="{{route('api.licenses.index',['company_id' => $company->id]) }}"
                                    data-cookie="true"
                                    data-export-file="{{ str_slug($company->name) }}-licenses"
                                    data-cookie-id-table="companyLicenses"
                                    data-columns="{{ \App\Presenters\LicensePresenter::dataTableLayout() }}">
                            </table>
                        </div>
                    </div><!-- /licenses-tab -->

                    <div class="tab-pane" id="accessories_tab">
                        <div class="table-responsive">
                            <table
                                    name="companyAccessories"
                                    class="table table-striped snipe-table"
                                    id="companyAccessories"
                                    data-url="{{route('api.accessories.index',['company_id' => $company->id]) }}"
                                    data-cookie="true"
                                    data-export-file="{{ str_slug($company->name) }}-accessories"
                                    data-cookie-id-table="companyAccessories"
                                    data-columns="{{ \App\Presenters\AccessoryPresenter::dataTableLayout() }}">
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /accessories-tab -->

                    <div class="tab-pane" id="consumables_tab">
                        <div class="table-responsive">
                            <table
                                    name="companyConsumables"
                                    class="table table-striped snipe-table"
                                    id="companyConsumables"
                                    data-url="{{route('api.consumables.index',['company_id' => $company->id]) }}"
                                    data-cookie="true"
                                    data-export-file="{{ str_slug($company->name) }}-consumables"
                                    data-cookie-id-table="companyConsumables"
                                    data-columns="{{ \App\Presenters\ConsumablePresenter::dataTableLayout() }}">
                            </table>
                        </div>
                    </div><!-- /consumables-tab -->

                    <div class="tab-pane" id="components_tab">
                        <div class="table-responsive">
                            <table
                                    name="companyComponents"
                                    data-search="true"
                                    class="table table-striped snipe-table"
                                    id="companyUsers"
                                    data-url="{{route('api.components.index',['company_id' => $company->id]) }}"
                                    data-cookie="true"
                                    data-export-file="{{ str_slug($company->name) }}-components"
                                    data-cookie-id-table="companyComponents"
                                    data-columns="{{ \App\Presenters\ComponentPresenter::dataTableLayout() }}">
                            </table>
                        </div>
                    </div><!-- /consumables-tab -->

                    <div class="tab-pane" id="users_tab">
                        <div class="table-responsive">
                            <table
                                    name="companyUsers"
                                    data-search="true"
                                    class="table table-striped snipe-table"
                                    id="companyUsers"
                                    data-url="{{route('api.users.index',['company_id' => $company->id]) }}"
                                    data-cookie="true"
                                    data-export-file="{{ str_slug($company->name) }}-users"
                                    data-cookie-id-table="companyUsers"
                                    data-columns="{{ \App\Presenters\UserPresenter::dataTableLayout() }}">
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

