@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.branding_title') }}
    @parent
@stop

{{-- Page content --}}
@section('content')

    <x-container class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
        <x-form :route="route('settings.branding.save')">
            <x-box top_submit>
                <x-slot:header>
                    <x-icon type="branding"/> {{ trans('admin/settings/general.brand') }}
                </x-slot:header>

                {{-- Single demo-mode banner at the top so users don't wonder why
                     changes silently fail. Renders nothing outside demo mode. --}}
                <x-demo-callout />

                <div class="col-md-12">

                    {{-- Site name --}}
                    <x-form.row name="site_name" :label="trans('admin/settings/general.site_name')">
                        <x-slot:input>
                            <x-input.text
                                name="site_name"
                                :value="old('site_name', $setting->site_name)"
                                :required="! config('app.lock_passwords')"
                                :maxlength="191"
                                placeholder="Snipe-IT Asset Management"
                                :disabled="config('app.lock_passwords')"
                            />
                        </x-slot:input>
                    </x-form.row>

                    <fieldset name="color-preferences">
                        <x-form.legend help_text="{!! trans('admin/settings/general.color_settings_help') !!}">
                            {{ trans('admin/settings/general.color_preferences') }}
                        </x-form.legend>

                        {{-- Header color. Only this colorpicker gets div_id
                             set — its live-preview JS handler binds to
                             #header-color as the outer div selector. --}}
                        <x-form.row
                            :label="trans('admin/settings/general.header_color')"
                            name="header_color"
                            :help_text="trans('admin/settings/general.header_color_help')"
                            input_div_class="col-md-9"
                        >
                            <x-slot:input>
                                <x-input.colorpicker
                                    :item="$setting"
                                    name="header_color"
                                    id="header_color"
                                    div_id="header-color"
                                    default="#3c8dbc"
                                    placeholder="#3c8dbc"
                                />
                            </x-slot:input>
                        </x-form.row>

                        {{-- Nav link color --}}
                        <x-form.row
                            :label="trans('admin/settings/general.nav_link_color')"
                            name="nav_link_color"
                            :help_text="trans('admin/settings/general.nav_link_color_help')"
                            input_div_class="col-md-9"
                        >
                            <x-slot:input>
                                <x-input.colorpicker
                                    :item="$setting"
                                    name="nav_link_color"
                                    id="nav_link_color"
                                    div_id="nav-link-color"
                                    default="#ffffff"
                                    placeholder="#ffffff"
                                />
                            </x-slot:input>
                        </x-form.row>

                        {{-- Light link color --}}
                        <x-form.row
                            :label="trans('admin/settings/general.link_light_color')"
                            name="link_light_color"
                            :help_text="trans('admin/settings/general.link_light_color_help')"
                            input_div_class="col-md-9"
                        >
                            <x-slot:input>
                                <x-input.colorpicker
                                    :item="$setting"
                                    name="link_light_color"
                                    id="link_light_color"
                                    div_id="link-light-color"
                                    default="#296282"
                                    placeholder="#296282"
                                />
                            </x-slot:input>
                        </x-form.row>

                        {{-- Dark link color --}}
                        <x-form.row
                            :label="trans('admin/settings/general.link_dark_color')"
                            name="link_dark_color"
                            :help_text="trans('admin/settings/general.link_dark_color_help')"
                            input_div_class="col-md-9"
                        >
                            <x-slot:input>
                                <x-input.colorpicker
                                    :item="$setting"
                                    name="link_dark_color"
                                    id="link_dark_color"
                                    div_id="link-dark-color"
                                    default="#5fa4cc"
                                    placeholder="#5fa4cc"
                                />
                            </x-slot:input>
                        </x-form.row>

                        {{-- Reset-to-defaults action row. Not a form field —
                             the button just resets the four color pickers to
                             their stock hex codes via the JS handler below. --}}
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <p class="form-control-static" style="padding-top: 7px;">
                                    <button type="button" id="branding-colors-reset" class="btn btn-theme">
                                        {{ trans('admin/settings/general.color_reset') }}
                                    </button>
                                </p>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset name="logo-preferences">
                        <x-form.legend>
                            {{ trans('admin/settings/general.legends.logos') }}
                        </x-form.legend>

                        {{-- Branding style: text-only, logo-only, or both. --}}
                        <x-form.row
                            :label="trans('admin/settings/general.web_brand')"
                            name="brand"
                            input_div_class="col-md-9"
                        >
                            <x-slot:input>
                                <x-input.select
                                    name="brand"
                                    id="brand"
                                    :options="[
                                        '1' => trans('admin/settings/general.logo_option_types.text'),
                                        '2' => trans('admin/settings/general.logo_option_types.logo'),
                                        '3' => trans('admin/settings/general.logo_option_types.logo_and_text'),
                                    ]"
                                    :selected="old('brand', $setting->brand)"
                                    class="form-control"
                                    style="width: 150px"
                                />
                            </x-slot:input>
                        </x-form.row>

                        {{-- Logo --}}
                        @include('partials/forms/edit/uploadLogo', [
                            'logoVariable' => 'logo',
                            'logoId' => 'uploadLogo',
                            'logoLabel' => trans('admin/settings/general.logo_labels.logo'),
                            'logoClearVariable' => 'clear_logo',
                            'previewClass' => 'header-preview',
                            'helpBlock' => trans('general.logo_size') . trans('general.image_filetypes_help', ['size' => Helper::file_upload_max_size_readable()]),
                        ])

                        {{-- Email logo --}}
                        @include('partials/forms/edit/uploadLogo', [
                            'logoVariable' => 'email_logo',
                            'logoId' => 'uploadEmailLogo',
                            'logoLabel' => trans('admin/settings/general.logo_labels.email_logo'),
                            'logoClearVariable' => 'clear_email_logo',
                            'helpBlock' => trans('general.image_filetypes_help', ['size' => Helper::file_upload_max_size_readable()]),
                        ])

                        {{-- Label logo --}}
                        @include('partials/forms/edit/uploadLogo', [
                            'logoVariable' => 'label_logo',
                            'logoId' => 'uploadLabelLogo',
                            'logoLabel' => trans('admin/settings/general.logo_labels.label_logo'),
                            'logoClearVariable' => 'clear_label_logo',
                            'helpBlock' => trans('general.image_filetypes_help', ['size' => Helper::file_upload_max_size_readable()]),
                        ])

                        {{-- PDF logo --}}
                        @include('partials/forms/edit/uploadLogo', [
                            'logoVariable' => 'acceptance_pdf_logo',
                            'logoId' => 'acceptancePdfEmailLogo',
                            'logoLabel' => trans('admin/settings/general.logo_labels.acceptance_pdf_logo'),
                            'logoClearVariable' => 'clear_acceptance_pdf_logo',
                            'helpBlock' => trans('general.image_filetypes_help', ['size' => Helper::file_upload_max_size_readable()]),
                        ])

                        {{-- Favicon --}}
                        @include('partials/forms/edit/uploadLogo', [
                            'logoVariable' => 'favicon',
                            'logoId' => 'uploadFavicon',
                            'logoLabel' => trans('admin/settings/general.logo_labels.favicon'),
                            'logoClearVariable' => 'clear_favicon',
                            'helpBlock' => trans('admin/settings/general.favicon_size') . ' ' . trans('admin/settings/general.favicon_format'),
                            'allowedTypes' => 'image/x-icon,image/gif,image/jpeg,image/png,image/svg,image/svg+xml,image/vnd.microsoft.icon',
                            'maxSize' => 20000,
                        ])

                        {{-- Default avatar --}}
                        @include('partials/forms/edit/uploadLogo', [
                            'logoVariable' => 'default_avatar',
                            'logoId' => 'defaultAvatar',
                            'logoLabel' => trans('admin/settings/general.default_avatar'),
                            'logoClearVariable' => 'clear_default_avatar',
                            'logoPath' => 'avatars/',
                            'helpBlock' => trans('admin/settings/general.default_avatar_help') . ' ' . trans('general.image_filetypes_help', ['size' => Helper::file_upload_max_size_readable()]),
                        ])

                        {{-- Restore default avatar. Uses a label with embedded
                             HTML link, which isn't expressible via the checkbox
                             component's escaped label prop, so this one stays
                             hand-rolled. Only surfaces when the operator has
                             no avatar configured or the default.png is missing
                             from disk. --}}
                        @if (($setting->default_avatar == '') || (($setting->default_avatar == 'default.png') && (Storage::disk('public')->missing('default.png'))))
                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <label class="form-control">
                                        <input type="checkbox" name="restore_default_avatar" value="1" @checked(old('restore_default_avatar', $setting->restore_default_avatar)) />
                                        <span>{!! trans('admin/settings/general.restore_default_avatar', ['default_avatar' => Storage::disk('public')->url('default.png')]) !!}</span>
                                    </label>
                                    <p class="help-block">
                                        {{ trans('admin/settings/general.restore_default_avatar_help') }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- Load remote gravatars --}}
                        <x-form.checkbox-row
                            name="load_remote"
                            :section_label="trans('admin/settings/general.load_remote')"
                            :label="trans('general.yes')"
                            :help_text="trans('admin/settings/general.load_remote_help_text')"
                            :item="$setting"
                            input_div_class="col-md-9"
                        />

                        {{-- Include logo when printing assets --}}
                        <x-form.checkbox-row
                            name="logo_print_assets"
                            :section_label="trans('admin/settings/general.logo_print_assets')"
                            :label="trans('admin/settings/general.logo_print_assets_help')"
                            :item="$setting"
                            input_div_class="col-md-9"
                        />

                        {{-- Show URLs in emails --}}
                        <x-form.checkbox-row
                            name="show_url_in_emails"
                            :section_label="trans('admin/settings/general.show_url_in_emails')"
                            :label="trans('general.yes')"
                            :help_text="trans('admin/settings/general.show_url_in_emails_help_text')"
                            :item="$setting"
                            input_div_class="col-md-9"
                        />
                    </fieldset>

                    <fieldset name="css-preferences">
                        <x-form.legend>
                            {{ trans('admin/settings/general.custom_css') }}
                        </x-form.legend>

                        {{-- Custom CSS. help_html must use the static-attribute
                             + {!! !!} form; the :help_html="trans(...)" dynamic
                             binding runs the string through
                             BladeCompiler::sanitizeComponentAttribute() which
                             turns the <style> tags in the help text into
                             literal &lt;style&gt; entities. --}}
                        <x-form.row name="custom_css" :label="trans('admin/settings/general.custom_css')" help_html="{!! trans('admin/settings/general.custom_css_help') !!}">
                            <x-slot:input>
                                <x-input.textarea
                                    name="custom_css"
                                    :value="old('custom_css', $setting->custom_css)"
                                    placeholder="{{ trans('admin/settings/general.custom_css_placeholder') }}"
                                    aria-label="custom_css"
                                    :disabled="config('app.lock_passwords')"
                                />
                            </x-slot:input>
                        </x-form.row>
                    </fieldset>

                    <fieldset name="footer-preferences">
                        <x-form.legend>
                            {{ trans('admin/settings/general.legends.footer') }}
                        </x-form.legend>

                        {{-- Support footer --}}
                        <x-form.row name="support_footer" :label="trans('admin/settings/general.support_footer')">
                            <x-slot:input>
                                <x-input.select
                                    name="support_footer"
                                    id="support_footer"
                                    :options="['on' => trans('admin/settings/general.enabled'), 'off' => trans('admin/settings/general.two_factor_disabled'), 'admin' => trans('admin/settings/general.super_admin_only')]"
                                    :selected="old('support_footer', $setting->support_footer)"
                                    class="form-control"
                                    style="width: 150px"
                                    :disabled="config('app.lock_passwords')"
                                />
                            </x-slot:input>
                        </x-form.row>

                        {{-- Version footer --}}
                        <x-form.row name="version_footer" :label="trans('admin/settings/general.version_footer')" :help_text="trans('admin/settings/general.version_footer_help')">
                            <x-slot:input>
                                <x-input.select
                                    name="version_footer"
                                    id="version_footer"
                                    :options="['on' => trans('admin/settings/general.enabled'), 'off' => trans('admin/settings/general.two_factor_disabled'), 'admin' => trans('admin/settings/general.super_admin_only')]"
                                    :selected="old('version_footer', $setting->version_footer)"
                                    class="form-control"
                                    style="width: 150px"
                                    :disabled="config('app.lock_passwords')"
                                />
                            </x-slot:input>
                        </x-form.row>

                        {{-- Additional footer text --}}
                        <x-form.row name="footer_text" :label="trans('admin/settings/general.footer_text')" help_html="{!! trans('admin/settings/general.footer_text_help') !!}">
                            <x-slot:input>
                                <x-input.textarea
                                    name="footer_text"
                                    :value="old('footer_text', $setting->footer_text)"
                                    rows="4"
                                    aria-labelledby="footer_text"
                                    placeholder="{{ trans('admin/settings/general.footer_text_placeholder') }}"
                                    :disabled="config('app.lock_passwords')"
                                />
                            </x-slot:input>
                        </x-form.row>
                    </fieldset>

                </div>

                {{-- Explicit footer preserves the demo-mode-disabled save state
                     that the default x-box.footer doesn't offer. --}}
                <x-slot:customfooter>
                    <div class="box-footer">
                        <div class="text-left col-md-6">
                            <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                        </div>
                        <div class="text-right col-md-6">
                            <x-button.submit :disabled="config('app.lock_passwords') === true" />
                        </div>
                    </div>
                </x-slot:customfooter>
            </x-box>
        </x-form>
    </x-container>

@stop

