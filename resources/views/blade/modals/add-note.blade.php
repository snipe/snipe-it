@props(['type', 'id'])

{{-- See snipeit_modals.js for what powers this --}}
<x-modals
    id="createNoteModal"
    stacked
    :title="trans('general.add_note')"
    :action="route('notes.store')"
    form_attrs='accept-charset="UTF-8"'
>
    <input type="hidden" name="type" value="{{ $type }}">
    <input type="hidden" name="id" value="{{ $id }}">

    <div class="row">
        <div class="col-md-12">
            <textarea class="form-control" id="note" name="note" required>{{ old('note') }}</textarea>
            <x-form.error name="note" />
        </div>
    </div>
</x-modals>
