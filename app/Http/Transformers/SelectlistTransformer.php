<?php

namespace App\Http\Transformers;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class SelectlistTransformer
 *
 * This handles the standardized formatting of the API response we need to provide for
 * the rich (text and images) Select2 javascript.
 *
 * @author [A. Gianotto] [<snipe@snipe.net>]
 * @since [v4.0.16]
 * @return \Illuminate\Http\Response
 */
class SelectlistTransformer
{
    public function transformSelectlist(LengthAwarePaginator $select_items)
    {
        $items_array = [];

        // Loop through the paginated collection to set the array values
        foreach ($select_items as $select_item) {
            $items_array[] = [
                'id' => (int) $select_item->id,
                'name' => ($select_item->name) ? $select_item->name : null,
                'text' => ($select_item->use_text) ? $select_item->use_text : $select_item->name,
                'image' => ($select_item->use_image) ? $select_item->use_image : null,
                // checkability of the asset
                'user_can_checkout' => ($select_item->user_can_checkout) ? $select_item->user_can_checkout : null,
                'assigned_to' => ($select_item->assigned_to) ? $select_item->assigned_to : null,
                // other useful attributes
                'asset_tag' => ($select_item->asset_tag) ? $select_item->asset_tag : null,
                'model' => ($select_item->model && $select_item->model->name) ? $select_item->model->name : null,
                'model_number' => ($select_item->model && $select_item->model->model_number) ? $select_item->model->model_number : null
            ];
        }

        $results = [
            'results' => $items_array,
            'pagination' => [
                    'more' => ($select_items->currentPage() >= $select_items->lastPage()) ? false : true,
                    'per_page' => $select_items->perPage(),
                ],
            'total_count' => $select_items->total(),
            'page' => $select_items->currentPage(),
            'page_count' => $select_items->lastPage(),
        ];

        return $results;
    }
}
