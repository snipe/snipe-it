<?php

namespace App\Http\Controllers;

use App\Models\Depreciation;
use Illuminate\Http\Request;

class DepreciationReportController extends Controller
{
    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the depreciation listing, which is generated in getDatatable.
     *
     * @author [G. Martinez] [<godmartinz@gmail.com]
     * @see DepreciationsReportController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Depreciation::class);

        // Show the page
        return view('reports/depreciation');
    }
}