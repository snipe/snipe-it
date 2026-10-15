<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Widen CheckoutRequest to carry a free-text notes field so
 * requesters can attach context to what they're asking for (why they
 * need it, project, budget code, etc). Rendered on the admin queue
 * and included in the "new request" notifications so admins have
 * everything they need to fulfill without a follow-up conversation.
 *
 * Column is nullable to keep the existing bare-request shape working
 * unchanged. Sized to `text` rather than a varchar cap so long
 * multiline explanations don't get truncated.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('checkout_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('checkout_requests', 'notes')) {
                $table->text('notes')->nullable()->after('end_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('checkout_requests', function (Blueprint $table) {
            if (Schema::hasColumn('checkout_requests', 'notes')) {
                $table->dropColumn('notes');
            }
        });
    }
};
