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
            $decrypted = Crypt::decrypt($value);
            if (!is_numeric($decrypted) && !is_null($decrypted)) {
                $fail($attribute.' is not numeric.');
            }
        } catch (\Exception $e) {
            report($e->getMessage());
            $fail('something went wrong');
        }
    }
}
