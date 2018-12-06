<?php

namespace App\Http\Controllers\Users;

use App\Models\Ldap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\LdapAd;

class LDAPImportController extends Controller
{
    /**
     * An Ldap instance.
     *
     * @var LdapAd
     */
    protected $ldap;

    /**
     * __construct.
     *
     * @param LdapAd $ldap
     */
    public function __construct(LdapAd $ldap)
    {
        $this->ldap = $ldap;
    }

    /**
     * Return view for LDAP import.
     *
     * @author Aladin Alaily
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return \Illuminate\Contracts\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('update', User::class);
        try {
            $this->ldap->testLdapAdUserConnection();
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }

        return view('users/ldap');
    }

    /**
     * LDAP form processing.
     *
     * @author Aladin Alaily
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Call Artisan LDAP import command.
        $location_id = $request->input('location_id');
        Artisan::call('snipeit:ldapAd-sync', ['--location_id' => $location_id, '--json_summary' => true]);

        // Collect and parse JSON summary.
        $ldap_results_json = Artisan::output();
        $ldap_results = json_decode($ldap_results_json, true);

        // Direct user to appropriate status page.
        if ($ldap_results['error']) {
            return redirect()->back()->withInput()->with('error', $ldap_results['error_message']);
        }

        return redirect()->route('ldap/user')
            ->with('success', 'LDAP Import successful.')
            ->with('summary', $ldap_results['summary']);
    }
}
