<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;


/**
* @copyright: Copyright (c) 2021 Elektrobit Automotive GmbH
*/

class LDAPGroupImportController extends Controller
{
    public function create()
    {
        $this->authorize('create', Group::class);
        
        Artisan::call('snipeit:ldap-group-sync', [ '--json_summary' => true]);

        // Collect and parse JSON summary.
        $ldap_results_json = Artisan::output();
        $ldap_results = json_decode($ldap_results_json, true);

        // Direct user to appropriate status page.
        if ($ldap_results['error']) {
            return redirect()->back()->withInput()->with('error', $ldap_results['error_message']);
        }

        return view('groups/index');
    }
}
