<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ldap;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ldaptest()
    {

        \Log::debug('Preparing to test LDAP connection');

        try {
            $connection = Ldap::connectToLdap();
            try {
                \Log::debug('attempting to bind to LDAP for LDAP test');
                Ldap::bindAdminToLdap($connection);
                return response()->json(['message' => 'It worked!'], 200);
            } catch (\Exception $e) {
                \Log::debug('Bind failed');
                return response()->json(['message' => $e->getMessage()], 400);
                //return response()->json(['message' => $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            \Log::debug('Connection failed');
            return response()->json(['message' => $e->getMessage()], 600);
        }


    }

}
