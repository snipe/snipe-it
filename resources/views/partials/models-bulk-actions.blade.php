<div id="modelsBulkEditToolbar">
    {{ Form::open([
              'method' => 'POST',
              'route' => ['models.bulkedit.index'],
              'class' => 'form-inline',
              'id' => 'modelsBulkForm']) }}

    @if (request('status')!='deleted')
        @can('delete', \App\Models\AssetModel::class)
            <div id="models-toolbar">
                <label for="bulk_actions" class="sr-only">{{ trans('general.bulk_actions') }}</label>
                <select name="bulk_actions" class="form-control select2" style="width: 200px;" aria-label="bulk_actions">
                    <option value="edit">{{ trans('general.bulk_edit') }}</option>
                    <option value="delete">{{ trans('general.bulk_delete') }}</option>
                </select>
                <button class="btn btn-primary" id="bulkModelsEditButton" disabled>{{ trans('button.go') }}</button>
            </div>
        @endcan
    @endif
    {{ Form::close() }}
</div>


