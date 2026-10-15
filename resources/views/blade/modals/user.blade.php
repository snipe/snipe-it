{{-- See snipeit_modals.js for what powers this. The password-generator
     wiring and first-input focus live in the modal-load callback there
     so the modal partial stays script-free. --}}
<x-modals
    :title="trans('admin/users/table.createuser')"
    :action="route('api.users.store')"
    submitToSelect2
>
    @if ($user->companies->isNotEmpty())
        <input type="hidden" name="company_id" value="{{ $user->companies->first()->id }}">
    @endif

    <x-input.company-select
        name="company_id"
        id="modal_company_id_select"
        :label="trans('general.company')"
    />

    <x-input.location-select
        name="location_id"
        id="modal_location_id_select"
        :label="trans('general.location')"
    />

    <x-form.row name="first_name" :label="trans('general.first_name')" id="modal-first_name" required />
    <x-form.row name="last_name" :label="trans('general.last_name')" id="modal-last_name" required />

    {{-- Email + username + password fields use the js-antifill-readonly
         pattern from users/edit.blade.php: readonly on load stops
         Firefox / Chrome / password managers from autofilling the
         admin's own stored credentials into a create-user form.
         onfocus removes readonly the moment the user actually clicks
         or tabs into the field, so keyboard + screen-reader flow is
         unaffected. --}}
    <x-form.row name="email" :label="trans('admin/users/table.email')" type="email">
        <x-slot:input>
            <input
                type="email"
                name="email"
                id="modal-email"
                class="form-control js-antifill-readonly"
                autocomplete="off"
                maxlength="191"
                onfocus="this.removeAttribute('readonly');"
                readonly
                aria-label="email"
            >
        </x-slot:input>
    </x-form.row>

    <x-form.row name="username" :label="trans('admin/users/table.username')">
        <x-slot:input>
            <input
                type="text"
                name="username"
                id="modal-username"
                class="form-control js-antifill-readonly"
                autocomplete="off"
                maxlength="191"
                onfocus="this.removeAttribute('readonly');"
                readonly
                required
                aria-label="username"
            >
        </x-slot:input>
    </x-form.row>

    {{-- Activated checkbox lives above the password fields because
         snipeit.js toggles password-field visibility off this checkbox.
         Defaults to unchecked because the modal is typically used to
         create a user on-the-fly for asset assignment, where login is
         not usually needed. --}}
    <div class="dynamic-form-row">
        <div class="col-md-offset-3 col-md-9">
            <label class="form-control">
                <input type="checkbox" value="1" name="activated" id="modal-activated" aria-label="activated">
                {{ trans('general.login_enabled') }}
            </label>
            <x-form.help name="modal-activated" icon="tip">
                {{ trans('admin/users/general.activated_password_required_help') }}
            </x-form.help>
        </div>
    </div>

    {{-- Password + confirmation start hidden, revealed by snipeit.js
         when the activated checkbox is checked. --}}
    <x-form.row name="password" :label="trans('admin/users/table.password')" style="display: none;">
        <x-slot:input>
            <div class="input-group">
                <input type="password" name="password" id="modal-password" class="form-control js-antifill-readonly" autocomplete="new-password" onfocus="this.removeAttribute('readonly');" readonly required>
                <span class="input-group-addon">
                    <i data-toggle="#modal-password" class="fa fa-fw fa-eye toggle-password" aria-hidden="true"></i>
                    <span class="sr-only">{{ trans('general.toggle_password_visibility') }}</span>
                </span>
            </div>
        </x-slot:input>
        <x-slot:after_input>
            <a href="#" class="btn btn-theme btn-sm" id="modal-genPassword" data-tooltip="true" title="{{ trans('admin/users/general.generate_password') }}">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </a>
        </x-slot:after_input>
    </x-form.row>

    <x-form.row name="password_confirmation" :label="trans('admin/users/table.password_confirm')" style="display: none;">
        <x-slot:input>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="modal-password_confirmation" class="form-control js-antifill-readonly" autocomplete="new-password" onfocus="this.removeAttribute('readonly');" readonly required>
                <span class="input-group-addon">
                    <i data-toggle="#modal-password_confirmation" class="fa fa-fw fa-eye toggle-password" aria-hidden="true"></i>
                    <span class="sr-only">{{ trans('general.toggle_password_visibility') }}</span>
                </span>
            </div>
        </x-slot:input>
    </x-form.row>

    <x-form.row name="display_name" :label="trans('admin/users/table.display_name')" id="modal-display_name" />
</x-modals>
