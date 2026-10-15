<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Actionlog;
use App\Models\CompanyableScope;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    public function start(Request $request, User $user): RedirectResponse
    {
        $actor = Auth::user();

        if (empty(config('app.user_impersonation_usernames'))) {
            abort(404);
        }

        if (! $actor || ! $actor->canImpersonate()) {
            abort(403);
        }

        if ($user->id === $actor->id) {
            return redirect()->route('users.show', $user)
                ->with('error', trans('admin/users/message.impersonate.cannot_impersonate_self'));
        }

        if ($user->isSuperUser()) {
            return redirect()->route('users.show', $user)
                ->with('error', trans('admin/users/message.impersonate.cannot_impersonate_superuser'));
        }

        if ($user->deleted_at !== null || $user->activated != 1) {
            return redirect()->route('users.show', $user)
                ->with('error', trans('admin/users/message.impersonate.target_not_active'));
        }

        $note = trim((string) $request->input('note', ''));
        if ($note === '') {
            return redirect()->route('users.show', $user)
                ->with('error', trans('admin/users/general.impersonate_note_required'));
        }
        // Cap length defensively to match the textarea's maxlength; anything longer
        // is almost certainly a paste error or an abuse attempt.
        $note = mb_substr($note, 0, 500);

        $log = new Actionlog;
        $log->item_type = User::class;
        $log->item_id = $user->id;
        $log->target_type = User::class;
        $log->target_id = $user->id;
        $log->created_at = date('Y-m-d H:i:s');
        $log->created_by = $actor->id;
        $log->note = $note;
        $log->logaction('impersonated');

        $impersonatorId = $actor->id;
        Auth::login($user);
        $request->session()->put('impersonator_id', $impersonatorId);

        return redirect()->route('home')
            ->with('success', trans('admin/users/message.impersonate.started', ['name' => $user->display_name]));
    }

    public function stop(Request $request): RedirectResponse
    {
        $impersonatorId = $request->session()->pull('impersonator_id');

        if (! $impersonatorId) {
            return redirect()->route('home');
        }

        $impersonatedId = Auth::id();
        // Bypass CompanyableScope: the impersonated user may not share a company with the
        // original superuser, but we still need to restore their session.
        $impersonator = User::withTrashed()
            ->withoutGlobalScope(CompanyableScope::class)
            ->find($impersonatorId);

        if (! $impersonator) {
            Auth::logout();

            return redirect()->route('login')
                ->with('error', trans('admin/users/message.impersonate.impersonator_missing'));
        }

        if ($impersonatedId) {
            $log = new Actionlog;
            $log->item_type = User::class;
            $log->item_id = $impersonatedId;
            $log->target_type = User::class;
            $log->target_id = $impersonatedId;
            $log->created_at = date('Y-m-d H:i:s');
            $log->created_by = $impersonator->id;
            $log->logaction('stopped impersonating');
        }

        Auth::login($impersonator);

        return redirect()->route('users.show', $impersonatedId ?: $impersonator->id)
            ->with('success', trans('admin/users/message.impersonate.stopped'));
    }
}
