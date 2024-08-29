<?php

namespace App\Rules;
use App\Models\Setting;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserCannotSwitchCompaniesIfItemsAssigned implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::find(request()->route('user')->id);
        if (($value) && ($user->allAssignedCount() > 0) && (Setting::getSettings()->full_multiple_companies_support)) {
            $fail(trans('admin/users/message.error.multi_company_items_assigned'));
        }
    }
}
