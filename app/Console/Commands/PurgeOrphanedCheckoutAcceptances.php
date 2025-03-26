<?php

namespace App\Console\Commands;

use App\Models\CheckoutAcceptance;
use Illuminate\Console\Command;

class PurgeOrphanedCheckoutAcceptances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:purge-orphaned-checkout-acceptances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes pending checkout acceptances where the user has been deleted.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        CheckoutAcceptance::pending()
            ->whereDoesntHave('assignedTo')
            ->forceDelete();
    }
}
