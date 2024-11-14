<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Crypt;

class NumericEncrypted implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $value = Crypt::decrypt($value);
            if (!is_numeric($value)) {
                $fail($attribute.' is not numeric.');
            }
        } catch (\Exception $e) {
            $fail($e->getMessage());
        }
    }
}
