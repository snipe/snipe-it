<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Crypt;

class AlphaEncrypted implements ValidationRule
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
            if (!ctype_alpha($decrypted) && !is_null($decrypted)) {
                $fail($attribute.' is not alphabetic.');
            }
        } catch (\Exception $e) {
            report($e);
            $fail('something went wrong.');
        }
    }
}
