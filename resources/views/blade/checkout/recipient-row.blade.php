@props([
    'request',
    'requester',
    'companyId' => null,
    'maxQty' => null,
    'defaultChecked' => false,
    'showQty' => true,
])

{{-- One row of the bulk-fulfill form. Card-style layout: a full-
     width header (checkbox + #id + requester + inline notes
     preview) followed by the editable fields. Header spans the
     full column so the checkbox + requester read as a unit
     instead of getting squeezed into the form-horizontal label
     slot.

     Sign-in-place is deliberately absent. That flow assumes the
     requester is standing at the admin's device to sign in
     person; doesn't match a bulk batch where admin is processing
     multiple people from their own desk. Single-target checkout
     screens keep their sign-in-place checkbox unchanged.

     Field names are keyed by CheckoutRequest id:
         enabled_requests[]         = list of request ids ticked
         user_id[<request_id>]      = target user for that row
         qty[<request_id>]          = qty for that row
         notes[<request_id>]        = admin/checkout note for that row --}}

{{-- Full-width divider between rows. <hr> sits inside the
     .box-body's natural padding so it stops at the box edge
     instead of bleeding past like a `.form-group { border-top }`
     would (form-group inherits -15px lateral margins from
     Bootstrap's .row reset). --}}
<hr style="border-color: var(--table-border-row-color); margin-bottom: 15px;">

{{-- Row header: reuses <x-form.checkbox-inline> for the checkbox
     + requester-name label pair (wraps the checkbox in a
     `.form-control`-styled <label> so the name is a click
     target). Meta + notes drop below the checkbox visually
     since they're contextual, not editable. --}}
<div class="form-group">
    <div class="col-md-3">
        <x-form.checkbox-inline
            name="enabled_requests[{{ $request->id }}]"
            value="1"
            :checked="$defaultChecked || old('enabled_requests.'.$request->id) === '1'"
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

<x-input.user-select
    :label="trans('general.user')"
    name="user_id[{{ $request->id }}]"
    :selected="old('user_id.'.$request->id, $requester?->id)"
    :companyId="$companyId"
    wrapperId="fulfill-user-{{ $request->id }}"
    id="fulfill-user-select-{{ $request->id }}"
/>

@if ($showQty)
    <x-input.quantity
        name="qty[{{ $request->id }}]"
        :label="trans('general.qty')"
        :min="1"
        :max="$maxQty"
        :value="old('qty.'.$request->id, (int) $request->quantity)"
    />
@else
    {{-- Types where qty is meaningless (license = one seat per
         requester, asset = 1:1) hide the input but keep a
         hidden value=1 so the controller's per-row shape stays
         uniform across every requestable type. --}}
    <input type="hidden" name="qty[{{ $request->id }}]" value="1">
@endif

<x-form.row
    :label="trans('admin/hardware/form.notes')"
    :name="'notes['.$request->id.']'"
    type="textarea"
    :rows="2"
    :default="old('notes.'.$request->id, '')"
/>
