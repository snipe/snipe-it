<div id="toolbar">
    {{ Form::open([
      'method' => 'POST',
      'route' => ['hardware/bulkedit'],
      'class' => 'form-inline',
      'id' => 'bulkForm']) }}


    <label for="bulk_actions">
        <span class="sr-only">
            {{ trans('button.bulk_actions') }}
        </span>
    </label>
    <select name="bulk_actions" class="form-control select2" aria-label="bulk_actions">
        <option value="edit">{{ trans('button.edit') }}</option>
        <option value="delete">{{ trans('button.delete') }}</option>
        <option value="labels">{{ trans_choice('button.generate_labels', 2) }}</option>
    </select>

    <button class="btn btn-primary" id="bulkEdit" disabled>{{ trans('button.go') }}</button>
    {{ Form::close() }}
</div>