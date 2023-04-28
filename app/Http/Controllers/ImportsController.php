<?php

namespace App\Http\Controllers;

use App\Http\Transformers\ImportsTransformer;
use App\Models\Asset;
use App\Models\Import;

class ImportsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('import');
        $imports = (new ImportsTransformer)->transformImports(Import::latest()->get());

        return view('importer/import')->with('imports', $imports);
    }
}
