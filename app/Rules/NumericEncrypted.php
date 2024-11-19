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
            $attributeName = trim(preg_replace('/_+|snipeit|\d+/', ' ', $attribute));
            $decrypted = Crypt::decrypt($value);
            if (!is_numeric($decrypted) && !is_null($decrypted)) {
                $fail(trans('validation.numeric', ['attribute' => $attributeName]));
            }
        } catch (\Exception $e) {
            report($e->getMessage());
            $fail(trans('general.something_went_wrong'));
        }
    }
}
