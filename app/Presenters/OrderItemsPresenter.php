<?php

namespace App\Presenters;

/**
 * Column layout for the Orders tab on Accessory / Consumable /
 * Component / AssetModel view pages. Rendered by <x-table> against
 * the corresponding /orders API endpoint per model.
 */
class OrderItemsPresenter
{
    public static function dataTableLayout(): string
    {
        return json_encode(array_merge(
            self::metadataColumns(),
            self::acquisitionColumns(),
            self::amountColumns(),
            self::notesColumns(),
        ));
    }

    /**
     * Created-at + who-recorded-it columns rendered at the head of the
     * table. Kept separate from acquisition metadata so the "when +
     * who" audit stays visually distinct from the "what" record.
     */
    private static function metadataColumns(): array
    {
        return [
            [
                'field' => 'created_at',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.created_at'),
                'visible' => true,
                'formatter' => 'dateDisplayFormatter',
            ],
            [
                'field' => 'created_by',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.created_by'),
                'visible' => true,
                'formatter' => 'usersLinkObjFormatter',
            ],
        ];
    }

    /**
     * purchase_date / order_number / supplier: the "what did we buy"
     * columns that identify the acquisition event itself.
     */
    private static function acquisitionColumns(): array
    {
        return [
            [
                'field' => 'purchase_date',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.purchase_date'),
                'visible' => true,
                'formatter' => 'dateDisplayFormatter',
            ],
            [
                'field' => 'order_number',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.order_number'),
                'visible' => true,
            ],
            [
                'field' => 'supplier',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.supplier'),
                'visible' => true,
                'formatter' => 'suppliersLinkObjFormatter',
            ],
        ];
    }

    /**
     * qty / unit_cost / currency / total_cost: the "how much" columns.
     * All three numeric fields use sumFormatter for the footer roll-up.
     */
    private static function amountColumns(): array
    {
        return [
            [
                'field' => 'qty',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.qty'),
                'visible' => true,
                'footerFormatter' => 'sumFormatter',
                'class' => 'text-right text-padding-number-cell',
            ],
            [
                'field' => 'unit_cost',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.unit_cost'),
                'visible' => true,
                'footerFormatter' => 'sumFormatter',
                'class' => 'text-right text-padding-number-cell',
            ],
            [
                'field' => 'currency',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.currency'),
                'visible' => true,
            ],
            [
                'field' => 'total_cost',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.total_cost'),
                'visible' => true,
                'footerFormatter' => 'sumFormatter',
                'class' => 'text-right text-padding-number-cell',
            ],
        ];
    }

    private static function notesColumns(): array
    {
        return [
            [
                'field' => 'notes',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => false,
                'switchable' => true,
                'title' => trans('general.notes'),
                'visible' => true,
            ],
            [
                // Receipt file uploaded via the adjust-quantity modal.
                // The transformer returns a URL string (or null) that
                // downloadFormatter renders as a single download button.
                'field' => 'receipt',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => false,
                'switchable' => true,
                'title' => trans('general.file_upload'),
                'visible' => true,
                'formatter' => 'downloadFormatter',
            ],
        ];
    }
}
