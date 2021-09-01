<?php

namespace App\Presenters;

/**
 * Class DepreciationPresenter
 * @package App\Presenters
 */
class DepreciationReportPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {

        $layout = [
            [
                "field" => "company_name",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/companies/table.title'),
                "visible" => false
            ], [
                "field" => "id",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/categories/general.category_name'),
                "visible" => true,

            ],

            [
                "field" => "asset_tag",
                "searchable" => true,
                "sortable" => true,
                "title" =>  trans('admin/hardware/table.asset_tag'),
                "visible" => true,
            ],
            [
                "field" => "asset_name",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('general.name'),
                "visible" => false,

            ],
            [
                "field" => "serial",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('admin/hardware/table.serial'),
                "visible" => true,

            ],
            [
                "field" => "depreciation_type",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('admin/depreciations/general.depreciation_name'),
                "visible" => true,

            ],
            [
                "field" => "depreciation_length",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('admin/depreciations/general.number_of_months'),
                "visible" => true,

            ],
            [
                "field" => "asset_status",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('admin/hardware/table.status'),
                "visible" => true,

            ],
            [
                "field" => "asset_checkedOut",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('admin/hardware/table.checkoutto'),
                "visible" => true,

            ],
            [
                "field" => "location",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('admin/hardware/table.location'),
                "visible" => false,

            ],
            [
                "field" => "purchase_date",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('admin/hardware/table.purchase_date'),
                "visible" => true,

            ],
            [
                "field" => "eol",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('admin/hardware/table.eol'),
                "visible" => true,

            ],
            [
                "field" => "purchase_cost",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('admin/hardware/table.purchase_cost'),
                "visible" => true,

            ],
            [
                "field" => "current_value",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('admin/hardware/table.book_value'),
                "visible" => true,

            ],
            [
                "field" => "monthly_depreciation",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('admin/hardware/table.monthly_depreciation'),
                "visible" => true,

            ],
            [
                "field" => "diff",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('admin/hardware/table.diff'),
                "visible" => true,

            ],
        ];

        return json_encode($layout);
    }

}