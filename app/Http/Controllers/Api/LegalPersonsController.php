<?php

namespace App\Http\Controllers\Api;

use App\Models\LegalPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\InvoiceType;
use App\Http\Transformers\DatatablesTransformer;
use App\Http\Transformers\ManufacturersTransformer;
use App\Http\Transformers\SelectlistTransformer;

class LegalPersonsController extends Controller
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

        $legal_persons = LegalPerson::select([
            'id',
            'name',
        ]);

        if ($request->filled('search')) {
            $legal_persons = $legal_persons->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $legal_persons = $legal_persons->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($legal_persons as $legal_person) {
            $legal_person->use_text = $legal_person->name;
        }

        return (new SelectlistTransformer)->transformSelectlist($legal_persons);

    }
}
