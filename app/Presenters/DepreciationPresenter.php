<?php

namespace App\Presenters;

use App\Helpers\Helper;

/**
 * Class DepreciationPresenter
 * @package App\Presenters
 */
class DepreciationPresenter extends Presenter
{
    /**
     * Formatted JSON representation of this Depreciation
     * @return array
     */
    public function forDataTable()
    {
        $actions = Helper::generateDatatableButton('edit', route('depreciations.edit', $this->id));
        $actions .= Helper::generateDatatableButton(
            'delete',
            route('depreciations.destroy', $this->id),
            true, /*enabled*/
            trans('admin/depreciations/message.delete.confirm'),
            $this->name
        );

        $results = [
            'id'            => $this->id,
            'name'          => $this->name,
            'months'        => $this->months,
            'actions'       => $actions
        ];

        return $results;
    }
}
