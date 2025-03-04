{{-- See snipeit_modals.js for what powers this --}}
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">{{ trans('admin/models/table.create') }}</h2>
        </div>
        <div class="modal-body">
        <form action="{{ route('api.models.store') }}" onsubmit="return false">
            <div class="alert alert-danger" id="modal_error_msg" style="display:none">
            </div>
            @include('modals.partials.name', ['required' => 'true'])
            @include('modals.partials.categories-select', ['required' => 'true'])
            @include('modals.partials.manufacturer-select')
            @include('modals.partials.model-number')
            @include ('modals.partials.depreciation')
            @include ('modals.partials.minimum_quantity')
            @include ('modals.partials.eol_months')
            @include('modals.partials.fieldset-select')
            @include ('modals.partials.notes')
            @include ('modals.partials.requestable', ['requestable_text' => trans('admin/models/general.requestable')])

            <!-- Hidden input for created_by -->
            <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
        </form>
    </div>
    @include('modals.partials.footer')
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
