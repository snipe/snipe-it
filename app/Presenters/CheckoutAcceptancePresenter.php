<?php

namespace App\Presenters;

class CheckoutAcceptancePresenter extends Presenter
{
    public static function dataTableLayout(): string
    {
        $showingDeleted = request('deleted') === 'deleted';

        $layout = [];

        if (! $showingDeleted) {
            $layout[] = [
                'field' => 'checkbox',
                'scope' => 'col',
                'checkbox' => true,
                'formatter' => 'checkboxEnabledFormatter',
                'titleTooltip' => trans('general.select_all_none'),
                'printIgnore' => true,
                'class' => 'hidden-print',
            ];
        }

        $layout = array_merge($layout, [
            [
                'field' => 'created_at',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'title' => trans('general.date'),
                'visible' => true,
                'formatter' => 'dateDisplayFormatter',
            ], [
                'field' => 'company.name',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'visible' => true,
                'title' => trans('general.company'),
            ], [
                'field' => 'category.name',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'visible' => true,
                'title' => trans('general.category'),
            ], [
                'field' => 'model.name',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'visible' => true,
                'title' => trans('admin/hardware/form.model'),
            ], [
                // The item being accepted. polymorphicItemFormatter
                // keys off item.type to pick the icon + destination
                // path, so this column renders consistently with the
                // activity report (same icon per morph type, same
                // deleted strikethrough, same viewable fallback).
                'field' => 'item',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('general.name'),
                'visible' => true,
                'formatter' => 'polymorphicItemFormatter',
            ], [
                'field' => 'asset_tag',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'visible' => true,
                'title' => trans('admin/hardware/table.asset_tag'),
            ], [
                // Assignee (always a user on checkout_acceptances).
                // Same shared formatter so the user icon + link come
                // for free.
                'field' => 'target',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => false,
                'title' => trans('admin/hardware/table.checkoutto'),
                'visible' => true,
                'formatter' => 'polymorphicItemFormatter',
            ], [
                // Admin who did the checkout, resolved via the matching
                // action_log row. Rendered through the shared formatter
                // so it reads the same way as every other user cell.
                'field' => 'checked_out_by',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => false,
                'switchable' => true,
                'visible' => true,
                'title' => trans('general.created_by'),
                'formatter' => 'polymorphicItemFormatter',
            ],
        ]);

        // The pending-only view carries the Actions column (reminder /
        // delete) and omits deleted_at (always null). The deleted
        // view swaps those: nothing to do on a trashed row, but the
        // operator wants to see when it was deleted.
        if ($showingDeleted) {
            $layout[] = [
                'field' => 'deleted_at',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'visible' => true,
                'title' => trans('general.deleted_at'),
                'formatter' => 'dateDisplayFormatter',
            ];
        } else {
            $layout[] = [
                'field' => 'actions',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('button.actions'),
                'visible' => true,
                'formatter' => 'acceptanceActionsFormatter',
                'printIgnore' => true,
                'class' => 'hidden-print',
            ];
        }

        return json_encode($layout);
    }
}
