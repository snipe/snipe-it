@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.bulk_edit') }}
    @parent
@stop

@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-sm btn-theme pull-right">
        {{ trans('general.back') }}
    </a>
@stop

{{-- Page content --}}
@section('content')

    <x-container class="col-md-8 col-md-offset-2">

        <p>{{ trans('admin/users/general.bulk_update_help') }}</p>

        <x-callout type="warning" icon="warning" live="assertive">
            {{ trans('admin/users/general.bulk_update_warn', ['user_count' => count($users)]) }}
        </x-callout>

        <x-form :route="route('users/bulkeditsave')">
            <x-box>

                <x-demo-callout />

                <x-input.department-select
                    :label="trans('general.department')"
                    name="department_id"
                    :selected="old('department_id')"
                />
                <x-form.checkbox-row
                    name="null_department_id"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.department'), 'user_count' => count($users)])"
                />

                <x-input.location-select
                    :label="trans('general.location')"
                    name="location_id"
                    :selected="old('location_id')"
                />
                <x-form.checkbox-row
                    name="null_location_id"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.location'), 'user_count' => count($users)])"
                />

                {{-- Company (gated on the FMCS + acting user check) --}}
                @if (\App\Models\Company::canManageUsersCompanies())
                    <x-input.company-select
                        :label="trans('general.select_company')"
                        name="company_ids"
                        :multiple="true"
                        :selected="old('company_ids')"
                    />
                    <x-form.checkbox-row
                        name="null_company_ids"
                        :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.companies'), 'user_count' => count($users)])"
                    />
                @endif

                {{-- Manager --}}
                <x-input.user-select
                    :label="trans('admin/users/table.manager')"
                    name="manager_id"
                    :selected="old('manager_id')"
                />
                <x-form.checkbox-row
                    name="null_manager_id"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('admin/users/table.manager'), 'user_count' => count($users)])"
                />

                {{-- Language --}}
                <x-form.row :label="trans('general.language')" name="locale" input_div_class="col-md-8">
                    <x-slot:input>
                        <x-input.locale-select name="locale" :selected="old('locale', '')"/>
                    </x-slot:input>
                </x-form.row>
                <x-form.checkbox-row
                    name="null_locale"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.language'), 'user_count' => count($users)])"
                />

                {{-- City --}}
                <x-form.row :label="trans('general.city')" name="city" type="text" input_div_class="col-md-4"/>
                <x-form.checkbox-row
                    name="null_city"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.city'), 'user_count' => count($users)])"
                />

                {{-- State --}}
                <x-form.row :label="trans('general.state')" name="state" type="text" input_div_class="col-md-4"/>
                <x-form.checkbox-row
                    name="null_state"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.state'), 'user_count' => count($users)])"
                />

                {{-- Country --}}
                <x-form.row :label="trans('general.country')" name="country" input_div_class="col-md-4">
                    <x-slot:input>
                        <x-input.country-select name="country" :selected="old('country', '')" />
                    </x-slot:input>
                </x-form.row>
                <x-form.checkbox-row
                    name="null_country"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.country'), 'user_count' => count($users)])"
                />

                {{-- Zip --}}
                <x-form.row :label="trans('general.zip')" name="zip" type="text" :maxlength="10" input_div_class="col-md-4"/>
                <x-form.checkbox-row
                    name="null_zip"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.zip'), 'user_count' => count($users)])"
                />

                {{-- Address --}}
                <x-form.row :label="trans('general.address')" name="address" type="text" input_div_class="col-md-4"/>
                <x-form.checkbox-row
                    name="null_address"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.address'), 'user_count' => count($users)])"
                />

                {{-- Phone --}}
                <x-form.row :label="trans('admin/users/table.phone')" name="phone" type="text" input_div_class="col-md-4"/>
                <x-form.checkbox-row
                    name="null_phone"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('admin/users/table.phone'), 'user_count' => count($users)])"
                />

                {{-- Job title --}}
                <x-form.row :label="trans('admin/users/table.title')" name="jobtitle" type="text" input_div_class="col-md-4"/>
                <x-form.checkbox-row
                    name="null_jobtitle"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('admin/users/table.title'), 'user_count' => count($users)])"
                />

                {{-- Employee number: clear-only, since employee numbers are
                     unique per user and can't be bulk-set to a shared value. --}}
                <x-form.checkbox-row
                    name="null_employee_num"
                    :section_label="trans('general.employee_number')"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.employee_number'), 'user_count' => count($users)])"
                    input_div_class="col-md-9"
                />

                {{-- Website --}}
                <x-form.row :label="trans('general.website')" name="website" type="url" input_div_class="col-md-4"/>
                <x-form.checkbox-row
                    name="null_website"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.website'), 'user_count' => count($users)])"
                />

                {{-- Remote worker --}}
                <x-form.radio-row
                    name="remote"
                    :label="trans('admin/users/general.remote')"
                    :options="[
                        '' => trans('general.do_not_change'),
                        '1' => trans('admin/users/general.remote_label'),
                        '0' => trans('admin/users/general.not_remote_label'),
                    ]"
                    selected=""
                    input_div_class="col-md-9"
                />

                {{-- LDAP-managed passwords. Radio values look inverted vs the
                     label text — "0" = allow user management, "1" = disallow.
                     Preserved from the pre-rewrite markup on purpose. --}}
                <x-form.radio-row
                    name="ldap_import"
                    :label="trans('general.user_managed_passwords')"
                    :options="[
                        '' => trans('general.do_not_change'),
                        '0' => trans('general.user_managed_passwords_allow'),
                        '1' => trans('general.user_managed_passwords_disallow'),
                    ]"
                    selected=""
                    :help_text="trans('general.user_managed_passwords_bulk_help')"
                    input_div_class="col-md-9"
                />

                {{-- Autoassign licenses --}}
                <x-form.radio-row
                    name="autoassign_licenses"
                    :label="trans('general.autoassign_licenses')"
                    :options="[
                        '' => trans('general.do_not_change'),
                        '1' => trans('general.autoassign_licenses_help'),
                        '0' => trans('general.no_autoassign_licenses_help'),
                    ]"
                    selected=""
                    input_div_class="col-md-9"
                />

                {{-- Login enabled --}}
                <x-form.radio-row
                    name="activated"
                    :label="trans('general.login_enabled')"
                    :options="[
                        '' => trans('general.do_not_change'),
                        '1' => trans('admin/users/general.user_activated'),
                        '0' => trans('admin/users/general.user_deactivated'),
                    ]"
                    selected=""
                    input_div_class="col-md-9"
                />

                {{-- Email. Auth-sensitive: the controller only applies this
                     to users the acting user is permitted to edit. --}}
                <x-form.row :label="trans('admin/users/table.email')" name="email" type="email" input_div_class="col-md-4"/>
                <x-form.checkbox-row
                    name="null_email"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('admin/users/table.email'), 'user_count' => count($users)])"
                />

                {{-- Groups. Superuser-only; anyone else sees a static
                     "you don't have permission" help block instead of the
                     picker. Wrapped in a custom slot:input so the two
                     branches share the form.row scaffolding. --}}
                <x-form.row :label="trans('general.groups')" name="groups" input_div_class="col-md-6">
                    <x-slot:input>
                        @if ((config('app.lock_passwords') || (! Auth::user()->isSuperUser())))
                            <p class="help-block">{{ trans('admin/users/general.group_memberships_helpblock') }}</p>
                        @else
                            <select name="groups[]" id="groups[]" multiple="multiple" class="form-control" aria-label="groups">
                                <option value="">{{ trans('admin/users/general.remove_group_memberships') }}</option>
                                @foreach ($groups as $id => $group)
                                    <option value="{{ $id }}">{{ $group }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ trans('admin/users/table.groupnotes') }}</span>
                        @endif
                    </x-slot:input>
                </x-form.row>

                {{-- Display name + inline null-toggle. Kept as hand-rolled
                     markup because the null checkbox sits in a sibling
                     col-md-5 next to the input, not stacked below like the
                     other rows above. Uses trans key general.set_to_null
                     (singular selection_count) rather than the field-
                     specific set_users_field_to_null used by stacked rows. --}}
                <div class="form-group {{ $errors->has('display_name') ? 'has-error' : '' }}">
                    <label for="display_name" class="col-md-3 control-label">{{ trans('admin/users/table.display_name') }}</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="{{ trans('admin/users/table.display_name') }}" name="display_name" id="display_name" value="{{ old('display_name') }}">
                        <x-form.error name="display_name" />
                    </div>
                    <div class="col-md-5">
                        <label class="form-control">
                            <input type="checkbox" name="null_display_name" value="1" />
                            {{ trans_choice('general.set_to_null', count($users), ['selection_count' => count($users)]) }}
                        </label>
                    </div>
                </div>

                {{-- Start date + inline null-toggle. See display_name for
                     why this is hand-rolled. --}}
                <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                    <label for="start_date" class="col-md-3 control-label">{{ trans('general.start_date') }}</label>
                    <div class="col-md-4">
                        <x-input.datepicker
                            name="start_date"
                            value="{{ old('start_date') }}"
                            placeholder="{{ trans('general.select_date') }}"
                        />
                        <x-form.error name="start_date" />
                    </div>
                    <div class="col-md-5">
                        <label class="form-control">
                            <input type="checkbox" name="null_start_date" value="1">
                            {{ trans_choice('general.set_to_null', count($users), ['selection_count' => count($users)]) }}
                        </label>
                    </div>
                </div>

                {{-- End date + inline null-toggle. See display_name for
                     why this is hand-rolled. --}}
                <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                    <label for="end_date" class="col-md-3 control-label">{{ trans('general.end_date') }}</label>
                    <div class="col-md-4">
                        <x-input.datepicker
                            name="end_date"
                            value="{{ old('end_date') }}"
                            placeholder="{{ trans('general.select_date') }}"
                        />
                        <x-form.error name="end_date" />
                    </div>
                    <div class="col-md-5">
                        <label class="form-control">
                            <input type="checkbox" name="null_end_date" value="1">
                            {{ trans_choice('general.set_to_null', count($users), ['selection_count' => count($users)]) }}
                        </label>
                    </div>
                </div>

                {{-- Notes --}}
                <x-form.row :label="trans('general.notes')" name="notes" type="textarea" :rows="4" input_div_class="col-md-6"/>
                <x-form.checkbox-row
                    name="null_notes"
                    :label="trans_choice('general.set_users_field_to_null', count($users), ['field' => trans('general.notes'), 'user_count' => count($users)])"
                />

                @foreach ($users as $user)
                    <input type="hidden" name="ids[{{ $user->id }}]" value="{{ $user->id }}">
                @endforeach

                <x-slot:customfooter>
                    <div class="box-footer text-right">
                        <a class="btn btn-link pull-left" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
                        <x-button.submit class="btn-success" :label="trans('general.update')" :disabled="config('app.lock_passwords')" />
                    </div>
                </x-slot:customfooter>

            </x-box>
        </x-form>

    </x-container>

@stop
