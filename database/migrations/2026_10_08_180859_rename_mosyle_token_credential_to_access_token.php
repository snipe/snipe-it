<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Rename the Mosyle adapter's `token` credential key to `access_token`
 * on any existing sync_adapter_instances rows. The Mosyle Manager v2
 * API requires three auth fields on login (accessToken + email +
 * password), so the single-field token name was ambiguous. Issue
 * #19790.
 *
 * The adapter never worked against a real Mosyle tenant in its
 * original form, so any value in the old `token` field was almost
 * certainly never validated. The migration still rotates it onto the
 * new key rather than dropping it, so admins who have a half-configured
 * instance don't have to re-paste the token after the upgrade.
 *
 * Email and password are new credential fields with no legacy source,
 * so admins will need to add those on the settings page after upgrade
 * before the adapter can actually complete a login.
 */
return new class extends Migration
{
    public function up(): void
    {
        $rows = DB::table('sync_adapter_instances')
            ->where('adapter_type', 'mosyle')
            ->get();

        foreach ($rows as $row) {
            $config = $row->config ? json_decode($row->config, true) : [];
            if (! is_array($config) || ! array_key_exists('token', $config)) {
                continue;
            }

            $config['access_token'] = $config['token'];
            unset($config['token']);

            DB::table('sync_adapter_instances')
                ->where('id', $row->id)
                ->update(['config' => json_encode($config)]);
        }
    }

    public function down(): void
    {
        $rows = DB::table('sync_adapter_instances')
            ->where('adapter_type', 'mosyle')
            ->get();

        foreach ($rows as $row) {
            $config = $row->config ? json_decode($row->config, true) : [];
            if (! is_array($config) || ! array_key_exists('access_token', $config)) {
                continue;
            }

            $config['token'] = $config['access_token'];
            unset($config['access_token']);

            DB::table('sync_adapter_instances')
                ->where('id', $row->id)
                ->update(['config' => json_encode($config)]);
        }
    }
};
