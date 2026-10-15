@props([
    'request',
    'requester',
    'availableAssets',
    'showQty' => true,
    'maxQty' => null,
    'defaultChecked' => false,
    'defaultAssetId' => null,
    'emptyMessage' => null,
])

{{-- Row variant of the bulk-fulfill form for types where the
     checkout target is an Asset (not a User):
       - Component installs INTO an asset (per-request, admin picks
         from the requester's assigned assets)
       - AssetModel fulfills via picking a specific Asset OF that
         model (from the model's available assets)

     The available-asset set is pre-computed by the controller
     (small, deterministic list) so the picker is a plain <select>
     rather than the ajax select2 - no pagination needed for the
     typical scope, and the "auto-pick next available" default just
     falls out of pre-selecting the first option.

     Rows whose available-asset set is empty render as a short
     info-only card (no fields, no submit checkbox) with an inline
     explanation so the admin sees WHY that requester can't be
     fulfilled from this screen. Rows with assets render the full
     picker + qty + notes shape.

     Field shape matches the user-target recipient-row:
         enabled_requests[]              = list of request ids ticked
         asset_id[<request_id>]          = target asset for that row
         qty[<request_id>]               = qty for that row (or 1 if showQty=false)
         notes[<request_id>]             = admin/checkout note --}}

<hr style="border-color: var(--table-border-row-color); margin-bottom: 15px;">

<div class="form-group" style="{{ $availableAssets->isEmpty() ? 'opacity: 0.7;' : '' }}">
    <div class="col-md-3">
        <x-form.checkbox-inline
            name="enabled_requests[{{ $request->id }}]"
            value="1"
            :checked="$defaultChecked || old('enabled_requests.'.$request->id) === '1'"
            :disabled="$availableAssets->isEmpty()"
            :label="$requester?->display_name ?? '#'.$request->id"
        />
    </div>
    <div class="col-md-7" style="padding-top: 7px;">
        @if ($request->notes)
            &ldquo;{{ $request->notes }}&rdquo;
        @endif
        <span class="text-muted">
            - {{ $request->created_at->diffForHumans() }}
        </span>
    </div>
</div>

@if ($availableAssets->isNotEmpty())
    {{-- Native <x-input.asset-select> is ajax-select2 backed and
         wants a data-endpoint feed; here we already have the small
         deterministic pool in hand and want a plain <select>, so
         hand-roll the picker inside a standard form-row shell. --}}
    <div
        @class([
            'form-group',
            'has-error' => $errors->has('asset_id.'.$request->id),
        ])
    >
        <label for="fulfill-asset-{{ $request->id }}" class="col-md-3 control-label">
            {{ trans('general.asset') }}
        </label>
        <div class="col-md-7">
            <select
                class="form-control select2"
                id="fulfill-asset-{{ $request->id }}"
                name="asset_id[{{ $request->id }}]"
                aria-label="{{ trans('general.asset') }}"
            >
                @foreach ($availableAssets as $asset)
                    <option
                        value="{{ $asset->id }}"
                        @selected(old('asset_id.'.$request->id, $defaultAssetId ?? $availableAssets->first()->id) == $asset->id)
                    >
                        {{ $asset->present()->fullName }}
                    </option>
                @endforeach
            </select>
            <x-form.error :name="'asset_id.'.$request->id"/>
        </div>
    </div>

    @if ($showQty)
        <x-input.quantity
            name="qty[{{ $request->id }}]"
            :label="trans('general.qty')"
            :min="1"
            :max="$maxQty"
            :value="old('qty.'.$request->id, (int) $request->quantity)"
        />
    @else
        {{-- AssetModel rows fulfill one asset per request, so qty
             is fixed at 1. Hidden input keeps the POST shape
             uniform with the qty-tracked types. --}}
        <input type="hidden" name="qty[{{ $request->id }}]" value="1">
    @endif

    <x-form.row
        :label="trans('admin/hardware/form.notes')"
        :name="'notes['.$request->id.']'"
        type="textarea"
        :rows="2"
        :default="old('notes.'.$request->id, '')"
    />
@endif
