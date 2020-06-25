<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\InvoiceType;
use App\Http\Transformers\DatatablesTransformer;
use App\Http\Transformers\ManufacturersTransformer;
use App\Http\Transformers\SelectlistTransformer;

class InvoiceTypesController extends Controller
{

    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     *
     */
    public function selectlist(Request $request)
    {

        $invoice_types = InvoiceType::select([
            'id',
            'name',
        ]);

        if ($request->filled('search')) {
            $invoice_types = $invoice_types->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $invoice_types = $invoice_types->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($invoice_types as $invoice_type) {
            $invoice_type->use_text = $invoice_type->name;
        }

        return (new SelectlistTransformer)->transformSelectlist($invoice_types);

    }
}
