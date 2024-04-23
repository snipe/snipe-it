<?php

namespace Tests\Support;

trait CanSkipTests
{
    public function markIncompleteIfMySQL($message = 'Test skipped due to database driver being MySQL.')
    {
        if (config('database.default') === 'mysql') {
            $this->markTestIncomplete($message);
        }
    }
}
