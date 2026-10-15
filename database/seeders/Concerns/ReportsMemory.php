<?php

namespace Database\Seeders\Concerns;

/**
 * Adds a small [mem] logger to seeders so peak/current memory is visible in
 * db:seed output. Kept in place as a durable regression signal: if someone
 * later adds a giant factory batch that pushes demo servers into swap, the
 * jump shows up in the console immediately.
 *
 * Safe to use in any Seeder subclass. Silently no-ops when $this->command is
 * null (e.g., when the seeder is invoked outside of an Artisan command).
 */
trait ReportsMemory
{
    protected function reportMemory(string $label): void
    {
        $peakMb = number_format(memory_get_peak_usage(true) / 1024 / 1024, 1);
        $currentMb = number_format(memory_get_usage(true) / 1024 / 1024, 1);
        $this->command?->info("[mem] {$label}: peak {$peakMb} MB, current {$currentMb} MB");
    }
}
