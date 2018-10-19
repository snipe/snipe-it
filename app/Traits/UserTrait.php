<?php

declare(strict_types=1);

namespace App\Traits;

trait UserTrait
{
    /**
     * Generate a random encrypted password.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return string
     */
    public function generateEncyrptedPassword(): string
    {
        return bcrypt($this->generateUnencryptedPassword());
    }

    /**
     * Get a random unencrypted password.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return string
     */
    public function generateUnencryptedPassword(): string
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);
    }
}
