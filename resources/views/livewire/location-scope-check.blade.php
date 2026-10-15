<div>
    <label class="form-control{{ (!$is_tested || count($mismatched) > 0 ) ? ' form-control--disabled' : '' }}">
        <input type="checkbox" name="scope_locations_fmcs" value="1"
               @checked(old('scope_locations_fmcs', $setting->scope_locations_fmcs)) aria-label="scope_locations_fmcs" {{ (!$is_tested || count($mismatched) > 0) ? ' disabled' : '' }}/>
        {{ trans('admin/settings/general.scope_locations_fmcs_support_text') }}
    </label>
    <p class="help-block">
        {{ trans('admin/settings/general.scope_locations_fmcs_support_help_text') }}
        <strong>{{ ($is_tested && count($mismatched) > 0) ? trans('admin/settings/general.scope_locations_fmcs_support_disabled_text', ['count' => count($mismatched)]) : '' }}</strong>
        @if(!$is_tested)
            <strong>{{ trans('admin/settings/general.scope_locations_fmcs_test_needed') }}</strong>
        @endif
    </p>
    {{-- wire:loading + wire:target render a spinner icon only while the
         check_locations action is in progress, and we disable the button so a
         second click during the request can't queue a duplicate walk. --}}
    <button class="btn btn-sm btn-theme"
            wire:click.prevent="check_locations"
            wire:loading.attr="disabled"
            wire:target="check_locations">
        <x-icon type="spinner" wire:loading wire:target="check_locations"/>
        {{ trans('admin/settings/general.scope_locations_fmcs_check_button') }}
    </button>

    {{-- Download-full-report link. Shown only after the enable-check
         has run AND found mismatches. The endpoint runs the full walk of
         Helper::test_locations_fmcs and streams a CSV, so expect it to
         take longer than the enable-check on large datasets since it
         doesn't early-bail. --}}
    @if ($is_tested && count($mismatched) > 0)
        {{-- Use fetch() to know exactly when the response arrives (a hard-
             coded timeout would either fire too early on huge datasets
             or leave the button disabled longer than needed on small
             ones). The response is then handed to the browser via a
             synthetic anchor + revoked object URL, matching the
             `download` behavior a normal <a> would have produced. On
             any fetch error we fall back to a straight navigation so
             the user still gets their file even if the JS path fails
             (network hiccup, blob memory limit, etc.). --}}
        <a href="{{ route('settings.general.location_scoping_report') }}"
           class="btn btn-sm btn-default"
           style="margin-left: 6px;"
           x-data="{
               loading: false,
               async fetchReport(event) {
                   event.preventDefault();
                   if (this.loading) return;
                   this.loading = true;
                   const href = event.currentTarget.getAttribute('href');
                   try {
                       const resp = await fetch(href, { credentials: 'same-origin' });
                       if (! resp.ok) throw new Error('http ' + resp.status);
                       const blob = await resp.blob();
                       const dispo = resp.headers.get('Content-Disposition') || '';
                       const match = dispo.match(/filename=&quot;?([^&quot;;]+)&quot;?/i);
                       const filename = match ? match[1] : 'location-scoping-mismatches.csv';
                       const objUrl = URL.createObjectURL(blob);
                       const dl = document.createElement('a');
                       dl.href = objUrl;
                       dl.download = filename;
                       document.body.appendChild(dl);
                       dl.click();
                       dl.remove();
                       URL.revokeObjectURL(objUrl);
                   } catch (e) {
                       window.location.href = href;
                   } finally {
                       this.loading = false;
                   }
               }
           }"
           x-on:click="fetchReport($event)"
           x-bind:class="{ 'disabled': loading }"
           x-bind:aria-busy="loading">
            <x-icon type="download" x-show="!loading"/>
            <x-icon type="spinner" x-show="loading"/>
            {{ trans('admin/settings/general.scope_locations_fmcs_download_report') }}
        </a>
    @endif
</div>