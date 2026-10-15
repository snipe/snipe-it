<?php

namespace App\Console\Commands;

use App\Models\CheckoutAcceptance;
use App\Models\LicenseSeat;
use App\Models\User;
use Illuminate\Console\Command;

class CleanIncorrectCheckoutAcceptances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:clean-checkout-acceptances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete checkout acceptances for checkouts to non-users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deletions = 0;
        $skips = 0;
        $total = CheckoutAcceptance::count();

        $this->info("Processing {$total} checkout acceptances...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        // Chunk to avoid loading the whole table into memory; eager-load checkoutable
        // to eliminate the N+1 on that relationship.
        CheckoutAcceptance::with('checkoutable')
            ->chunkById(500, function ($chunk) use (&$deletions, &$skips, $bar) {
                $idsToDelete = [];

                foreach ($chunk as $checkoutAcceptance) {
                    $item = $checkoutAcceptance->checkoutable;
                    $checkout_to_id = $checkoutAcceptance->assigned_to_id;

                    if (is_null($item)) {
                        $skips++;
                        $bar->advance();

                        continue;
                    }

                    if (get_class($item) === LicenseSeat::class) {
                        $item = $item->license;
                        if (is_null($item)) {
                            $skips++;
                            $bar->advance();

                            continue;
                        }
                    }

                    if (is_null($checkoutAcceptance->created_at)) {
                        $skips++;
                        $bar->advance();

                        continue;
                    }

                    // Push all filtering (including the ±5-second window) into the DB;
                    // exists() returns as soon as one matching row is found rather than
                    // fetching all checkout logs into PHP.
                    $shouldDelete = $item->assetlog()
                        ->where('action_type', 'checkout')
                        ->where('target_id', $checkout_to_id)
                        ->where('target_type', '!=', User::class)
                        ->whereBetween('created_at', [
                            $checkoutAcceptance->created_at->copy()->subSeconds(5),
                            $checkoutAcceptance->created_at->copy()->addSeconds(5),
                        ])
                        ->exists();

                    if ($shouldDelete) {
                        $idsToDelete[] = $checkoutAcceptance->id;
                        $deletions++;
                    } else {
                        $skips++;
                    }

                    $bar->advance();
                }

                // Bulk-delete the bad records in one query per chunk instead of one per row.
                if (! empty($idsToDelete)) {
                    CheckoutAcceptance::whereIn('id', $idsToDelete)->forceDelete();
                }
            });

        $bar->finish();
        $this->newLine();
        $this->info("Final deletion count: {$deletions}, and skip count: {$skips}");
    }
}
