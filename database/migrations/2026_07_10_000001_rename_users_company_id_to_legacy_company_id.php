<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Rename users.company_id to users.legacy_company_id.
     *
     * The company_user pivot table is the authoritative source of user-company
     * membership. This column is a compatibility mirror kept in sync only for
     * external consumers that still expect it (backfilled by User::syncLegacyCompanyIdMirror).
     * Renaming it makes internal code that accidentally reads or writes the old
     * name fail loudly instead of silently producing stale mirror data.
     *
     * API/CSV/SCIM inputs that name the field "company_id" continue to work;
     * those are field-name conventions at the request/importer layer and are
     * routed into the company_user pivot regardless of what the underlying
     * column is called.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('company_id', 'legacy_company_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('legacy_company_id', 'company_id');
        });
    }
};
