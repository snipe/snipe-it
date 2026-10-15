<?php

namespace App\View\Composers;

use App\Models\CompanyableScope;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ImpersonationBannerComposer
{
    public function compose(View $view): void
    {
        $impersonatorId = Session::get('impersonator_id');
        $impersonator = null;

        if ($impersonatorId && Auth::check()) {
            // Bypass CompanyableScope: the impersonator is stored by their own action in start(),
            // so looking them up must not be filtered by the impersonated user's company view.
            $impersonator = User::withTrashed()
                ->withoutGlobalScope(CompanyableScope::class)
                ->find($impersonatorId);
        }

        $view->with('impersonator', $impersonator);
    }
}
