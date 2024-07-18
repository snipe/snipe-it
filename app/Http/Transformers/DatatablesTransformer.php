<?php

namespace App\Http\Transformers;

class DatatablesTransformer
{
    public function transformDatatables($objects, $paginator)
    {
        $objects_array['total'] = $paginator->total();
        $objects_array['rows'] = $objects;
        $objects_array['meta'] = [
                                    'per_page' => $paginator->perPage(),
                                    'current_page' => $paginator->currentPage(),
                                    'last_page' => $paginator->lastPage(),
                                    'next_page_url' => $paginator->nextPageUrl(),
                                    'prev_page_url' => $paginator->previousPageUrl(),
                                ];

        return ($objects_array);
    }
}
