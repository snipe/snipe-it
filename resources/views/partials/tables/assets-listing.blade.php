<div class="table table-responsive">
    <table
            data-click-to-select="true"
            data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
            data-cookie-id-table="userAssetsListingTable"
            data-pagination="true"
            data-id-table="userAssetsListingTable"
            data-search="true"
            data-side-pagination="server"
            data-show-columns="true"
            data-show-fullscreen="true"
            data-show-export="true"
            data-show-footer="true"
            data-show-refresh="true"
            data-sort-order="asc"
            data-sort-name="name"
            data-toolbar="#assetsBulkEditToolbar"
            data-bulk-button-id="#bulkAssetEditButton"
            data-bulk-form-id="#assetsBulkForm"
            id="userAssetsListingTable"
            class="table table-striped snipe-table"
            data-url="{{ route('api.assets.index',['assigned_type' => 'App\Models\User']) }}"
            data-export-options='{
                "fileName": "export-{{ str_slug((isset($export_slug) ? 'export_slug' : 'table')) }}-assets-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
    </table>
</div>